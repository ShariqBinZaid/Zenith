<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Finance extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    
    protected $fillable = ['month','year','amount','currencyid','desc','userid','unitid','companyid'];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
    
    public function getCurrency()
    {
        return $this->hasOne(Currency::class,'id','currencyid');
    }
    
    public function getUnit()
    {
        return $this->hasOne(Units::class,'id','unitid');
    }
    
    public function getCompany()
    {
        return $this->hasOne(Company::class,'id','companyid');
    }
    
    public function AddedBy()
    {
        return $this->hasOne(User::class,'id','userid');
    }
}
