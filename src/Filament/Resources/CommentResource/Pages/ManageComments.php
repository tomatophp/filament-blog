<?php

namespace TomatoPHP\FilamentBlog\Filament\Resources\CommentResource\Pages;

use TomatoPHP\FilamentBlog\Filament\Resources\CommentResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageComments extends ManageRecords
{
    protected static string $resource = CommentResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
