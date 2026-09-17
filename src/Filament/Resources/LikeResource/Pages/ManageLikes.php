<?php

namespace TomatoPHP\FilamentBlog\Filament\Resources\LikeResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentBlog\Filament\Resources\LikeResource;

class ManageLikes extends ManageRecords
{
    protected static string $resource = LikeResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
