<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Dispositions_Leads_Opportunities extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
    protected $table = 'disposition_leads_opportunities';
    protected $fillable = ['disposition_id','user_id','object_type','object_id','feedback'];
    
    public function disposition()
    {
        return $this->morphsTo();
    }
    
    public function disposition_details()
    {
        return $this->hasOne(Dispositions::class,'id','disposition_id');
    }
    
    public function disposition_user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
