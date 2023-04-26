<?php

namespace App\Http\Controllers;

use App\Models\Content;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use App\Models\Folder;
use App\Models\ThumbDown;
use Illuminate\Http\Request;
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
    $bot = Folder::where('embedded_id',$request->id)->first();

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
    return response()->json([
        'success'=>true,
        'data'=>$bot
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

            if ($folder){

                if ($folder->email_status == 0){
                    $data['message'] = __('Disable');
                    return $data;
                }

                $folder->last_email = $request->request->all();
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


                $file_id = null;
                $email = $request->envelope['from'];
                $prompt = null;
                $temperature = null;
                $subject = $request->all()['headers']['subject'];
                $subject = explode('[[',$subject);

                if (isset($subject[1])){
                    $subject = str_replace(']]','',$subject[1]);
                    $subject = explode("|",$subject);
                    foreach ($subject as $item){
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

                    $content->save();

                    $content->addMediaFromBase64($attachment['content'])
                        ->usingName($attachment['file_name'])
                        ->usingFileName($attachment['file_name'])
                        ->toMediaCollection('images');


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
                    'promote_template' => $content->folder->promote_template
                ]
        ],
        ['Content-Type' => 'application/json']
    );
    $prompt_summery = json_decode($response->getBody())->text;

}



              //  DB::commit();
                Mail::to($email)->send(new \App\Mail\SuccessfullyInsertedByApi($upload_text,$content,$prompt_summery,$prompt));
            }else{

                if (!empty($email))
                Mail::to($email)->send(new \App\Mail\UnSeccessfulInsertedByApi($upload_text,$content,$request->all()['headers']['subject']));
               // DB::rollBack();
            }
        }catch (\Exception $exception){
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

    public function whatsappIncoming(Request $request){

        Log::info(json_encode($request->all()));

        try {
            if (is_array($request->entry) && isset($request->entry[0])){
                $in_details =$request->entry[0]['changes'][0]['value']['messages'][0];
                $phone_number_id = $request->entry[0]['changes'][0]['value']['metadata']['phone_number_id'];
                $folder = Folder::where('whatsapp_id',$phone_number_id)->first();


                $_data = [
                    'currentIndex' => 'jony',
                    'widget' => $folder->embedded_id,
                    'history' => [],
                    'question' => $in_details['text']['body'],
                    'temperature' => 0,
                    'promote_template' => $folder->promote_template,
                ];

                $response = Http::post('https://chat.docs2ai.com/api/api2chat', $_data);
                $details = json_decode($response->body());


                $client = new Client();

                $accessToken = $folder->whatsapp_access_token;
                $fromPhoneNumberId = $phone_number_id;
                $phoneNumber = "+".$in_details['from'];
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
                        "text" => [
                            "preview_url" => false,
                            "body" => $messageContent,
                        ],
                    ],
                ]);
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
}
