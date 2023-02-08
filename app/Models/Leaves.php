<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leaves extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'date',
        'year',
        'userid',
        'type',
        'reason',
        'status',
        'half_day',
        
    ];
    public function leavetype()
    {
        return $this->hasOne(LeaveTypes::class,'id','type');
    }
}
