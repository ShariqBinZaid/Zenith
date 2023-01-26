<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Opportunity extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'opportunity';
    protected $fillable = [
        'name',
        'url',
        'email',
        'phone',
        'brand_id',
        'message',
        'package_id',
        'ip_address',
        'location'
    ];
    protected $hidden = [
        'email',
        'phone'
    ];
    protected static function boot()
    {
        parent::boot();

        Opportunity::creating(function($model) {
            $model->created_by = auth()->user()->id;
        });
    }
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
}
