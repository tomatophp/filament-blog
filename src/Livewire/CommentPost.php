<?php

namespace TomatoPHP\FilamentBlog\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use TomatoPHP\FilamentBlog\FilamentBlog;
use TomatoPHP\FilamentBlog\Models\Comment;
use TomatoPHP\FilamentBlog\Services\Interactions;
use TomatoPHP\FilamentCms\Models\Post;

/**
 * @property-read Schema $form
 */
class CommentPost extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public Post $post;

    public function mount(Post $post): void
    {
        $this->post = $post;
        $this->form->fill(['comment' => '']);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                MarkdownEditor::make('comment')
                    ->label(trans('filament-blog::messages.comments.comment'))
                    ->required(),
            ])
            ->statePath('data');
    }

    public function editAction(): Action
    {
        return Action::make('editAction')
            ->iconButton()
            ->tooltip(trans('filament-blog::messages.comments.edit'))
            ->label(trans('filament-blog::messages.comments.edit'))
            ->color('warning')
            ->icon('heroicon-o-pencil')
            ->fillForm(fn (array $arguments): array => [
                'comment' => $this->findOwnComment($arguments)?->comment,
            ])
            ->schema([
                MarkdownEditor::make('comment')
                    ->label(trans('filament-blog::messages.comments.comment'))
                    ->required(),
            ])
            ->action(function (array $arguments, array $data): void {
                $this->findOwnComment($arguments)?->update([
                    'comment' => $data['comment'],
                ]);

                Notification::make()
                    ->title(trans('filament-blog::messages.comments.notifications.edit.title'))
                    ->body(trans('filament-blog::messages.comments.notifications.edit.body'))
                    ->success()
                    ->send();
            });
    }

    public function deleteAction(): Action
    {
        return Action::make('deleteAction')
            ->requiresConfirmation()
            ->iconButton()
            ->tooltip(trans('filament-blog::messages.comments.delete'))
            ->label(trans('filament-blog::messages.comments.delete'))
            ->color('danger')
            ->icon('heroicon-o-trash')
            ->action(function (array $arguments): void {
                $this->findOwnComment($arguments)?->delete();

                Notification::make()
                    ->title(trans('filament-blog::messages.comments.notifications.delete.title'))
                    ->body(trans('filament-blog::messages.comments.notifications.delete.body'))
                    ->success()
                    ->send();
            });
    }

    public function sendAction(): Action
    {
        return Action::make('sendAction')
            ->label(trans('filament-blog::messages.comments.send'))
            ->visible(fn (): bool => FilamentBlog::account() !== null)
            ->action(function (): void {
                $account = FilamentBlog::account();

                if (! $account) {
                    return;
                }

                $data = $this->form->getState();

                Interactions::comment($account, $this->post, (string) $data['comment']);

                $this->form->fill(['comment' => '']);

                Notification::make()
                    ->title(trans('filament-blog::messages.comments.notifications.create.title'))
                    ->body(trans('filament-blog::messages.comments.notifications.create.body'))
                    ->success()
                    ->send();
            });
    }

    /**
     * A comment on this post written by the signed in account.
     *
     * @param  array<string, mixed>  $arguments
     */
    protected function findOwnComment(array $arguments): ?Comment
    {
        $account = FilamentBlog::account();

        if (! $account || ! isset($arguments['comment'])) {
            return null;
        }

        return Comment::query()
            ->whereKey($arguments['comment'])
            ->whereMorphedTo('content', $this->post)
            ->where('user_type', $account->getMorphClass())
            ->where('user_id', $account->getKey())
            ->first();
    }

    public function render(): View
    {
        return view('filament-blog::livewire.comment');
    }
}
