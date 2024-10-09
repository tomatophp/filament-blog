<?php

namespace TomatoPHP\FilamentBlog\Filament\Resources;

use TomatoPHP\FilamentBlog\Filament\Resources\LikeResource\Pages;
use TomatoPHP\FilamentBlog\Filament\Resources\LikeResource\RelationManagers;
use App\Models\Account;
use TomatoPHP\FilamentBlog\Models\Like;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentTypes\Components\TypeColumn;

class LikeResource extends Resource
{
    protected static ?string $model = Like::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';


    public static function getNavigationLabel(): string
    {
        return trans('filament-blog::messages.likes.title');
    }

    public static function getPluralLabel(): ?string
    {
        return  trans('filament-blog::messages.likes.title');
    }

    public static function getLabel(): ?string
    {
        return  trans('filament-blog::messages.likes.single');
    }


    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('account_id', auth('accounts')->user()->id);
            })
            ->columns([
                Tables\Columns\TextColumn::make('post.title')
                    ->label(trans('filament-blog::messages.likes.post'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn($record) => $record->post->type === 'open-source' ? url(app()->getLocale() . '/open-source/' . $record->post->slug) : url(app()->getLocale() . '/blog/' . $record->post->slug))
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLikes::route('/'),
        ];
    }
}
