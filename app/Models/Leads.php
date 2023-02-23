<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Leads extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    use Notifiable;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
    protected $primarykey = 'id';
    protected $fillable = [
        'name',
        'url',
        'email',
        'phone',
        'brand_id',
        'unit_id',
        'company_id',
        'message',
        'ip_address','location'
    ];
    protected $hidden = [
        'email',
        'phone'
    ];
    public function getBrand()
    {
        return $this->hasOne(Brands::class,'id','brand_id');
    }
    public function getCreator()
    {
        return $this->hasOne(User::class,'id','created_by');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function getUnit()
    {
        return $this->hasOne(Units::class,'id','unit_id');
    }
    public function getCompany()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }
    public function notifyalert()
    {
        return $this->morphMany(Notify::class,'notifiable');
    }
}
