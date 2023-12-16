<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Enums\NamePrefix;
use Filament\Tables\Table;
use App\Models\Coordinator;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CoordinatorResource\Pages;
use App\Filament\Resources\CoordinatorResource\RelationManagers;
use App\Filament\Resources\CoordinatorResource\Pages\ManageCoordinators;

class CoordinatorResource extends Resource
{
    protected static ?string $model = Coordinator::class;

    protected static ?string $navigationIcon = 'heroicon-m-user-group';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = "Meeting Coordinators";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)->hiddenOn('edit')->schema([
                    Select::make('prefix')
                        ->required()
                        ->options(NamePrefix::class)
                        ->columnSpan(1)
                        ->label(__('Prefix')),
                    TextInput::make('name')
                        ->required()
                        ->columnSpan(3)
                        ->label(__('Name')),
                ]),
                Group::make()->hiddenOn('create')->relationship('loginInfo')->schema([
                    TextInput::make('name')
                        ->required()
                        ->columnSpan(3)
                        ->label(__('Name')),
                    TextInput::make('email')
                        ->required()
                        ->label(__('Email')),
                ]),
                TextInput::make('email')
                    ->required()
                    ->hiddenOn('edit')
                    ->label(__('Email')),
                TextInput::make('phone')
                    ->required()
                    ->label(__('Phone')),
                TextInput::make('password')
                    ->required()
                    ->hiddenOn('edit')
                    ->password()
                    ->confirmed()
                    ->label(__('Password')),
                TextInput::make('password_confirmation')
                    ->required()
                    ->password()
                    ->hiddenOn('edit')
                    ->label(__('Confirm Password')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('loginInfo.email')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => ManageCoordinators::route('/'),
        ];
    }    
}
