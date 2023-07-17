<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Wallo\FilamentCompanies\Company as FilamentCompaniesCompany;
use Wallo\FilamentCompanies\Events\CompanyCreated;
use Wallo\FilamentCompanies\Events\CompanyDeleted;
use Wallo\FilamentCompanies\Events\CompanyUpdated;

class Company extends FilamentCompaniesCompany
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'personal_company' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'personal_company',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => CompanyCreated::class,
        'updated' => CompanyUpdated::class,
        'deleted' => CompanyDeleted::class,
    ];

    public function projects(){
        return $this->hasMany(Folder::class,'company_id','id')->whereNull('parent_folder_id');
    }
    public function folders(){
        return $this->hasMany(Folder::class,'company_id','id')->where('parent_folder_id',"!=",null);
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function lastMonthDateWithCompany(){
        //  dd('sdsd',$this->company->id);
        if (Cache::get('start') && Cache::get('end')){
            return $this->hasMany(ResponseHistory::class)
                ->where('date',">=",Cache::get('start'))
                ->where('date',"<=",Cache::get('end'));
        }
        return $this->hasMany(ResponseHistory::class)->where('date',Carbon::now()->startOfMonth()->format('Y-m-d'));

    }




}
