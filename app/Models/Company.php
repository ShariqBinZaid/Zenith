<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Company extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function CompanyOwner()
    {
        return $this->hasOne(User::class,'id','owner');
    }
}
