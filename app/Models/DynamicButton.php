<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use \Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;


class DynamicButton extends Model implements HasMedia
{
    use HasFactory;
    use HasTags;
    use InteractsWithMedia;
    protected $guarded = [];
    protected $appends = ['button_icon_link'];

    protected $casts = [
        'master_tags' => 'array',
        'lang_title' => 'json',
    ];


    protected function getButtonIconLinkAttribute(){

       return asset('storage/'.$this->button_icon);
}




}
