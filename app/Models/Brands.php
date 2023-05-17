<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Brands extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
    
    protected $primarykey = 'id';
    protected $fillable = [
        'name','url','image','type','initials','team_id','unit_id','company_id'
    ];
    
    protected static function boot()
    {
        parent::boot();

        Brands::creating(function($model) {
            $model->created_by = auth()->user()->id;
        });
    }
    
    public function leads()
    {
        return $this->hasMany(Leads::class,'brand_id','id');
    }
    
    public function opportunities()
    {
        return $this->hasMany(Opportunity::class,'brand_id','id');
    }
    
    public function packages()
    {
        return $this->hasMany(Packages::class,'brand_id','id');
    }
    
    public function teams()
    {
        return $this->belongsToMany(Teams::class);
    }
    
    public function getUnit()
    {
        return $this->belongsTo(Units::class,'unit_id','id');
    }
    
    public function getCompany()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
    
}