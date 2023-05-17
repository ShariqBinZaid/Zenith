<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Attendance extends Model
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
        'userid',
        'timein',
        'timeout',
        'totalhours',
        'date'
    ];
    
    public function notifyalert()
    {
        return $this->morphMany(Notify::class,'notifiable');
    }
    public function getUser()
    {
        return $this->hasOne(User::class,'id','userid');
    }
    
    public function getShift()
    {
        return $this->hasOne(Shifts::class,'userid','id');
    }
}
