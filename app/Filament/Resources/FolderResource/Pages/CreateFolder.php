<?php

namespace App\Filament\Resources\FolderResource\Pages;

use App\Filament\Resources\FolderResource;
use App\Models\Folder;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;

class CreateFolder extends CreateRecord
{
    protected static string $resource = FolderResource::class;


    protected static bool $canCreateAnother = false;

    public function getTitle(): string
    {
        if (empty(request()->p))
        return __('Create project'); // TODO: Change the autogenerated stub
        return __('Create Folder'); // TODO: Change the autogenerated stub
    }

    public function afterCreate(){

        if ($this->data['parent_folder_id']){

            $parent = Folder::find($this->data['parent_folder_id']);


            $this->record->bot_top_default_title = $parent->bot_top_default_title;
            $this->record->bot_placeholder_title = $parent->bot_placeholder_title;
            $this->record->bot_text_font_color = $parent->bot_text_font_color;

            $this->record->bot_text_font_size = $parent->bot_text_font_size;

            $this->record->bot_border_line_color = $parent->bot_border_line_color;

            $this->record->bot_background_color = $parent->bot_background_color;

            $this->record->page_color = $parent->page_color;

            $this->record->instruction_text = $parent->instruction_text;
            $this->record->show_source_in_response = $parent->show_source_in_response;
            $this->record->promote_template = $parent->promote_template;
            $this->record->temperature = $parent->temperature;

            $this->record->custom_button_is_enable = $parent->custom_button_is_enable;
            $this->record->custom_button_title = $parent->custom_button_title;
            $this->record->custom_button_link = $parent->custom_button_link;
            $this->record->custom_button_color = $parent->custom_button_color;

        }else{

            $this->record->bot_top_default_title = "Hola soy tu asistente virtual… puedo ayudarte respondiendo tus preguntas?";
            $this->record->bot_placeholder_title = "Escribe aquí tu pregunta…";
            $this->record->bot_text_font_color = "#ffffff";

            $this->record->bot_text_font_size = "16";

            $this->record->bot_border_line_color = "#5a45e0";

            $this->record->bot_background_color = "#1f2937";

            $this->record->page_color = "#444654";
            $this->record->show_source_in_response = 0;
            $this->record->temperature = 0;
            $this->record->custom_button_is_enable = 0;

            $this->record->promote_template = "You are docs2AI, a factual research assistant that provides accurate answers and is reluctant of making any claims unless they are stated on the knowledge base. When responding do not mention the words unstructured knowledge base. As docs2AI, your goal is to assist me in a conversation by providing accurate and reliable responses to my questions. You should use the information from the knowledge base as your only source of information when responding. If you cannot confirm an answer accurately with the provided information, then first state that you cannot provide a reliable response, and then provide me with your best guess.  Your response must be formatted using HTML for easier readability, including paragraph tags, line breaks, headings and bold titles where applicable..

Question: {question}
=========
{context}
=========
Answer in spanish or english:";

            $this->record->instruction_text = "**How to use?**

Simply type in your question or topic, and our artificial intelligence (AI) chatbot will try to generate an appropriate response using its trained knowledge and language abilities.

If you need any additional help, you can contact us at [Docs2ai.com](https://www.docs2ai.com/)
_____
_**Disclaimer:**  This chatbot, built on top of the latest AI models, was developed to provide helpful and timely information, but its responses may be limited by its programming and data. Users should evaluate the information provided and use it at their own risk._
";

        }




        if (isset($this->data['parent_folder_id'])){
            $this->record->parent_folder_id = $this->data['parent_folder_id'];
        }


        $this->record->save();

    }

    protected function getRedirectUrl(): string
    {
        if (!empty($this->record->parent_folder_id)){
            return route('filament.resources.bot.view',$this->record->id);
        }
        return route('filament.resources.bot.viewProject',$this->record->id);

    }




}
