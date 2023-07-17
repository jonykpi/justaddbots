<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\DynamicPrompt;
use App\Models\MailActivity;
use App\Models\ResponseHistory;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use App\Models\Folder;
use App\Models\ThumbDown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\PdfToText\Pdf;

class ApiCOntroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $bot = Folder::with('buttons','buttons.tags','company','company.user.plan','company.user.lastMonthDate')->where('embedded_id',$request->id)->first();

       if (empty($bot->bot_text_font_color)){
           $bot->bot_text_font_color = "#ffffff";
       }
        if (empty($bot->bot_text_font_size)){
            $bot->bot_text_font_size = "14";
        }
        if (empty($bot->bot_border_line_color)){
            $bot->bot_border_line_color = "#5a45e0";
        }
        if (empty($bot->bot_background_color)){
            $bot->bot_background_color = "#444654";
        }
        if (empty($bot->page_color)){
            $bot->page_color = "#444654";
        }
        if (empty($bot->instruction_text)){
            $bot->instruction_text = "**How to use?**

Simply type in your question or topic, and our artificial intelligence (AI) chatbot will try to generate an appropriate response using its trained knowledge and language abilities.

If you need any additional help, you can contact us at [Docs2ai.com](https://www.docs2ai.com/)
_____
_**Disclaimer:**  This chatbot, built on top of the latest AI models, was developed to provide helpful and timely information, but its responses may be limited by its programming and data. Users should evaluate the information provided and use it at their own risk._
";
        }

        if (!empty($bot->bot_icon)){
            $bot->bot_icon_url = asset('storage/'.$bot->bot_icon);
        }else{
            $bot->bot_icon_url = asset('icons/bot_icon.gif');
            $bot->bot_icon = 'bot_icon.gif';
        }
        if (!empty($bot->user_icon)){
            $bot->user_icon_url = asset('storage/'.$bot->user_icon);
        }else{
            $bot->user_icon = 'icons/user_icon.png';
            $bot->user_icon_url = asset('icons/user_icon.png');
        }
        if (!empty($bot->instruction_logo)){
            $bot->instruction_logo_url = asset('storage/'.$bot->instruction_logo);
        }else{
            $bot->instruction_logo = 'icons/instruction_logo.png';
            $bot->instruction_logo_url = asset('icons/instruction_logo.png');
        }
        if (!empty($bot->send_button_icon)){
            $bot->send_button_icon_url = asset('storage/'.$bot->send_button_icon);
        }else{
            $bot->send_button_icon = 'icons/send_button.png';
            $bot->send_button_icon_url = asset('icons/send_button.png');
        }
        if (!empty($bot->button_icon)){
            $bot->button_icon = asset('storage/'.$bot->button_icon);
        }



        $last_responses =$bot->company->lastMonthDateWithCompany();

        $number_of_clicks = $bot->company->lastMonthDateWithCompany();



        $bot->number_of_response = $last_responses->sum('number_of_response');
        $bot->number_of_clicks = $number_of_clicks->sum('number_of_clicks');

        $bot->total_response = $bot->company->lastMonthDateWithCompany()->sum('number_of_response');

        unset($bot->last_email);
    return response()->json([
        'success'=>true,
        'data'=>$bot
    ]);
    }

    public function aiModelsChatecters(){
        $convert = 4;
        return [
            'gpt-3.5-turbo'=>4096*$convert-1000,
            'gpt-3.5-turbo-16k'=>60000,
            'gpt-3.5-turbo-0613'=>4096*$convert-1000,
            'gpt-3.5-turbo-16k-0613'=>60000,
            'gpt-4'=>6192,
            'gpt-4-0613'=>6192,
//            'gpt-4-32k'=>25768,
//            'gpt-4-32k-0613'=>30768,
        ];
    }
    public function botPrompts(Request $request)
    {
        $bot = Folder::with('prompts')->where('embedded_id',$request->id)->first();
        //  dd($bot->language_model,Str::length($bot->promote_template));
        $total_number_of_characters = Str::length($bot->promote_template);


        $available_characters = $this->aiModelsChatecters()[$bot->language_model] - $total_number_of_characters;
//dd($available_characters,$total_number_of_characters);
//        dd($this->aiModelsChatecters()[$bot->language_model],$total_number_of_characters,$available_characters);

//        ->where('tags',"LIKE","%".$request->q."%")
        $q = $request->q;


        $bot_prompts =DynamicPrompt::where('folder_id',$bot->id)
            ->where(function ($query) use ($q) {
                foreach (explode(' ',$q) as $term) {
                    $query->orWhere('tags', "LIKE","%".$term."%");
                    $query->orWhere('tags', "LIKE","%default_load%");
                }
            });



        $bot_prompts = $bot_prompts->get();
        $default_promot = $bot_prompts->where('tags',['default_load']);
        $bot_prompts = $bot_prompts->reject(function ($item) use ($request) {
            $check_tag = false;
            foreach ($item->tags as $tag){
                if (strpos(Str::upper($request->q), Str::upper($tag)) !== false) {
                    $check_tag = true;
                }
            }

            if (!$check_tag){
                return $item;
            }
        });



        $extra_prompts = "";
        foreach ($bot_prompts as $bot_prompt){

            $extra_prompts .= " ".$bot_prompt->prompt;
        }

        if (empty($extra_prompts) && !empty($default_promot->first())){
            $extra_prompts = $default_promot->first()->prompt;
        }


        $pro = str_replace("{"," ",$extra_prompts);

        $pro = str_replace("}"," ",$pro);
        $pro = str_replace("["," ",$pro);
        $pro = str_replace("]"," ",$pro);





        $pro = substr($pro,0,$available_characters);

        return response()->json([
            'success'=>true,
            'language_model'=>$this->aiModelsChatecters()[$bot->language_model],
            'dynamic_prompt'=>Str::length($pro),
            'main_prompt'=>$total_number_of_characters,
            'data'=>$pro

        ]);
    }
    public function Commands(Request $request)
    {
    $bot = Folder::with('commands')->where('embedded_id',$request->id)->first();

    return response()->json([
        'success'=>true,
        'data'=>$bot->commands()->where('status',1)->get()

    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function incoming(Request $request)
    {

        $data = ['status'=>false,'message'=>__('Something went wrong')];

        try {
        //   DB::beginTransaction();

            $folder = Folder::where('email',$request->envelope['to'])->first();

            $priority_from_email = false;
            if ($folder){

                if ($folder->email_status == 0){
                    $data['message'] = __('Disable');
                    return $data;
                }

                $last_email_data = $request->request->all();
                unset($last_email_data['attachments']);

                $folder->last_email = $last_email_data;
                $folder->save();
                if (!isset($request->attachments[0])){
                    $data['status'] = true;
                    $data['message'] = __('completed');
                    return $data;
                }
//                if($request->attachments[0]['content_type'] != "application/octet-stream"){
//                    $data['message'] = __('File is not pdf type');
//                    return $data;
//                }


                $file_id = $folder->default_file_id != "new" ? $folder->default_file_id : null ;
                $email = $request->envelope['from'];

                $prompt = "";

                if ($folder->default_then == "Custom PROMPT"){
                    $prompt = $folder->default_custom_prompt;
                }
                elseif($folder->default_then == "SUMMARIZE") {
                    $prompt = 'summary';
                }


                $temperature = null;
                $subject = $request->all()['headers']['subject'];
                $subject = explode('[[',$subject);


                if (isset($subject[1])){
                    $subject = explode(']]',$subject[1])[0];
                    $subject = explode("|",$subject);
                    foreach ($subject as $item){
                        $priority_from_email = true;
                        $explode = explode("=",$item);
                        if ($explode[0] == "replace"){
                            $file_id = $explode[1];
                        }
                        if ($explode[0] == "email"){
                            $email = $explode[1];
                        }
                        if ($explode[0] == "prompt"){
                            $prompt = $explode[1];
                        }
                        if ($explode[0] == "temperature"){
                            $temperature = $explode[1];
                        }
                    }
                }





                $upload_text = "uploaded";
                $content = new Content();
                if (!empty($file_id)){
                    $content = Content::where("file_id",$file_id)->first();
                    $upload_text = "updated";
                    if (!empty($content)){
                        $media =  $content->media()->where('collection_name','images')->orderByDesc('id')->first();
                        deleteVector($content->folder->embedded_id,[Storage::path("public/".$media->id."/".$media->file_name)]);
                        if (!empty($content->file_title)){
                            deleteVector($content->folder->embedded_id,[$this->clean($content->file_title)]);
                        }
                    }else{
                        $content = new Content();
                        $content->file_id = Str::random(10);
                    }
                }else{
                    $content->file_id = Str::random(10);
                }


                if (isset($request->attachments[0])){

                    $attachment = $request->attachments[0];

                    $ext = pathinfo($attachment['file_name'], PATHINFO_EXTENSION);

                    $name = str_replace('.'.$ext,'',$attachment['file_name'])."-".strtotime(date('Y-m-d H:i:s'));

                    $attachment['file_name'] = $name.".".$ext;

                    $content->file_title = $attachment['file_name'];
                    $content->folder_id = $folder->id;
                    $content->text_data = 'default';
                    $content->type = 'file';

                    $content->save();

                    $content->addMediaFromBase64($attachment['content'])
                        ->usingName($attachment['file_name'])
                        ->usingFileName($attachment['file_name'])
                        ->toMediaCollection('images');


                    $media =  $content->media()->where('collection_name','images')->orderByDesc('id')->first();


                    $file_path = Storage::path('public/'.$media->id.'/'.$media->file_name);

                    $request = $request->all();
                    $request['attachments'][0]['file_path'] = $file_path;



                    $pdfTpath = env('APP_ENV') == 'local' ? '/opt/homebrew/bin/pdftotext' : '/usr/bin/pdftotext';

                    $text = (new Pdf($pdfTpath))
                        ->setPdf($file_path)->text();


                    MailActivity::create(['folder_id'=>$folder->id,'log'=>$request['headers']['from'].":-".$content->file_title." ".$upload_text. " successfully"]);


                    $client = new \GuzzleHttp\Client();
                    $response = $client->post(
                        env('BOT_URL')."/api/training",
                        [
                            RequestOptions::JSON =>
                                [
                                    'name' => $this->clean($content->file_title),
                                    'pincone_name' => $folder->embedded_id,
                                    'content' => $text,
                                ]
                        ],
                        ['Content-Type' => 'application/json']
                    );

                    $responseJSON = json_decode($response->getBody(), true);

                    if ($responseJSON['status'] == false){
                        $content->is_learned = '1';
                    }else{
                        $content->is_learned = '0';
                    }

                    $content->save();
                    $data['status'] = true;
                    $data['message'] = __('Done');

                }



            }

            if ($data['status'] == true && $content->is_learned){


$prompt_summery = "";


if($prompt == "summary"){
    $client = new \GuzzleHttp\Client();
    $response = $client->post(
        env('BOT_URL')."/api/summarization",
        [
            RequestOptions::JSON =>
                [
                    'text' => $text
                ]
        ],
        ['Content-Type' => 'application/json']
    );
    $prompt_summery = json_decode($response->getBody())->text;

}elseif(!empty($prompt)){
    $promote_template  =$content->folder->promote_template;

    // @ts-ignore
    $promote_template .= "\n\n\n\nQuestion: {question}\n
                  =========\n
               {context}\n
                =========\n\n\n\n\n";
    $promote_template .= "Answer in ".languages()[$content->folder->prompt_lang];


    $client = new \GuzzleHttp\Client();
    $response = $client->post(
        env('BOT_URL')."/api/api2chat",
        [
            RequestOptions::JSON =>
                [
                    'currentIndex' => 'jony',
                    'widget' => $content->folder->embedded_id,
                    'history' => [],
                    'question' => $prompt,
                    'temperature' => 0,
                    'promote_template' => $promote_template
                ]
        ],
        ['Content-Type' => 'application/json']
    );
    $prompt_summery = json_decode($response->getBody())->text;

}




              if (!empty($prompt_summery)){
                  $content->summery = $prompt_summery;
                  $content->save();
              }

              //  DB::commit();

                if ($priority_from_email){
                    MailActivity::create(['folder_id'=>$folder->id,'log'=>$request['headers']['from'].":-"."Mail sent to ".$email]);
                    Mail::to($email)->send(new \App\Mail\SuccessfullyInsertedByApi($upload_text,$content,$prompt_summery,$prompt));
                }else{
                    // dynamic reply

                    foreach (json_decode($folder->default_email_settings) as $def_email_settings){
                        dispatch(new \App\Jobs\DynamicReplyFromEmail($def_email_settings,$folder,$request,$upload_text,$content,$prompt_summery,$prompt))->delay(Carbon::now()->addSeconds(5));
                    }
                    // dynamic reply
                }
            }else{

                if (!empty($email))
                Mail::to($email)->send(new \App\Mail\UnSeccessfulInsertedByApi($upload_text,$content,$request['headers']['from']));

               // DB::rollBack();
            }




        }catch (\Exception $exception){
//            dd($exception);
             Log::info(json_encode($exception->getMessage()."----".$exception->getFile()));
          //  Mail::to($email)->send(new \App\Mail\UnSeccessfulInsertedByApi($upload_text,$content,$request->all()['headers']['subject']));
           // DB::rollBack();
            return $data;

        }



      return $data;
    }

    public function ocrCallback(Request $request){
        try {
            $content = Content::find($request->identify);

            $oldFile = $content->media()->first();

            $content->addMediaFromBase64($request->content)
                ->usingName($oldFile->name)
                ->usingFileName($oldFile->file_name)
                ->toMediaCollection('images');
            $oldFile->delete();

            $media =  $content->media()->where('collection_name','images')->orderByDesc('id')->first();
            $file_path = Storage::path('public/'.$media->id.'/'.$media->file_name);
            $pdfTpath = env('APP_ENV') == 'pc' ? '/opt/homebrew/bin/pdftotext' : '/usr/bin/pdftotext';
            $text = (new Pdf($pdfTpath))
                ->setPdf($file_path)->text();

            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                env('BOT_URL')."/api/training",
                [
                    RequestOptions::JSON =>
                        [
                            'name' => $file_path,
                            'pincone_name' => $content->folder->embedded_id,
                            'content' => $text,
                        ]
                ],
                ['Content-Type' => 'application/json']
            );

            $responseJSON = json_decode($response->getBody(), true);


            if ($responseJSON['status'] == false){
                $content->is_learned = '1';
            }else{
                $content->is_learned = '0';
            }
            $content->save();
            return "Success";
        }catch (\Exception $exception){
            return $exception->getMessage()."--".$exception->getFile()."---".$exception->getLine();
        }

    }


    public function filterMonths(){

        $months = [[
            'name'=>"All",
            'start'=>"2020-10-11",
            'end'=>"2030-10-11",
        ],[
            'name'=>"CURRENT",
            'start'=>Carbon::now()->startOfMonth()->format('Y-m-d'),
            'end'=>Carbon::now()->format('Y-m-d'),
        ]];
        foreach (ResponseHistory::select("date",DB::raw("DATE_FORMAT(date, '%m-%Y') new_date"),  DB::raw('YEAR(date) year, MONTH(date) month'))
                     ->where("date","<",Carbon::now()->startOfMonth())
                     ->where("company_id","=",Cache::get('company')->id)
                     ->groupBy('year','month')
                     ->orderBy('id','asc')
                     ->get() as $item){

          array_push($months,[
              'name'=>Carbon::parse($item->date)->format('F Y'),
              'start'=>Carbon::parse($item->date)->startOfMonth()->format('Y-m-d'),
              'end'=>Carbon::parse($item->date)->endOfMonth()->format('Y-m-d'),
          ]);
        }
       return response()->json(['results'=>$months]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function test(Request $request)
    {
        $content = Content::find($request->id);
        $media = $content->media()->first();

        $file_path = Storage::path('public/'.$media->id.'/'.$media->file_name);

        $_data= [
            'content' => base64_encode(file_get_contents($file_path)),
            'identify' =>$request->id,
            'callback' => route('ocr-callback'),
        ];
        try {
            $response = Http::timeout(600)->post(env('OCR_API'), $_data);
            return $response;
        }catch (\Exception $exception){
            dd($exception);
        }






//        $client = new Client();
//        $response = $client->request('POST', env('OCR_API'), [
//            'identify' =>$request->id,
//            'callback' => route('ocr-callback'),
//            'multipart' => [
//                [
//                    'name' => 'file',
//                    'contents' => base64_encode(file_get_contents($file_path)),
//                ],
//                [
//                    'name' => 'other_field',
//                    'contents' => 'value',
//                ],
//            ],
//        ]);
//
//        dd($response);
        return $response;
    }
    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function whatsappIncoming(Request $request){


        try {
            if (is_array($request->entry) && isset($request->entry[0])){
                $in_details =$request->entry[0]['changes'][0]['value']['messages'][0];
                $phone_number_id = $request->entry[0]['changes'][0]['value']['metadata']['phone_number_id'];
                $folder = Folder::where('whatsapp_id',$phone_number_id)->first();

                $accessToken = $folder->whatsapp_access_token;
                $fromPhoneNumberId = $phone_number_id;
                $phoneNumber = "+".$in_details['from'];

                $curlCall = Http::get(route('bot-prompts')."?id=".$folder->embedded_id."&q=".$in_details['text']['body']);



                $promote_template = $folder->promote_template." ".$curlCall->json()['data'];


                // @ts-ignore
                Log::info($promote_template);

                $_data = [
                    'currentIndex' => 'jony',
                    'widget' => $folder->embedded_id,
                    'history' => [],
                    'question' => $in_details['text']['body'],
                    'temperature' => 0,
                    'promote_template' => $folder->promote_template,
                    'model' => $folder->language_model,
                    'number_of_source' => $folder->number_of_source,
                    'extra_prompt' => $curlCall->json()['data'],
                    'prompt_lang' => languages()[$folder->prompt_lang],
                ];
                Log::info('data sent');
                Log::info($_data);

                $response = Http::post('https://chat.docs2ai.com/api/api2chat', $_data);
                $details = json_decode($response->body());


                $client = new Client();
                $messageContent = $details->text;



                $response = $client->post("https://graph.facebook.com/v16.0/{$fromPhoneNumberId}/messages", [
                    "headers" => [
                        "Authorization" => "Bearer {$accessToken}",
                        "Content-Type" => "application/json",
                    ],
                    "json" => [
                        "messaging_product" => "whatsapp",
                        "recipient_type" => "individual",
                        "to" => $phoneNumber,
                        "type" => "text",
                        'sender_action' => 'typing_on',
                        "text" => [
                            "preview_url" => false,
                            "body" => $messageContent,
                        ],
                    ],
                ]);

                $count_data = [
                    'embedded_id'=>$folder->embedded_id,
                    'type'=>1,
                ];
                Http::post(route('responseCallback'),$count_data);
            }


        }catch (\Exception $exception){
            return $exception->getMessage()."===".$exception->getFile();
        }
        return $request->hub_challenge;
    }

    public function thumbLogs(Request $request){
//        Log::info($request->message);

        $folder = Folder::where('embedded_id',$request->widget)->first();

        ThumbDown::create([
            'folder_id'=>$folder->id,
            'question'=>$request->question,
            'answer'=>$request->message,
        ]);

        return response()->json(['success'=>true]);

    }

    public function responseCallback(Request $request){

        $folder = Folder::where('embedded_id',$request->widget)->first();


        $model_type = "gpt3";
        if (empty($request->model) && in_array($folder->language_model,['gpt-4','gpt-4-0613'])){
            $model_type = "gpt4";
        }




        $user = ResponseHistory::where('user_id',$request->user_id)
            ->where([
                'user_id'=>$request->user_id,
                'folder_id'=>$folder->id,
                'company_id'=>$folder->company->id,
                'date'=>Carbon::now()->startOfMonth()->format('Y-m-d'),
                'model_type'=>$model_type,
            ])
            ->first();
         if (empty($user)){
             $user =  ResponseHistory::create([
                 'user_id'=>$request->user_id,
                 'folder_id'=>$folder->id,
                 'company_id'=>$folder->company->id,
                 'date'=>Carbon::now()->startOfMonth()->format('Y-m-d'),
                 'number_of_response'=>0,
                 'number_of_clicks'=>0,
                 'model_type'=>$model_type,
             ]);
         }
        if ($request->type == 1){
            $user->increment('number_of_response');

      }else{
            $user->increment('number_of_clicks');
        }
        $user->save();


        $bot = Folder::with('buttons','buttons.tags','company','company.user.plan','company.user.lastMonthDate')->where('embedded_id',$request->id)->first();

        if (empty($bot->bot_text_font_color)){
            $bot->bot_text_font_color = "#ffffff";
        }
        if (empty($bot->bot_text_font_size)){
            $bot->bot_text_font_size = "14";
        }
        if (empty($bot->bot_border_line_color)){
            $bot->bot_border_line_color = "#5a45e0";
        }
        if (empty($bot->bot_background_color)){
            $bot->bot_background_color = "#444654";
        }
        if (empty($bot->page_color)){
            $bot->page_color = "#444654";
        }
        if (empty($bot->instruction_text)){
            $bot->instruction_text = "**How to use?**

Simply type in your question or topic, and our artificial intelligence (AI) chatbot will try to generate an appropriate response using its trained knowledge and language abilities.

If you need any additional help, you can contact us at [Docs2ai.com](https://www.docs2ai.com/)
_____
_**Disclaimer:**  This chatbot, built on top of the latest AI models, was developed to provide helpful and timely information, but its responses may be limited by its programming and data. Users should evaluate the information provided and use it at their own risk._
";
        }

        if (!empty($bot->bot_icon)){
            $bot->bot_icon_url = asset('storage/'.$bot->bot_icon);
        }else{
            $bot->bot_icon_url = asset('icons/bot_icon.gif');
            $bot->bot_icon = 'bot_icon.gif';
        }
        if (!empty($bot->user_icon)){
            $bot->user_icon_url = asset('storage/'.$bot->user_icon);
        }else{
            $bot->user_icon = 'icons/user_icon.png';
            $bot->user_icon_url = asset('icons/user_icon.png');
        }
        if (!empty($bot->instruction_logo)){
            $bot->instruction_logo_url = asset('storage/'.$bot->instruction_logo);
        }else{
            $bot->instruction_logo = 'icons/instruction_logo.png';
            $bot->instruction_logo_url = asset('icons/instruction_logo.png');
        }
        if (!empty($bot->send_button_icon)){
            $bot->send_button_icon_url = asset('storage/'.$bot->send_button_icon);
        }else{
            $bot->send_button_icon = 'icons/send_button.png';
            $bot->send_button_icon_url = asset('icons/send_button.png');
        }
        if (!empty($bot->button_icon)){
            $bot->button_icon = asset('storage/'.$bot->button_icon);
        }



        unset($bot->last_email);
        return response()->json([
            'success'=>true,
            'data'=>$bot
        ]);
    }
}
