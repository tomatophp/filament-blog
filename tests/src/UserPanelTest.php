<?php

use Filament\Facades\Filament;
use TomatoPHP\FilamentBlog\Filament\Resources\CommentResource\Pages\ManageComments;
use TomatoPHP\FilamentBlog\Filament\Resources\LikeResource\Pages\ManageLikes;
use TomatoPHP\FilamentBlog\Filament\Widgets\StateWidget;
use TomatoPHP\FilamentBlog\Models\Comment;
use TomatoPHP\FilamentBlog\Models\Like;

use function Pest\Livewire\livewire;

beforeEach(function () {
    Filament::setCurrentPanel('app');

    $this->account = blogAccount();
    $this->actingAs($this->account, 'accounts');
});

function commentBy(object $account, object $post, string $text): Comment
{
    return Comment::query()->create([
        'user_id' => $account->id,
        'user_type' => $account->getMorphClass(),
        'content_id' => $post->id,
        'content_type' => $post->getMorphClass(),
        'comment' => $text,
        'is_active' => true,
    ]);
}

it('lists only the comments of the signed in account', function () {
    $post = blogPost();
    $own = commentBy($this->account, $post, 'Mine');
    $other = commentBy(blogAccount(), $post, 'Not mine');

    livewire(ManageComments::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords([$own])
        ->assertCanNotSeeTableRecords([$other]);
});

it('edits and deletes an own comment from the user panel', function () {
    $comment = commentBy($this->account, blogPost(), 'Before');

    livewire(ManageComments::class)
        ->callTableAction('edit', $comment, ['comment' => 'After'])
        ->assertHasNoTableActionErrors();

    expect($comment->refresh()->comment)->toBe('After');

    livewire(ManageComments::class)->callTableAction('delete', $comment);

    expect(Comment::query()->count())->toBe(0);
});

it('lists only the likes of the signed in account and keeps the counter in sync on delete', function () {
    $post = blogPost();
    $own = Like::query()->create(['account_id' => $this->account->id, 'post_id' => $post->id]);
    $other = Like::query()->create(['account_id' => blogAccount()->id, 'post_id' => $post->id]);

    expect($post->refresh()->likes)->toEqual(2);

    livewire(ManageLikes::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords([$own])
        ->assertCanNotSeeTableRecords([$other])
        ->callTableAction('delete', $own);

    expect($post->refresh()->likes)->toEqual(1);
});

it('renders the stats widget with the account counters', function () {
    $post = blogPost();
    commentBy($this->account, $post, 'One');
    Like::query()->create(['account_id' => $this->account->id, 'post_id' => $post->id]);

    livewire(StateWidget::class)
        ->assertSuccessful()
        ->assertSee(trans('filament-blog::messages.widgets.likes'))
        ->assertSee(trans('filament-blog::messages.widgets.comments'));
});
