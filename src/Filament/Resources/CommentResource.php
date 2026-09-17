<?php

namespace TomatoPHP\FilamentBlog\Filament\Resources;

use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use TomatoPHP\FilamentBlog\Filament\Resources\CommentResource\Pages\ManageComments;
use TomatoPHP\FilamentBlog\FilamentBlog;
use TomatoPHP\FilamentBlog\Models\Comment;
use TomatoPHP\FilamentCms\Models\Post;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function getNavigationLabel(): string
    {
        return trans('filament-blog::messages.comments.title');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-blog::messages.comments.title');
    }

    public static function getLabel(): ?string
    {
        return trans('filament-blog::messages.comments.single');
    }

    /**
     * Accounts only see their own comments.
     */
    public static function getEloquentQuery(): Builder
    {
        $account = FilamentBlog::account();

        return parent::getEloquentQuery()
            ->when(
                $account,
                fn (Builder $query) => $query
                    ->where('user_id', $account->getKey())
                    ->where('user_type', $account->getMorphClass()),
                fn (Builder $query) => $query->whereRaw('1 = 0'),
            );
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            MarkdownEditor::make('comment')
                ->label(trans('filament-blog::messages.comments.comment'))
                ->columnSpanFull()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('content.title')
                    ->label(trans('filament-blog::messages.comments.post'))
                    ->url(fn (Comment $record): ?string => $record->content instanceof Post ? FilamentBlog::postUrl($record->content) : null)
                    ->openUrlInNewTab(),
                TextColumn::make('comment')
                    ->label(trans('filament-blog::messages.comments.comment'))
                    ->limit(50)
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label(trans('filament-blog::messages.comments.comment'))
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageComments::route('/'),
        ];
    }
}
