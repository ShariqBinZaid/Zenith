<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Metable\Metable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles,SoftDeletes,Metable,LogsActivity;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password','phone','unit_id','company_id'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $guard_name = 'api';
    public function leads()
    {
        return $this->belongsToMany(Leads::class);
    }
    public function opportunity()
    {
        return $this->belongsToMany(Opportunity::class);
    }
    public function teams()
    {
        return $this->belongsToMany(Teams::class);
    }
    public function latestattendance()
    {
        return $this->hasOne(Attendance::class,'userid','id')->latest();
    }
    public function getUnit()
    {
        return $this->hasOne(Units::class,'id','unit_id');
    }
    public function getTeam()
    {
        return $this->hasOne(Teams::class,'id','team_id');
    }
    public function getCompany()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }
    public function getNotifications()
    {
        return $this->hasMany(Notify::class,'for','id')->latest()->take(10);
    }
}
