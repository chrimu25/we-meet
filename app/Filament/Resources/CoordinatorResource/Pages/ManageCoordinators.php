<?php

namespace App\Filament\Resources\CoordinatorResource\Pages;

use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\CoordinatorResource;

class ManageCoordinators extends ManageRecords
{
    protected static string $resource = CoordinatorResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->mutateFormDataUsing(function (array $data): array{
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'role' => 'Coordinator',
                    'password' =>$data['password'],
                ]);
                $data['user_id'] = $user->id;
                return $data;
            })
        ];
    }
}
