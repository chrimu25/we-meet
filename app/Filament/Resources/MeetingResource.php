<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Meeting;
use Filament\Forms\Form;
use App\Enums\NamePrefix;
use Filament\Tables\Table;
use App\Models\Coordinator;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Infolists\Components\ImageEntry;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\MeetingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MeetingResource\RelationManagers;
use App\Filament\Resources\MeetingResource\RelationManagers\SpeakersRelationManager;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;

    protected static ?string $navigationIcon = 'heroicon-s-video-camera';
    protected static ?int $navigationSort = 2;

    protected static array $prefixes = [
        'Mr.' => 'Mr.',
        'Mrs.' => 'Mrs.',
        'Ms.' => 'Ms.',
        'Dr.' => 'Dr.'
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->autofocus()
                    ->required()
                    ->columnSpanFull()
                    ->label(__('Title')),
                Grid::make(3)->schema([
                    TextInput::make('location')
                            ->autofocus()
                            ->required()
                            ->label(__('Location')),
                    TextInput::make('venue')
                        ->autofocus()
                        ->required()
                        ->label(__('Venue')),
                    Select::make('coordinator_id')
                        ->options(function(){
                            return Coordinator::all()->mapWithKeys(function($coordinator){
                                return [$coordinator->id => $coordinator->loginInfo->name??''];
                            });
                        })
                        ->searchable()
                        ->required()
                        ->preload()
                        ->label(__('Coordinator')),
                ]),
                Grid::make(3)
                    ->schema([
                        DatePicker::make('meeting_date')
                            ->autofocus()
                            ->required()
                            ->label(__('Meeting Date')),
                        TimePicker::make('start_time')
                            ->autofocus()
                            ->required()
                            ->label(__('Start Time')),
                        TimePicker::make('end_time')
                            ->autofocus()
                            ->required()
                            ->label(__('End Time')),
                    ]),
                MarkdownEditor::make('moto')
                    ->required()
                    ->columnSpanFull()
                    ->label(__('Moto')),
                RichEditor::make('description')
                    ->columnSpanFull()
                    ->label(__('Description')),
                FileUpload::make('cover_image')
                    ->image()
                    ->maxSize(1024)
                    ->columnSpanFull()
                    ->required()
                    ->label(__('Cover Image')),
                TextInput::make('meeting_link')
                    ->columnSpanFull()
                    ->helperText('Ex: on Youtube, right click on the video and select "Copy embed code" and then paste it here.')
                    ->hint('Embed code from Host platform like Youtube, Facebook, Vimeo etc')
                    ->label(__('Meeting Link')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->circular()
                    ->disk('public')
                    ->label(__('Image')),
                TextColumn::make('title')
                    ->description(fn (Meeting $record): string => str()->limit($record->moto,50))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('location')
                    ->description(fn (Meeting $record): string => $record->venue)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('meeting_date')->date()
                    ->description(fn (Meeting $record): string => $record->time)
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([
                Filter::make('meeting_date')->form([
                    DatePicker::make('from')->label('Meeting From')->closeOnDateSelection(),
                    DatePicker::make('until')->label('Until')->closeOnDateSelection(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when($data['from'],
                            fn (Builder $query, $date): Builder => $query->where('meeting_date', '>=', $date),
                        )
                        ->when($data['until'],
                            fn (Builder $query, $date): Builder => $query->where('meeting_date', '<=', $date),
                        );
                })->indicateUsing(function (array $data): array {
                    $indicators = [];
                    if ($data['from'] ?? null) {
                        $indicators['from'] = 'Meeting from ' . Carbon::parse($data['from'])->toFormattedDateString();
                    }
                    if ($data['until'] ?? null) {
                        $indicators['until'] = 'Until ' . Carbon::parse($data['until'])->toFormattedDateString();
                    }

                    return $indicators;
                })
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()->label('Edit Meeting')->slideOver(),
                    DeleteAction::make()->label('Delete Meeting')->requiresConfirmation(),
                    ViewAction::make()->label('View Details')->slideOver(),
                    // ViewAction::make('view')->label('Watch Meeting')->icon('heroicon-o-eye')
                    //     ->url(fn (Meeting $record): string => route('dashboard'))
                    //     ->openUrlInNewTab(),
                ])->button()->color('primary')->label('Actions'),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('title'),
                TextEntry::make('location'),
                TextEntry::make('venue'),
                TextEntry::make('moto'),
                TextEntry::make('coordinator.name')
                    ->label('Coordinator'),
                TextEntry::make('meeting_date'),
                TextEntry::make('time'),
                TextEntry::make('meeting_link')
                    ->label('Meeting Link'),
                TextEntry::make('description')->markdown(),
            ])
            ->columns(1)
            ->inlineLabel();
    }
    
    public static function getRelations(): array
    {
        return [
            SpeakersRelationManager::class
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeetings::route('/'),
            'create' => Pages\CreateMeeting::route('/create'),
            'edit' => Pages\EditMeeting::route('/{record}/edit'),
        ];
    }  
    
    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->role == 'Coordinator'){
            return parent::getEloquentQuery()->whereRelation('coordinator','id',auth()->user()->coordinatorDetails->id);
        }
        else{
            return parent::getEloquentQuery();
        }
    }
}
