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
        'name',
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
    public function getBrand()
    {
        return $this->hasOne(Brands::class,'id','brand_id');
    }
    public function getCreator()
    {
        return $this->hasOne(User::class,'id','created_by');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
