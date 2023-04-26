<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function contents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Content::class);
    }

    public function children(){
         return $this->hasMany(Folder::class,'parent_folder_id','id');
    }
    public function parent(){
         return $this->belongsTo(Folder::class,'parent_folder_id','id');
    }

}
