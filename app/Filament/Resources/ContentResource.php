<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContentResource\Pages;
use App\Filament\Resources\ContentResource\RelationManagers;
use App\Models\Content;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\Action;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ContentResource extends Resource
{
    protected static ?string $model = Content::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';



    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                TextInput::make('file_title')->visible(Cache::get('type') == "txt")
                    ->columnSpan(2)
                    ->default(Cache::get('type') == "file" ? 'default' : request()->q)->label('Title'),
                TextInput::make('url')->visible(Cache::get('type') == "url")
                    ->columnSpan(2)
                    ->url()
                    ->required()
                    ->default(Cache::get('type') == "url" ? '' : request()->q)->label('Crawl url'),
                Hidden::make('folder_id')
                    ->default(Cache::get('folder_id')),
                Hidden::make('text_data')
                    ->default('dsd'),
                Hidden::make('type')
                    ->default(Cache::get('type')),
                Hidden::make('file_id')
                    ->default(Str::random(10)),
                Forms\Components\SpatieMediaLibraryFileUpload::make('file_path')->disabled(Cache::get('type') == "txt")->visible(Cache::get('type') == "file")->collection('images')->required()->preserveFilenames()->acceptedFileTypes(['application/pdf'])->enableOpen()->enableDownload(),
                TinyEditor::make('row_text')->columnSpan(2)->showMenuBar(false)->minHeight(400)->simple()->disabled(Cache::get('type') == "file")->visible(Cache::get('type') == "txt"),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->before(function (Content $content){

                }),
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
            'index' => Pages\ListContents::route('/'),
            'create' => Pages\CreateContent::route('/create'),
            'view' => Pages\ViewContent::route('/{record}'),
            'edit' => Pages\EditContent::route('/{record}/edit'),
        ];
    }
}
