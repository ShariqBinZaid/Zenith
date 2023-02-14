<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class Teams extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['name','leader','unit_id'];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function brands()
    {
        return $this->belongsToMany(Brands::class);
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
        return $this->hasOne(Units::class,'id','unit_id');
    }
}
