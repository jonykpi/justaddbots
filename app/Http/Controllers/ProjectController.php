<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\DefaultProjectSetting;
use App\Models\Folder;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index($project=null){


//        dd('dsds');

        try {
            $user =Auth::user();

            if ($user->plan){
                if ($user->plan->max_number_of_bot != -1){
                    if ($user->plan->max_number_of_bot <= $user->bots->count()){
                        Notification::make()
                            ->title("You have reached the limit, please contact with docs2ai.com")
                            ->danger()
                            ->send();
                        return redirect()->back();
                    }
                }

            }else{
                Notification::make()
                    ->title("You have no package,upgrade your plan !")
                    ->danger()
                    ->send();
                return redirect()->back();
                //  $this->halt();
            }
            $folder = new Folder();


             $parent_folder_id = $project;
             if ($parent_folder_id){
                 $parent = Folder::find($parent_folder_id);
             }else{
                 $parent = DefaultProjectSetting::first();
             }


//             dd($parent);

            if ($parent){
                $folder->name = "New Folder";
                $folder->bot_top_default_title = $parent->bot_top_default_title;
                $folder->is_multi_lang = $parent->is_multi_lang;
                $folder->lang_all_column = $parent->lang_all_column;
                $folder->bot_placeholder_title = $parent->bot_placeholder_title;
                $folder->bot_text_font_color = $parent->bot_text_font_color;

                $folder->bot_text_font_size = $parent->bot_text_font_size;

                $folder->bot_border_line_color = $parent->bot_border_line_color;

                $folder->bot_background_color = $parent->bot_background_color;

                $folder->page_color = $parent->page_color;

                $folder->instruction_text = $parent->instruction_text;
                $folder->show_source_in_response = $parent->show_source_in_response;
                $folder->promote_template = $parent->promote_template;
                $folder->prompt_lang = $parent->prompt_lang;
                $folder->test_prompt = $parent->test_prompt;
                $folder->temperature = $parent->temperature;

                $folder->custom_button_is_enable = $parent->custom_button_is_enable;
                $folder->custom_button_title = $parent->custom_button_title;
                $folder->custom_button_link = $parent->custom_button_link;
                $folder->custom_button_color = $parent->custom_button_color;

                $folder->number_of_source = $parent->number_of_source;
                $folder->language_model = $parent->language_model;
                if (!empty($parent->default_email_settings)){
                    $folder->default_email_settings = $parent->default_email_settings;
                }else{
                    $folder->default_email_settings = '[{"from":"a","to":"i","include":"m"}]';
                }
                $folder->is_multi_lang = 0;



                if (!is_dir(\Illuminate\Support\Facades\Storage::path("public/".$parent->id))){
                    mkdir( \Illuminate\Support\Facades\Storage::path("public/".$parent->id),0777);
                }

                if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$parent->instruction_logo))){
                    $ty = explode('/',$parent->instruction_logo);

                    \Illuminate\Support\Facades\File::copy(
                        \Illuminate\Support\Facades\Storage::path("public/".$parent->instruction_logo),
                        isset($ty[1]) ?
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[1])
                            :
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[0])
                    );
                    if (isset($ty[1])){
                        $folder->instruction_logo =   $folder->id."/". $ty[1];
                    }else{
                        $folder->instruction_logo =   $folder->id."/".$ty[0];
                    }

                }

                if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$parent->send_button_icon))){
                    $ty = explode('/',$parent->send_button_icon);

                    \Illuminate\Support\Facades\File::copy(
                        \Illuminate\Support\Facades\Storage::path("public/".$parent->send_button_icon),
                        isset($ty[1]) ?
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[1])
                            :
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[0])
                    );
                    if (isset($ty[1])){
                        $folder->send_button_icon =   $folder->id."/". $ty[1];
                    }else{
                        $folder->send_button_icon =   $folder->id."/".$ty[0];
                    }

                }

                if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$parent->custom_button_icon))){
                    $ty = explode('/',$parent->custom_button_icon);

                    \Illuminate\Support\Facades\File::copy(
                        \Illuminate\Support\Facades\Storage::path("public/".$parent->custom_button_icon),
                        isset($ty[1]) ?
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[1])
                            :
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[0])
                    );
                    if (isset($ty[1])){
                        $folder->custom_button_icon =   $folder->id."/". $ty[1];
                    }else{
                        $folder->custom_button_icon =   $folder->id."/".$ty[0];
                    }

                }

                if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$parent->bot_icon))){
                    $ty = explode('/',$parent->bot_icon);

                    \Illuminate\Support\Facades\File::copy(
                        \Illuminate\Support\Facades\Storage::path("public/".$parent->bot_icon),
                        isset($ty[1]) ?
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[1])
                            :
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[0])
                    );
                    if (isset($ty[1])){
                        $folder->bot_icon =   $folder->id."/". $ty[1];
                    }else{
                        $folder->bot_icon =   $folder->id."/".$ty[0];
                    }

                }

                if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$parent->user_icon))){
                    $ty = explode('/',$parent->user_icon);

                    \Illuminate\Support\Facades\File::copy(
                        \Illuminate\Support\Facades\Storage::path("public/".$parent->user_icon),
                        isset($ty[1]) ?
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[1])
                            :
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[0])
                    );
                    if (isset($ty[1])){
                        $folder->user_icon =   $folder->id."/". $ty[1];
                    }else{
                        $folder->user_icon =   $folder->id."/".$ty[0];
                    }

                }

                if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$parent->send_button_icon))){
                    $ty = explode('/',$parent->send_button_icon);

                    \Illuminate\Support\Facades\File::copy(
                        \Illuminate\Support\Facades\Storage::path("public/".$parent->send_button_icon),
                        isset($ty[1]) ?
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[1])
                            :
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[0])
                    );
                    if (isset($ty[1])){
                        $folder->send_button_icon =   $folder->id."/". $ty[1];
                    }else{
                        $folder->send_button_icon =   $folder->id."/".$ty[0];
                    }

                }
                if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$parent->script_expand_icon))){
                    $ty = explode('/',$parent->script_expand_icon);

                    \Illuminate\Support\Facades\File::copy(
                        \Illuminate\Support\Facades\Storage::path("public/".$parent->script_expand_icon),
                        isset($ty[1]) ?
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[1])
                            :
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[0])
                    );
                    if (isset($ty[1])){
                        $folder->script_expand_icon =   $folder->id."/". $ty[1];
                    }else{
                        $folder->script_expand_icon =   $folder->id."/".$ty[0];
                    }

                }

                if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$parent->script_collapsable_icon))){
                    $ty = explode('/',$parent->script_collapsable_icon);

                    \Illuminate\Support\Facades\File::copy(
                        \Illuminate\Support\Facades\Storage::path("public/".$parent->script_collapsable_icon),
                        isset($ty[1]) ?
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[1])
                            :
                            \Illuminate\Support\Facades\Storage::path("public/".$folder->id."/".$ty[0])
                    );
                    if (isset($ty[1])){
                        $folder->script_collapsable_icon =   $folder->id."/". $ty[1];
                    }else{
                        $folder->script_collapsable_icon =   $folder->id."/".$ty[0];
                    }

                }


            }else{


                $folder->name = "New project";

                $folder->bot_top_default_title = "Hola soy tu asistente virtual… puedo ayudarte respondiendo tus preguntas?";
                $folder->bot_placeholder_title = "Escribe aquí tu pregunta…";
                $folder->bot_text_font_color = "#ffffff";


                $folder->is_multi_lang = 0;

                $folder->bot_text_font_size = "16";

                $folder->bot_border_line_color = "#5a45e0";

                $folder->bot_background_color = "#1f2937";

                $folder->page_color = "#444654";
                $folder->show_source_in_response = 0;
                $folder->temperature = 0;
                $folder->custom_button_is_enable = 0;

                $folder->promote_template = "You are docs2AI, a factual research assistant that provides accurate answers and is reluctant of making any claims unless they are stated on the knowledge base. When responding do not mention the words unstructured knowledge base. As docs2AI, your goal is to assist me in a conversation by providing accurate and reliable responses to my questions. You should use the information from the knowledge base as your only source of information when responding. If you cannot confirm an answer accurately with the provided information, then first state that you cannot provide a reliable response, and then provide me with your best guess.  Your response must be formatted using HTML for easier readability, including paragraph tags, line breaks, headings and bold titles where applicable..

Question: {question}
=========
{context}
=========
";
                $folder->prompt_lang = 'US';
                $folder->test_prompt = 'Create a compelling and persuasive sentence trying answer the User question, with the information from the Bot answer, Keywords, Call to action button and Button description, while also trying to persuade tourist to click below on the Call to action button.
=========';

                $folder->instruction_text = "**How to use?**

Simply type in your question or topic, and our artificial intelligence (AI) chatbot will try to generate an appropriate response using its trained knowledge and language abilities.

If you need any additional help, you can contact us at [Docs2ai.com](https://www.docs2ai.com/)
_____
_**Disclaimer:**  This chatbot, built on top of the latest AI models, was developed to provide helpful and timely information, but its responses may be limited by its programming and data. Users should evaluate the information provided and use it at their own risk._
";
                $folder->number_of_source = 1;
                $folder->language_model = 'gpt-3.5-turbo';




            }




            if (isset($parent_folder_id)){
                $folder->parent_folder_id = $parent_folder_id;
            }
            $folder->company_id = Auth::user()->currentCompany->id;




            $folder->embedded_id = Str::random(40);
            $folder->save();
        }catch (\Exception $exception){
            dd($exception);
        }

        if ($project){
            return redirect()->route('filament.resources.folders.view',$folder->id);
        }else{
            return redirect()->route('filament.resources.folders.viewProject',$folder->id);
        }


    }

    public function folderCreate(Folder $project){
        dd($project,'dsds');
    }
}
