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
    use HasApiTokens,HasFactory,Notifiable,HasRoles,SoftDeletes,Metable,LogsActivity;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name','email','password','phone','unit_id','company_id','team_id','depart_id','reporting_authority','image'
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
        'password','remember_token',
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
    public function getattendancebydate($date)
    {
        return $this->hasOne(Attendance::class,'userid','id')->where('created_at','2023-03-14 14:13:14');
    }
    public function getUnit()
    {
        return $this->hasOne(Units::class,'id','unit_id');
    }
    public function getTeam()
    {
        return $this->hasOne(Teams::class,'id','team_id');
    }
    public function getFleet()
    {
        return $this->hasMany(Fleet::class);
    }
    public function getCompany()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }
    public function getReportingAuthority()
    {
        return $this->hasOne(User::class,'id','reporting_authority');
    }
    public function getDepart()
    {
        return $this->hasOne(Departments::class,'id','depart_id');
    }
    public function leavetype()
    {
        return $this->hasOne(LeaveTypes::class,'id','type');
    }
    public function getLeadsNotifications()
    {
        return $this->hasMany(Notify::class,'for','id')->where('notifiable_type',Leads::class)->latest()->take(10);
    }
    public function getOpportunityNotifications()
    {
        return $this->hasMany(Notify::class,'for','id')->where('notifiable_type',Opportunity::class)->latest()->take(10);
    }
    public function getProjectNotifications()
    {
        return $this->hasMany(Notify::class,'for','id')->where('notifiable_type',Projects::class)->latest()->take(10);
    }
    public function getAttendanceNotification()
    {
        return $this->hasMany(Notify::class,'for','id')->where('notifiable_type',Attendance::class)->latest()->take(10);
    }
    public function getLeavesNotifications()
    {
        return $this->hasMany(Notify::class,'for','id')->where('notifiable_type',Leaves::class)->latest()->take(10);
    }
    public function leavesAndDiscrepanciesNotifications()
{
    return $this->hasMany(Notify::class, 'for', 'id')
                ->whereIn('notifiable_type', [Leaves::class, Discrepancy::class])
                ->latest();
}
    public function getUserNotifications() {
        return $this->hasMany(Notify::class,'for','id')->latest()->take(5);
    }
    public function getAllCompanyannouncementsByMe()
    {
        return $this->hasMany(Announcements::class,'added_by','id')->where('announcement_type',Company::class)->latest();
    }
}
