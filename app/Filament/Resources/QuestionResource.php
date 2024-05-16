<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Question;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\QuestionResource\Pages;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuestionResource\RelationManagers;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-m-chat-bubble-bottom-center-text';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = "Questions & Ideas";

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
                TextColumn::make('meeting.title')->words(5)->label('Meeting')->searchable()->sortable(),
                TextColumn::make('youth.loginInfo.name')->label('Attendee')->searchable()->sortable(),
                TextColumn::make('question')->searchable()->words(3),
                TextColumn::make('reply')->html()->label('Provided Reply')->visible(function($record){
                    return Auth::user()->role == 'Youth' ? true : false;
                })->searchable()->words(3),
                TextColumn::make('comments_count')->label('Comments')->counts('comments'),
                TextColumn::make('created_at')->label('Date')->datetime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()->iconButton(),
                Action::make('reply')->label('Provide A Reply')
                ->form([
                    RichEditor::make('reply_given')->label('Reply')->required(),
                ])
                ->icon('heroicon-o-arrow-uturn-right')
                ->iconButton()
                ->action(function($record, array $data){
                    $record->update(['reply' => $data['reply_given']]);
                })
                ->color('success')
                ->visible(function($record){
                    return empty($record->reply);
                })
                ,
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
                TextEntry::make('meeting.title')->label('Meeting Title'),
                TextEntry::make('meeting.meeting_date')->label('Meeting Date'),
                TextEntry::make('youth.loginInfo.name')->label('Youth Name'),
                TextEntry::make('question')->label('Asked Question'),
                TextEntry::make('reply')->html()->label('Reply Provided'),
                RepeatableEntry::make('comments')
                    ->schema([
                        TextEntry::make('youth.loginInfo.name')->label('Commentor'),
                        TextEntry::make('comment')->label('Comment')->columnSpanFull(),
                    ])
                    ->grid(2)
            ])
            ->columns(1)
            ->inlineLabel();
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageQuestions::route('/'),
        ];
    }   
    
    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->role=='Youth'){
            return parent::getEloquentQuery()->where('youth_id',auth()->user()->youthDetails->id)->latest();
        } 
        else if(auth()->user()->role == 'Coordinator'){
            return parent::getEloquentQuery()->whereRelation('meeting','coordinator_id',auth()->user()->coordinatorDetails->id)->latest();
        }
        else{
            return parent::getEloquentQuery()->latest();
        }
    }
}
