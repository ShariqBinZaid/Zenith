<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Leaves extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    
    protected $fillable = [
        'id',
        'date',
        'year',
        'userid',
        'type',
        'reason',
        'final_status',
        'lead_status',
        'hr_status',
        'half_day',
        'unit_id',
        'company_id',
        
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['userid', 'status','leavetype.name']);
        // Chain fluent methods for configuration options
    }
    
    public function leavetype()
    {
        return $this->hasOne(LeaveTypes::class,'id','type');
    }
    public function user()
    {
        return $this->hasOne(User::class,'id','userid');
    }
}
