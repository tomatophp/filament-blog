<?php

namespace TomatoPHP\FilamentBlog\Filament\Resources\LikeResource\Pages;

use TomatoPHP\FilamentBlog\Filament\Resources\LikeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLikes extends ManageRecords
{
    protected static string $resource = LikeResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
