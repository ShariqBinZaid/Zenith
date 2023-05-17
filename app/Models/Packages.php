<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Packages extends Model
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
        'name','price','cut_price','description','currency','brand_id','package_type','created_at','updated_at'
    ];
    protected $hidden = ['price'];
    protected static function boot()
    {
        parent::boot();

        Packages::creating(function($model) {
            $model->created_by = auth()->user()->id;
        });
    }
    public function getBrand()
    {
        return $this->hasOne(Brands::class,'id','brand_id');
    }
    public function getPackageType()
    {
        return $this->hasOne(PackageTypes::class,'id','package_type');
    }
    public function getCurrency()
    {
        return $this->hasOne(Currency::class,'id','currency');
    }
}
