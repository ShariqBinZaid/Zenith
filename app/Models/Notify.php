<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use HasFactory;
    
    protected $fillable = ['for','message','data','notifiable_id','notifiable_type','url'];
    
    public function notifiable()
    {
        return $this->morphTo();
    }
}
