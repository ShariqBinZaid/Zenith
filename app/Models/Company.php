<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Company extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
    public function CompanyOwner()
    {
        return $this->hasOne(User::class,'id','owner');
    }
    public function units(){
        return $this->hasMany(Units::class);
    }
    public function getBrand()
    {
        return $this->hasOne(Brands::class,'id','brand_id');
    }
    public function getPackage()
    {
        return $this->hasOne(Packages::class,'id','package_id');
    }
}
