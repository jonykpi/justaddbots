<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FolderResource\Pages;
use App\Filament\Resources\FolderResource\RelationManagers;
use App\Models\Folder;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FolderResource extends Resource
{
    protected static ?string $model = Folder::class;
    protected static ?string $slug = 'bot';



    protected static ?string $navigationIcon = 'heroicon-o-collection';


//    public $embedded_id = Str::random(40);


    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Forms\Components\Hidden::make('embedded_id')->default(Str::random(40))
                    ->required(),
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Select::make('parent_folder_id')->hidden(empty(request()->p))->default(!empty(request()->p) ? (int) request()->p : null)->options(Folder::where('parent_folder_id',null)->get()->pluck('name','id')->toArray()),
                       Forms\Components\Section::make('Bot Settings')->hiddenOn('create')
                    ->columns(4)
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                         Forms\Components\Toggle::make('show_source_in_response')->default(0)->hiddenOn('create'),
                        Forms\Components\TextInput::make('bot_top_default_title')->hiddenOn('create'),
                        Forms\Components\TextInput::make('bot_placeholder_title')->hiddenOn('create'),
                        Forms\Components\TextInput::make('bot_text_font_size')->numeric()->suffix('px')->hiddenOn('create'),
                         Forms\Components\ColorPicker::make('bot_border_line_color')->hiddenOn('create'),
                        Forms\Components\ColorPicker::make('bot_text_font_color')->hiddenOn('create'),
                        Forms\Components\ColorPicker::make('page_color')->hiddenOn('create'),
                        Forms\Components\ColorPicker::make('bot_background_color')->hiddenOn('create'),
                               ]),
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\FileUpload::make('bot_icon')->label('Bot icon (96x96) | Less then 100Kb')->enableDownload()->acceptedFileTypes(['image/*'])->hiddenOn('create'),
                                Forms\Components\FileUpload::make('user_icon')->label('User icon (96x96) | Less then 100Kb')->enableDownload()->acceptedFileTypes(['image/*'])->hiddenOn('create'),
                                Forms\Components\FileUpload::make('send_button_icon')->label('Send button icon (96x96) | Less then 100Kb')->enableDownload()->acceptedFileTypes(['image/*'])->hiddenOn('create'),

                                ])

                    ]),
                Forms\Components\Section::make('Whatsapp')->hiddenOn('create')->hidden(fn($record) => empty($record->parent_folder_id))
                    ->columns(2)
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('whatsapp_number')->unique(ignoreRecord: true)->hiddenOn('create'),
                                Forms\Components\TextInput::make('whatsapp_id')->unique(ignoreRecord: true)->hiddenOn('create'),
                                Forms\Components\Textarea::make('whatsapp_access_token')->unique(ignoreRecord: true)->hiddenOn('create')
                            ]),

                    ]),
                Forms\Components\Section::make('Custom button')->hiddenOn('create')
                    ->columns(4)
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Toggle::make('custom_button_is_enable')->label('Show custom button')->hiddenOn('create'),
                                Forms\Components\TextInput::make('custom_button_title')->hiddenOn('create'),
                                Forms\Components\TextInput::make('custom_button_link')->type('url')->hiddenOn('create'),
                                Forms\Components\ColorPicker::make('custom_button_color')->hiddenOn('create'),
                            ]),

                    ])->columns(1),

                Forms\Components\Section::make('Ai Settings')->hiddenOn('create')
                    ->columns(4)
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Select::make('temperature')->options([
                                    '0'=>'0',
                                    '0.1'=>'0.1',
                                    '0.2'=>'0.2',
                                    '0.3'=>'0.3',
                                    '0.4'=>'0.4',
                                    '0.5'=>'0.5',
                                    '0.6'=>'0.6',
                                    '0.7'=>'0.7',
                                    '0.8'=>'0.8',
                                    '0.9'=>'0.9',
                                    '1'=>'1',
                                ])
                                    ->default(0)->hiddenOn('create'),
                            ]),
                         Forms\Components\Textarea::make('promote_template')->cols(10)->rows(14)->hiddenOn('create')

                    ])->columns(1),

                Forms\Components\Section::make('Instructions')->hiddenOn('create')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\FileUpload::make('instruction_logo')->label('Instruction logo (250x250) | Less then 1mb')->enableDownload()->acceptedFileTypes(['image/*'])->columns(3),

                            ])
                            ->columns(3),
                         Forms\Components\MarkdownEditor::make('instruction_text')->label('')

                    ])
                    ->columns(1),



            ]);
    }


    public static function table(Table $table): Table
    {


        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public function table2(Table $table): Table
    {


        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListFolders::route('/'),
            'view' => Pages\CustomListFolders::route('/view/{record}'),
            'viewProject' => Pages\ProjectView::route('/setting/{record}'),
            'create' => Pages\CreateFolder::route('/create'),
            'edit' => Pages\EditFolder::route('/{record}/edit'),
            'thumbLogs' => Pages\ThumbLogs::route('/{record}/thumb/logs'),
        ];
    }
}
