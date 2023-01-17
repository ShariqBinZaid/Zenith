<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class Leads extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primarykey = 'id';
    protected $fillable = [
        'username',
        'url',
        'email',
        'phone',
        'brand_id',
        'message',
        'ip_address','location'
    ];
    protected $hidden = [
        'email',
        'phone'
    ];
    protected static function boot()
    {
        parent::boot();

        Leads::creating(function($model) {
            $model->created_by = auth()->user()->id;
        });
    }
    public function getBrand()
    {
        return $this->hasOne(Brands::class,'id','brand_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
