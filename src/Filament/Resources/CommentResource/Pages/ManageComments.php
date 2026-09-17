<?php

namespace TomatoPHP\FilamentBlog\Filament\Resources\CommentResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentBlog\Filament\Resources\CommentResource;

class ManageComments extends ManageRecords
{
    protected static string $resource = CommentResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
