<?php

namespace TomatoPHP\FilamentBlog\Livewire;

use App\Models\Account;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use TomatoPHP\FilamentCms\Filament\Resources\PostResource;
use TomatoPHP\FilamentCms\Models\Comment;
use TomatoPHP\FilamentCms\Models\Post;

class CommentPost extends Component implements HasActions, HasForms
{
    use InteractsWithForms;
    use InteractsWithActions;

    public array $data = [];
    public ?Post $post = null;

    public function mount(Post $post){
        $this->post = $post;
        $this->form->fill([
            'comment' => ''
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            MarkdownEditor::make('comment')
                ->label(trans('filament-blog::messages.comments.comment'))
                ->required()
        ])->statePath('data');
    }

    public function editAction(): Action
    {
        return Action::make('editAction')
            ->iconButton()
            ->tooltip(trans('filament-blog::messages.comments.edit'))
            ->label(trans('filament-blog::messages.comments.edit'))
            ->color('warning')
            ->icon('heroicon-o-pencil')
            ->fillForm(fn(array $arguments)=> $arguments['comment'])
            ->form([
                MarkdownEditor::make('comment')
                    ->label(trans('filament-blog::messages.comments.comment'))
                    ->required()
            ])
            ->action(function(array $arguments, array $data){
                $comment = Comment::query()
                    ->where('id', $arguments['comment']['id'])
                    ->where('user_type', Account::class)
                    ->where('user_id', auth('accounts')->user()->id)
                    ->first();

                $comment->update([
                    'comment' => $data['comment']
                ]);

                Notification::make()
                    ->title(trans('filament-blog::messages.comments.notifications.edit.title'))
                    ->body(trans('filament-blog::messages.comments.notifications.edit.body'))
                    ->success()
                    ->send();
            });
    }

    public function deleteAction()
    {
        return Action::make('deleteAction')
            ->requiresConfirmation()
            ->iconButton()
            ->tooltip(trans('filament-blog::messages.comments.delete'))
            ->label(trans('filament-blog::messages.comments.delete'))
            ->color('danger')
            ->icon('heroicon-o-trash')
            ->action(function(array $arguments){
                $comment = Comment::query()
                    ->where('id', $arguments['comment']['id'])
                    ->where('user_type', Account::class)
                    ->where('user_id', auth('accounts')->user()->id)
                    ->first();

                $comment->delete();

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
            ->action(function(){
               $this->form->validate();

               $data = $this->form->getState();

                $this->post->comments()->create([
                     'comment' => $data['comment'],
                     'user_id' => auth('accounts')->id(),
                     'user_type' => Account::class,
                    'is_active' => 1
                ]);

                auth('accounts')->user()->log($this->post, 'comment', $data['comment']);

                $this->form->fill([
                    'comment' => ''
                ]);

                if($this->post->author){
                    Notification::make()
                        ->title("New Comment")
                        ->body(auth('accounts')->user()->name . " add a new comment has been added to your post")
                        ->actions([
                            \Filament\Notifications\Actions\Action::make('viewComment')
                                ->label('View Comment')
                                ->url(url('/admin/posts/' . $this->post->id . '/show'))
                        ])
                        ->success()
                        ->sendToDatabase($this->post->author);
                }

                Notification::make()
                    ->title(trans('filament-blog::messages.comments.notifications.create.title'))
                    ->body(trans('filament-blog::messages.comments.notifications.create.body'))
                    ->success()
                    ->send();

                return redirect()->back();
            });
    }

    public function render()
    {
        return view('filament-blog::livewire.comment');
    }
}
