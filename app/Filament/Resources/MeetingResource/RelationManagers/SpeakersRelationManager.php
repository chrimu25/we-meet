<?php

namespace App\Filament\Resources\MeetingResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Speaker;
use Filament\Forms\Form;
use App\Enums\NamePrefix;
use Filament\Tables\Table;
use App\Enums\SpeakerCategory;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SpeakersRelationManager extends RelationManager
{
    protected static string $relationship = 'speakers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(6)->schema([
                    Select::make('title')
                        ->required()
                        ->columnSpan(1)
                        ->options(NamePrefix::class),
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(3),
                    Select::make('type')
                        ->required()
                        ->columnSpan(2)
                        ->options(SpeakerCategory::class),
                ]),
                FileUpload::make('image')
                    ->image()
                    ->directory('speakers')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->recordTitle(fn (Speaker $record): string => "{$record->title} {$record->name}")
            ->columns([
                ImageColumn::make('image')
                    ->circular()
                    ->label(__('Image')),
                TextColumn::make('full_name'),
                TextColumn::make('type'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
