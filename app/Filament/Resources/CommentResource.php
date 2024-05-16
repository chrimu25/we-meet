<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Enums\Status;
use App\Models\Comment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\CommentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CommentResource\RelationManagers;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel ='Meeting Comments';
    protected static ?int $navigationSort = 5;

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
                TextColumn::make('question.meeting.title')->words(5)->label('Meeting')->searchable()->sortable(),
                TextColumn::make('youth.loginInfo.name')->label('Attendee')->searchable()->sortable(),
                TextColumn::make('comment')->searchable()->words(3),
                TextColumn::make('created_at')->label('Date')->date('d-m-Y H:i'),
                SelectColumn::make('status')->options([
                    'Pending'=>'Pending',
                    'Approved'=>'Approved',
                    'Rejected'=>'Rejected'
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()->iconButton(),
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
                TextEntry::make('question.meeting.title')->label('Meeting Title'),
                TextEntry::make('question.meeting.meeting_date')->label('Meeting Date'),
                TextEntry::make('question.question')->label('Asked Question'),
                TextEntry::make('created_at')->label('Comment Date'),
                TextEntry::make('youth.loginInfo.name')->label('Youth Name'),
                TextEntry::make('comment')->label('Comment'),
            ])
            ->columns(1)
            ->inlineLabel();
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageComments::route('/'),
        ];
    }  
    
    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->role=='Youth'){
            return parent::getEloquentQuery()->where('youth_id',auth()->user()->youthDetails->id)->latest();
        } 
        else if(auth()->user()->role == 'Coordinator'){
            return parent::getEloquentQuery()->whereRelation('question.meeting','coordinator_id',auth()->user()->coordinatorDetails->id)->latest();
        }
        else{
            return parent::getEloquentQuery()->latest();
        }
    }
}
