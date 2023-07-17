<?php

namespace App\Filament\Pages;

use App\Models\Folder;
use Filament\Forms;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class ManageDefaultProject extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = \App\Models\DefaultProjectSetting::class;

    public $data;

    public function save(): void
    {
        $this->callHook('beforeValidate');

        $data = $this->form->getState();

        $this->callHook('afterValidate');

        $data = $this->mutateFormDataBeforeSave($data);

        $this->callHook('beforeSave');

        $settings = app(static::getSettings());
        $settings = $settings->firstOrNew();

        $settings->fill($data);
        $settings->save();

        $this->callHook('afterSave');

        $this->getSavedNotification()?->send();

        if ($redirectUrl = $this->getRedirectUrl()) {
            $this->redirect($redirectUrl);
        }
    }


    public static function getSettings(): string
    {

       // return \App\Models\DefaultProjectSetting::firstOrNew(['id'=>1]);

        return parent::getSettings(); // TODO: Change the autogenerated stub
    }



    protected function fillForm(): void
    {
        $this->callHook('beforeFill');

        $settings = app(static::getSettings());
        $settings = $settings->firstOrNew();

        $data = $this->mutateFormDataBeforeFill($settings->toArray());

        $this->form->fill($data);

        $this->callHook('afterFill');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    protected function getTitle(): string
    {

        return "Default settings"; // TODO: Change the autogenerated stub
    }

    /**
     * @return string|null
     */

    protected function getFormSchema(): array
    {
        return [
//            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\Section::make('Bot Settings')
                ->columns(4)
                ->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Toggle::make('show_source_in_response')->default(0),
                            Forms\Components\TextInput::make('bot_top_default_title'),
                            Forms\Components\TextInput::make('bot_placeholder_title'),
                            Forms\Components\TextInput::make('bot_text_font_size')->numeric()->suffix('px'),
                            Forms\Components\ColorPicker::make('bot_border_line_color'),
                            Forms\Components\ColorPicker::make('bot_text_font_color'),
                            Forms\Components\ColorPicker::make('page_color'),
                            Forms\Components\ColorPicker::make('bot_background_color'),
                        ]),
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\FileUpload::make('bot_icon')->label('Bot icon (96x96) | Less then 100Kb')->enableDownload()->acceptedFileTypes(['image/*']),
                            Forms\Components\FileUpload::make('user_icon')->label('User icon (96x96) | Less then 100Kb')->enableDownload()->acceptedFileTypes(['image/*']),
                            Forms\Components\FileUpload::make('send_button_icon')->label('Send button icon (96x96) | Less then 100Kb')->enableDownload()->acceptedFileTypes(['image/*']),

                        ])

                ]),

            Forms\Components\Section::make('3rd Party script settings')
                ->columns(2)
                ->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\FileUpload::make('script_expand_icon')->label('Script collapsable icon'),
                            Forms\Components\FileUpload::make('script_collapsable_icon')->label('Script expand icon'),
                            Forms\Components\ColorPicker::make('script_collapsable_background_color'),
                        ]),

                ]),


            Forms\Components\Section::make('Custom button')
                ->columns(4)
                ->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Toggle::make('custom_button_is_enable')->label('Show custom button'),
                            Forms\Components\TextInput::make('custom_button_title'),
                            Forms\Components\TextInput::make('custom_button_link')->type('url'),
                            Forms\Components\ColorPicker::make('custom_button_color')->label('Custom button color (optional)'),
                        ]),

                ])->columns(1),

            Forms\Components\Section::make('Ai Settings')
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
                                ->default(0),
                            Forms\Components\Select::make('prompt_lang')->label('Prompt default language')->options(languages())
                                ->default("English"),
                            Forms\Components\TextInput::make('number_of_source')
                                ->default("1"),
                            Forms\Components\Select::make('language_model')->options(languageModels())
                                ,
                        ]),
                    Forms\Components\Textarea::make('promote_template')->cols(10)->rows(14)

                ])->columns(1),

            Forms\Components\Section::make('Instructions')
                ->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\FileUpload::make('instruction_logo')->label('Instruction logo (250x250) | Less then 1mb')->enableDownload()->acceptedFileTypes(['image/*'])->columns(3),

                        ])
                        ->columns(3),
                    Forms\Components\MarkdownEditor::make('instruction_text')->label('')

                ])
                ->columns(1),



        ];
    }
}
