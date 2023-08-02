<?php

namespace App\Models;

use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Wallo\FilamentCompanies\HasCompanies;
use Wallo\FilamentCompanies\HasProfilePhoto;

class User extends Authenticatable implements FilamentUser, HasAvatar,MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasCompanies;
    use Notifiable;
    use TwoFactorAuthenticatable;

    public function canAccessFilament(): bool
    {
        return true;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile_photo_url;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'last_login' => 'datetime',
    ];

//    public function getCreatedAtAttribute()
//    {
//        return Carbon::parse($this->original['created_at'])->format('d/m/y');
//    }
//    public function getLastLoginAttribute()
//    {
//
//        return ($this->original['last_login']) ? Carbon::parse($this->original['last_login'])->format('d/m/y') : "N/A";
//    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

//    public function company()
//    {
//        return $this->hasOne(Company::class,'user_id','id');
//    }
    public function company()
    {
        return $this->hasOne(Company::class,'id','current_company_id');
    }
    public function myCompanies()
    {
        return $this->hasMany(Company::class,'user_id','id');
    }

    public function plan(){
        return $this->hasOne(Plan::class,'id','plan_id');
    }
    public function mediaSize(){
        return $this->hasManyThrough(Folder::class,Company::class)
            ->leftjoin('contents','contents.folder_id','folders.id')
            ->leftjoin('media','media.model_id','contents.id', function ($join) {
                $join->on('media.model_type', '=', 'App\Models\Content');
            })
            ->select('media.*')
            ->where('folders.parent_folder_id',"!=",null);
    }

    public function mediaSize2(){
        return $this->hasManyThrough(Folder::class,Company::class)
            ->join('contents','contents.folder_id','folders.id')
            ->join('media','media.model_id','contents.id', function ($join) {
                $join->on('media.model_type', '=', 'App\Models\Content');
            })
            ->select('media.*')
            ->where('folders.parent_folder_id',"!=",null);
    }

    public function bots(){
        return $this->hasManyThrough(Folder::class,Company::class)
            ->where('folders.parent_folder_id',"!=",null);
    }

    public function lastMonthDate(){
        if (Cache::get('start') && Cache::get('end')){
            return $this->hasOne(ResponseHistory::class)
                ->where('date',">=",Cache::get('start'))
                ->where('date',"<=",Cache::get('end'));
        }
        return $this->hasOne(ResponseHistory::class)
            ->where('date',Carbon::now()->startOfMonth()->format('Y-m-d'))->orderBy('id','desc');
    }
    public function lastMonthDateWithCompany($type = null){
      //  dd('sdsd',$this->company->id);
        if ($this->company)
        $qr = ResponseHistory::where('company_id', $this->company->id);
        $qr = ResponseHistory::query();
        if ($type){
            $qr = $qr->where('model_type',$type) ;
        }
        if (Cache::get('start') && Cache::get('end'))
        {

            return $qr->where('date',">=",Cache::get('start'))
                ->where('date',"<=",Cache::get('end'));
        }

        return $qr->where('date',Carbon::now()->startOfMonth()->format('Y-m-d'));
    }





}
