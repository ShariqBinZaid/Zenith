<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Units extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
    protected $fillable = ['name','company_id','unithead','desc'];
    public function getCompany()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }
    public function getUnitHead()
    {
        return $this->hasOne(User::class,'id','unithead');
    }
    public function brands()
    {
        return $this->hasMany(Brands::class,'unit_id','id');
    }
}
