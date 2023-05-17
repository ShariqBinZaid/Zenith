<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkFromHome extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id','user_id','company_id','date','desc','status'
    ];
    
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function leavetype()
    {
        return $this->hasOne(LeaveTypes::class,'id','type');
    }
    public function notifyalert()
    {
        return $this->morphMany(Notify::class,'notifiable');
    }
}
