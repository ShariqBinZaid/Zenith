<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Announcements extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = [
        'text',
        'added_by',
        'announcement_type',
        'announcement_id'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
    public function companyannouncements()
    {
        return $this->morphMany(Company::class,'announcement');
    }
    public function unitAnnouncements()
    {
        return $this->morphMany(Units::class,'announcement');
    }
    public function departAnnouncements()
    {
        return $this->morphMany(Departments::class,'announcement');
    }
    public function teamAnnouncements()
    {
        return $this->morphMany(Teams::class,'announcement');
    }
    public function user()
    {
        return $this->hasOne(User::class,'id','added_by');
    }
}
