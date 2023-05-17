<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Auth;

class Teams extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
    protected $fillable = ['name','leader','unit_id','company_id'];
    public function users()
    {
        return $this->hasMany(User::class,'team_id','id');
    }
    public function brands()
    {
        return $this->hasMany(Brands::class,'team_id','id');
    }
    public function getLeader()
    {
        return $this->hasOne(User::class,'id','leader');
    }
    public function scopeisLeader($query,$id)
    {
        return $query->where('leader',$id);
    }
    public function getUnit()
    {
        return $this->hasOne(Units::class);
    }
    public function getCompany()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }
}
