<?php

namespace App\Filament\Resources\MeetingResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendees';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('national_id')
            ->columns([
                TextColumn::make('loginInfo.name')->label('Attendant Names'),
                TextColumn::make('phone'),
                TextColumn::make('loginInfo.email'),
                TextColumn::make('district'),
                TextColumn::make('sector'),
                TextColumn::make('cell'),
                TextColumn::make('national_id'),
                SelectColumn::make('status')->options([
                    'Pending'=>'Pending',
                    'Approved'=>'Approved'
                ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
            ])
            ->bulkActions([
            ])
            ->emptyStateActions([
            ]);
    }
}
