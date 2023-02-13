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
    use SoftDeletes,LogsActivity;
    protected $fillable = [
        'id',
        'date',
        'year',
        'userid',
        'type',
        'reason',
        'status',
        'half_day',
        
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
}
