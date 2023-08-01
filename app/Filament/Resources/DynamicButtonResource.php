<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DynamicButtonResource\Pages;
use App\Filament\Resources\DynamicButtonResource\RelationManagers;
use App\Models\DynamicButton;
use App\Models\Folder;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DynamicButtonResource extends Resource
{
    protected static ?string $model = DynamicButton::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('folder_id')->default(Cache::get('folder_id')),
                Forms\Components\Toggle::make('status')->default(1)->columnSpan(2),
                Forms\Components\TextInput::make('button_title')->hiddenOn('create'),
                Forms\Components\SpatieTagsInput::make('tags')
                    ->label('Translated tags')
                    ->visible(fn($record) => Folder::find($record->folder_id)->is_multi_lang == 1)
                    ->hiddenOn('create'),
                Forms\Components\TagsInput::make('master_tags')->hiddenOn('create'),
                Forms\Components\TextInput::make('button_url')->label('Custom button link')->required()->type('url'),
                Forms\Components\ColorPicker::make('button_color')->label('Custom button color (optional)')->nullable(),
                FileUpload::make('button_icon')->hiddenOn("create")->preserveFilenames()->acceptedFileTypes(['image/*'])->enableOpen()->enableDownload(),
                Forms\Components\Textarea::make('button_description')->rows(10)->columnSpanFull()->hiddenOn("create")

            ])
            ;
    }


   public static function getEloquentQuery(): Builder
   {
       return DynamicButton::where('folder_id',Cache::get('folder_id')); // TODO: Change the autogenerated stub
   }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('button_title')->searchable()->label('Title'),
                Tables\Columns\TextColumn::make('Link')
                    ->formatStateUsing(fn()=>"GO")
                    ->url(fn ($record) => $record->button_url, true),
               Tables\Columns\TagsColumn::make('master_tags')->searchable()->limit(5),
                Tables\Columns\ToggleColumn::make('status')->searchable(),
                Tables\Columns\ColorColumn::make('button_color'),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->action(function (Collection $records){
                    foreach ($records as $record){
                        $record->tags()->delete();
                    }
                    $records->each->delete();
                })
            ]);
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
            'index' => Pages\ListDynamicButtons::route('/'),
            'create' => Pages\CreateDynamicButton::route('/create'),
            'edit' => Pages\EditDynamicButton::route('/{record}/edit'),
        ];
    }
}