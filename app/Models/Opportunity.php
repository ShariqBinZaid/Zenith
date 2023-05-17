<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Opportunity extends Model
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
    
    protected $table = 'opportunity';
    protected $fillable = [
        'name',
        'url',
        'email',
        'phone',
        'brand_id',
        'message',
        'package_id',
        'unit_id',
        'company_id',
        'ip_address',
        'location'
    ];
    protected $hidden = [
        'email',
        'phone'
    ];
    public function getBrand()
    {
        return $this->hasOne(Brands::class,'id','brand_id');
    }
    public function getPackage()
    {
        return $this->hasOne(Packages::class,'id','package_id');
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
    public function disposition()
    {
        return $this->morphMany(Dispositions_Leads_Opportunities::class,'object')->latest();
    }
    public function my_disposition()
    {
        return $this->morphMany(Dispositions_Leads_Opportunities::class, 'object')->where('user_id', auth()->id());
    }
    public function my_latest_disposition()
    {
        return $this->morphMany(Dispositions_Leads_Opportunities::class, 'object')->where('user_id', auth()->id())->latest()->take(1);
    }
}
