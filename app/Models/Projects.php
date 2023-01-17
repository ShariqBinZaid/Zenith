<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['name','package_id','customer_id','brand_id','desc','priority','project_type','converted_by','created_from'];
    protected $hidden = ['customer_id','package_id','brand_id'];
    public function getBrand()
    {
        return $this->hasOne(Brands::class,'id','brand_id');
    }
    public function getPackage()
    {
        return $this->hasOne(Packages::class,'id','package_id');
    }
    public function getCustomer()
    {
        return $this->hasOne(User::class,'id','customer_id');
    }
    public function getConverter()
    {
        return $this->hasOne(User::class,'id','converted_by');
    }
    public function getProjectType()
    {
        return $this->hasOne(PackageTypes::class,'id','project_type');
    }
}
