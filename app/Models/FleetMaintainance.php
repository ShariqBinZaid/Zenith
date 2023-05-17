<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
class FleetMaintainance extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
    protected $fillable = ['user_id','fleet_id','reason','company_id'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function fleet()
    {
        return $this->belongsTo(Fleet::class,'fleet_id','id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
}
