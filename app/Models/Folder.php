<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Folder extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'lang_all_column' => 'json',
    ];
    public function contents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Content::class);
    }

    public function prompts(){
        return $this->hasMany(DynamicPrompt::class,'folder_id','id');
    }

    public function children(){
         return $this->hasMany(Folder::class,'parent_folder_id','id');
    }
    public function parent(){
         return $this->belongsTo(Folder::class,'parent_folder_id','id');
    }
    public function company(){
         return $this->belongsTo(Company::class,'company_id','id');
    }
    public function commands()
    {
        return $this->hasMany(Command::class,'folder_id','id');
    }



    public function buttons(){
        return $this->hasMany(DynamicButton::class)->where('status',1);
    }

    public function responseGpt3(){
        return $this->hasOne(ResponseHistory::class,'folder_id','id')
            ->where('date',"<=",Cache::get('end') ?? Carbon::now())
            ->where('date',">=",Cache::get('start') ?? Carbon::now()->startOfMonth())
            ->where('model_type','gpt3');
    }
    public function responseAll(){
        return $this->hasOne(ResponseHistory::class,'folder_id','id')
            ->where('date',"<=",Cache::get('end') ?? Carbon::now())
            ->where('date',">=",Cache::get('start') ?? Carbon::now()->startOfMonth() );
    }

    public function responseGpt4(){
        return $this->hasOne(ResponseHistory::class,'folder_id','id')
            ->where('date',"<=",Cache::get('end') ?? Carbon::now())
            ->where('date',">=",Cache::get('start') ?? Carbon::now()->startOfMonth() )
            ->where('model_type','gpt4');
    }

    public function mediaSize(){
        return $this->hasMany(Content::class,'folder_id','id')
            ->leftjoin('media','media.model_id','contents.id', function ($join) {
                $join->on('media.model_type', '=', 'App\Models\Content');
            })
            ->select('media.*');
    }




}
