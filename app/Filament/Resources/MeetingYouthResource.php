<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Meeting;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MeetingYouth;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MeetingYouthResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\MeetingYouthResource\RelationManagers;

class MeetingYouthResource extends Resource
{
    protected static ?string $model = MeetingYouth::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationLabel = "Attendance";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('youth.loginInfo.name')->label('Attendant Names'),
                TextColumn::make('youth.phone')->label('Phone'),
                TextColumn::make('youth.loginInfo.email')->label('Email Address'),
                TextColumn::make('meeting.title')->label('Meeting'),
                TextColumn::make('meeting.meeting_date')->label('Meeting date')->date(),
                TextColumn::make('created_at')->label('Registration date')->datetime(),
                SelectColumn::make('status')->options([
                    'Pending'=>'Pending',
                    'Approved'=>'Approved'
                ]),
            ])
            ->filters([
                SelectFilter::make('meeting_id')->label('Meeting')->options(function () {
                        return Meeting::pluck('title', 'id');
                    })
                    ->searchable(),
                SelectFilter::make('status')->label('Request Status')->options([
                    "Pending" => 'Pending',
                    "Approved" => 'Approved',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMeetingYouths::route('/'),
        ];
    }    
}
