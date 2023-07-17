<?php

namespace App\Jobs;

use App\Models\Content;
use App\Models\Folder;
use App\Models\MailActivity;
use GuzzleHttp\RequestOptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\PdfToText\Pdf;

class DynamicReplyFromEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
   public $link = "",$def_email_settings,$folder,$request,$upload_text,$content,$prompt_summery,$prompt;
    public function __construct($def_email_settings,$folder,$request,$upload_text,$content,$prompt_summery,$prompt)
    {
       $this->def_email_settings = $def_email_settings;
       $this->folder = $folder;
       $this->request = $request;
       $this->upload_text = $upload_text;
       $this->content = $content;
       $this->prompt_summery = $prompt_summery;
       $this->prompt = $prompt;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
//        'a'=> 'CHATBOT LINK in EMAIL BODY',
//        'b' =>'BOT ANSWER in EMAIL BODY',
//        'c' =>'Custom EMAIL SUBJECT with {answer}',
//        'd' =>'BOT ANSWER to ANOTHER BOT',
//        'e' =>'PDF FILE to ANOTHER BOT',

//        to
//        $return['i'] ='EMAIL SENDER';
//        $return['j'] = 'CUSTOM EMAIL';

      $from = $this->def_email_settings->from;
      $to = $this->def_email_settings->to;
      $include = $this->def_email_settings->include;

        if (in_array($from,['a','b','c'])){
            if ($to == "i"){
                $_from = $this->request['envelope']['from'];
            }else{
                $_from = $this->def_email_settings->custom_email;
            }
          $this->link = 'https://chat.docs2ai.com/?widget='.$this->folder->embedded_id;
            MailActivity::create(['folder_id'=>$this->folder->id,'log'=>$this->request['headers']['from'].":-"."Mail sent to ".$_from]);
          Mail::to($_from)->send(new \App\Mail\SuccessfullySendUploadEmail($from,$this->upload_text,$this->request,$this->content,$this->prompt_summery,$this->prompt,$this->link,$include,$this->def_email_settings));
        }elseif (in_array($from,['d','e'])){

            if ($from == "d"){
                $this->uploadText();


            }
            if ($from == "e"){
                $this->uploadFile();
            }
        }
    }
    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    function uploadText(){
        if ($this->request['plain']){
            $content = new Content();
            if (!empty($this->def_email_settings->include)){
                $content = Content::where("id",$this->def_email_settings->include)->first();

                if (!empty($content)){
                    if ($content->type == "file"){
                        $media =  $content->media()->where('collection_name','images')->orderByDesc('id')->first();
                        deleteVector($content->folder->embedded_id,[Storage::path("public/".$media->id."/".$media->file_name)]);
                    }else {
                        if (!empty($content->file_title)){
                            deleteVector($content->folder->embedded_id,[$this->clean($content->file_title)]);
                        }
                    }

                }else{
                    $content = new Content();
                    $content->file_id = Str::random(10);
                }
            }else{
                $content->file_id = Str::random(10);
            }
            $folder = Folder::find($this->def_email_settings->to);

            $content->file_title = $this->clean($this->request['headers']['from']);
            $content->folder_id = $folder->id;
            $content->row_text = $this->request['html'];
            $content->type = 'txt';

            $content->save();

            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                env('BOT_URL')."/api/training",
                [
                    RequestOptions::JSON =>
                        [
                            'name' => $this->clean($content->file_title),
                            'pincone_name' => $folder->embedded_id,
                            'content' => $this->request['plain'],
                        ]
                ],
                ['Content-Type' => 'application/json']
            );

            MailActivity::create(['folder_id'=>$this->folder->id,'log'=>$this->request['headers']['from'].":-"."Text uploaded to ".$folder->name." replace with ".$content->file_id]);
        }



    }

    function uploadFile(){

        $content = new Content();
        if (!empty($this->def_email_settings->include)){
            $content = Content::where("id",$this->def_email_settings->include)->first();

            if (!empty($content)){
                $media =  $content->media()->where('collection_name','images')->orderByDesc('id')->first();
                if (!empty($media)){
                    deleteVector($content->folder->embedded_id,[Storage::path("public/".$media->id."/".$media->file_name)]);
                }

            }else{
                $content = new Content();
                $content->file_id = Str::random(10);
            }
        }else{
            $content->file_id = Str::random(10);
        }
        $folder = Folder::find($this->def_email_settings->to);


        if (isset($this->request['attachments'][0])){
            $attachment = $this->request['attachments'][0];
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


            $request['attachments'][0]['file_path'] = $file_path;



            $pdfTpath = env('APP_ENV') == 'local' ? '/opt/homebrew/bin/pdftotext' : '/usr/bin/pdftotext';

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
            MailActivity::create(['folder_id'=>$this->folder->id,'log'=>$this->request['headers']['from'].":-"."Attachment uploaded to ".$folder->name." replace with ".$content->file_id]);
            $data['status'] = true;
            $data['message'] = __('Done');

        }
    }
}
