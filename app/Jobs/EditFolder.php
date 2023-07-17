<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EditFolder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $arr = [
            'bot_top_default_title'=>$this->model->bot_top_default_title,
            'bot_placeholder_title'=>$this->model->bot_placeholder_title,
            'custom_button_title'=>$this->model->custom_button_title
        ];
        $this->model->lang_all_column = (array) translateArray($arr);
        $this->model->save();
    }
}
