<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
class UserMeta extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['userid','metakey','metavalue'];
    protected $table = 'usermeta';
    public function user()
    {
        return $this->belongsTo(User::class,'id','userid');
    }
}
