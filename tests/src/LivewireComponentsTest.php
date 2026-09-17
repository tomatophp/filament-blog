<?php

use Filament\Actions\Testing\TestAction;
use TomatoPHP\FilamentBlog\Livewire\CommentPost;
use TomatoPHP\FilamentBlog\Livewire\LikePost;
use TomatoPHP\FilamentBlog\Models\AccountLog;
use TomatoPHP\FilamentBlog\Models\Comment;
use TomatoPHP\FilamentBlog\Models\Like;

use function Pest\Livewire\livewire;

it('likes and unlikes a post for the signed in account', function () {
    $post = blogPost();
    $account = blogAccount();
    $this->actingAs($account, 'accounts');

    livewire(LikePost::class, ['post' => $post])
        ->assertSuccessful()
        ->callAction('like');

    expect(Like::query()->where('account_id', $account->id)->where('post_id', $post->id)->exists())->toBeTrue()
        ->and($post->refresh()->likes)->toEqual(1)
        ->and(AccountLog::query()->where('action', 'like')->count())->toBe(1);

    livewire(LikePost::class, ['post' => $post])->callAction('like');

    expect(Like::query()->count())->toBe(0)
        ->and($post->refresh()->likes)->toEqual(0);
});

it('sends guests to the user panel login when they like a post', function () {
    livewire(LikePost::class, ['post' => blogPost()])
        ->callAction('like')
        ->assertRedirect(url('app/login'));

    expect(Like::query()->count())->toBe(0);
});

it('adds, edits and deletes a comment for the signed in account', function () {
    $post = blogPost();
    $account = blogAccount();
    $this->actingAs($account, 'accounts');

    livewire(CommentPost::class, ['post' => $post])
        ->assertSuccessful()
        ->fillForm(['comment' => 'Great post'])
        ->callAction('sendAction')
        ->assertHasNoFormErrors();

    $comment = Comment::query()->firstOrFail();

    expect($comment->comment)->toBe('Great post')
        ->and($comment->user_id)->toBe($account->id)
        ->and($comment->user_type)->toBe($account->getMorphClass())
        ->and($comment->content_id)->toBe($post->id)
        ->and(AccountLog::query()->where('action', 'comment')->count())->toBe(1);

    livewire(CommentPost::class, ['post' => $post])
        ->assertSee('Great post')
        ->callAction(TestAction::make('editAction')->arguments(['comment' => $comment->id]), ['comment' => 'Edited comment']);

    expect($comment->refresh()->comment)->toBe('Edited comment');

    livewire(CommentPost::class, ['post' => $post])
        ->callAction(TestAction::make('deleteAction')->arguments(['comment' => $comment->id]));

    expect(Comment::query()->count())->toBe(0);
});

it('does not let an account edit or delete comments of another account', function () {
    $post = blogPost();
    $owner = blogAccount();
    $comment = Comment::query()->create([
        'user_id' => $owner->id,
        'user_type' => $owner->getMorphClass(),
        'content_id' => $post->id,
        'content_type' => $post->getMorphClass(),
        'comment' => 'Owner comment',
        'is_active' => true,
    ]);

    $this->actingAs(blogAccount(), 'accounts');

    livewire(CommentPost::class, ['post' => $post])
        ->callAction(TestAction::make('deleteAction')->arguments(['comment' => $comment->id]));

    expect(Comment::query()->whereKey($comment->id)->exists())->toBeTrue();
});

it('requires a comment body', function () {
    $this->actingAs(blogAccount(), 'accounts');

    livewire(CommentPost::class, ['post' => blogPost()])
        ->fillForm(['comment' => ''])
        ->callAction('sendAction')
        ->assertHasFormErrors(['comment' => 'required']);

    expect(Comment::query()->count())->toBe(0);
});

it('shows the comment form only to signed in accounts', function () {
    livewire(CommentPost::class, ['post' => blogPost()])
        ->assertSuccessful()
        ->assertActionHidden('sendAction');
});

it('strips raw html and unsafe links from comments', function () {
    $post = blogPost();
    $account = blogAccount();

    Comment::query()->create([
        'user_id' => $account->id,
        'user_type' => $account->getMorphClass(),
        'content_id' => $post->id,
        'content_type' => $post->getMorphClass(),
        'comment' => "**bold** <script>alert('xss')</script> [link](javascript:alert(1))",
        'is_active' => true,
    ]);

    livewire(CommentPost::class, ['post' => $post])
        ->assertSeeHtml('<strong>bold</strong>')
        ->assertDontSeeHtml('<script>alert')
        ->assertDontSeeHtml('javascript:alert');
});

it('renders the like and comment components on the post page', function () {
    $post = blogPost();
    $account = blogAccount();
    $this->actingAs($account, 'accounts');

    Comment::query()->create([
        'user_id' => $account->id,
        'user_type' => $account->getMorphClass(),
        'content_id' => $post->id,
        'content_type' => $post->getMorphClass(),
        'comment' => 'A visible comment',
        'is_active' => true,
    ]);

    $this->get('/en/blog/'.$post->slug)
        ->assertOk()
        ->assertSeeLivewire(LikePost::class)
        ->assertSeeLivewire(CommentPost::class)
        ->assertSee('A visible comment');
});
