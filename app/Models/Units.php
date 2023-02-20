<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Units extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['name','company_id','unithead','desc'];
    public function getCompany()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }
    public function getUnitHead()
    {
        return $this->hasOne(User::class,'id','unithead');
    }
    public function brands()
    {
        return $this->hasMany(Brands::class,'unit_id','id');
    }
}
