<?php

namespace App\Filament\Resources\YouthResource\Pages;

use App\Filament\Resources\YouthResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYouths extends ListRecords
{
    protected static string $resource = YouthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
