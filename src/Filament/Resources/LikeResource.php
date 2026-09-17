<?php

namespace TomatoPHP\FilamentBlog\Filament\Resources;

use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use TomatoPHP\FilamentBlog\Filament\Resources\LikeResource\Pages\ManageLikes;
use TomatoPHP\FilamentBlog\FilamentBlog;
use TomatoPHP\FilamentBlog\Models\Like;

class LikeResource extends Resource
{
    protected static ?string $model = Like::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-heart';

    public static function getNavigationLabel(): string
    {
        return trans('filament-blog::messages.likes.title');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-blog::messages.likes.title');
    }

    public static function getLabel(): ?string
    {
        return trans('filament-blog::messages.likes.single');
    }

    /**
     * Accounts only see their own likes.
     */
    public static function getEloquentQuery(): Builder
    {
        $account = FilamentBlog::account();

        return parent::getEloquentQuery()
            ->when(
                $account,
                fn (Builder $query) => $query->where('account_id', $account->getKey()),
                fn (Builder $query) => $query->whereRaw('1 = 0'),
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('post.title')
                    ->label(trans('filament-blog::messages.likes.post')),
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
                ViewAction::make()
                    ->url(fn (Like $record): ?string => $record->post ? FilamentBlog::postUrl($record->post) : null)
                    ->openUrlInNewTab(),
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
            'index' => ManageLikes::route('/'),
        ];
    }
}
