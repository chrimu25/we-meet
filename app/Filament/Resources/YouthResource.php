<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Youth;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\YouthResource\Pages;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\YouthResource\RelationManagers;

class YouthResource extends Resource
{
    protected static ?string $model = Youth::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 4;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('loginInfo.name')->label('Name')->searchable()->sortable(),
                TextColumn::make('loginInfo.email')->label('Email Address')->searchable()->sortable(),
                TextColumn::make('phone')->label('Phone Number')->searchable()->sortable(),
                TextColumn::make('national_id')->label('Nation ID')->searchable()->sortable(),
                TextColumn::make('date_of_birth')->label('Date Of Birth')->searchable()->sortable()->date('Y-m-d'),
                TextColumn::make('loginInfo.name')->label('Name')->searchable()->sortable(),
                TextColumn::make('loginInfo.name')->label('Name')->searchable()->sortable(),
                TextColumn::make('loginInfo.name')->label('Name')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                // 
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('loginInfo.name')
                    ->label('Name:'),
                TextEntry::make('loginInfo.email')
                    ->label('Email Address:'),
                TextEntry::make('phone')
                    ->label('Phone Number:'),
                TextEntry::make('national_id')
                    ->label('National ID Number:'),
                TextEntry::make('date_of_birth')
                    ->label('Date of Birth:'),
                TextEntry::make('province')
                    ->label('Province:'),
                TextEntry::make('district')
                    ->label('District:'),
                TextEntry::make('sector')
                    ->label('Sector:'),
                TextEntry::make('cell')
                    ->label('Cell:'),
                RepeatableEntry::make('attendedMeetings')
                    ->label('Attended Meetings')
                    ->schema([
                        TextEntry::make('title'),
                        TextEntry::make('venue'),
                        TextEntry::make('meeting_date')
                            ->columnSpan(2),
                    ])
                    ->columns(1)
            ])
            ->columns(1)
            ->inlineLabel();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListYouths::route('/'),
            'create' => Pages\CreateYouth::route('/create'),
            'edit' => Pages\EditYouth::route('/{record}/edit'),
        ];
    } 
}
