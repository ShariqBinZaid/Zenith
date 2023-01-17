<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Brands extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primarykey = 'id';
    protected $fillable = [
        'name','url','image','type','initials'
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
}