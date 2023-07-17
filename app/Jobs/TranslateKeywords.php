<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TranslateKeywords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $keywords,$languages,$model,$is_update;
    public function __construct($keywords,$languages,$model,$is_update)
    {
      $this->languages = $languages;
      $this->keywords = $keywords;
      $this->model = $model;
      $this->is_update = $is_update;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      $title_translate =   translateString($this->model->button_title,$this->languages);
        $this->model->lang_title =(array) $title_translate;
        $this->model->save();

//
      $translates =   translateKeywords($this->keywords,$this->languages);
        DB::table('taggables')->where('taggable_id',$this->model->id)->delete();
      foreach ($translates as $translate){
          if ($this->is_update){

                  $this->model->attachTags(array_values((array) $translate));
          }else{
                $this->model->attachTags(array_values((array) $translate));
          }

          $this->model->save();
      }
    }
}
