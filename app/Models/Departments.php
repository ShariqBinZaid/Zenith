<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Departments extends Model
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
        'name','company_id','desc'
    ];
    
    public function getCompany()
    {
        return hasOne(Company::class);
    }
    
}
