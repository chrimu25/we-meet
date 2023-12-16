<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Enquiry;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\EnquiryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EnquiryResource\RelationManagers;

class EnquiryResource extends Resource
{
    protected static ?string $model = Enquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 6;

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
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->searchable()
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('created_at')->form([
                    DatePicker::make('from')->label('Enquiry From')->closeOnDateSelection(),
                    DatePicker::make('until')->label('Until')->closeOnDateSelection(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when($data['from'],
                            fn (Builder $query, $date): Builder => $query->where('created_at', '>=', $date),
                        )
                        ->when($data['until'],
                            fn (Builder $query, $date): Builder => $query->where('created_at', '<=', $date),
                        );
                })->indicateUsing(function (array $data): array {
                    $indicators = [];
                    if ($data['from'] ?? null) {
                        $indicators['from'] = 'Enquiry from ' . Carbon::parse($data['from'])->toFormattedDateString();
                    }
                    if ($data['until'] ?? null) {
                        $indicators['until'] = 'Until ' . Carbon::parse($data['until'])->toFormattedDateString();
                    }

                    return $indicators;
                })
            ])
            ->actions([
                ViewAction::make()->iconButton()->slideOver(),
                DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('email'),
                TextEntry::make('subject'),
                TextEntry::make('created_at'),
                TextEntry::make('message')
                    ->label('Description'),
            ])
            ->columns(1)
            ->inlineLabel();
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEnquiries::route('/'),
        ];
    }    
}
