<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Fleet extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
    
    protected $fillable = [
        'car_name','model','km','chassis_number','engine_number','user_id','company_id','car_number','video','rent','assign_date','vendor','cc','vendor_number'
    ];
    
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
