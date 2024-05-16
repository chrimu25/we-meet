<?php

namespace App\Filament\Resources\MeetingYouthResource\Pages;

use App\Filament\Resources\MeetingYouthResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMeetingYouths extends ManageRecords
{
    protected static string $resource = MeetingYouthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
