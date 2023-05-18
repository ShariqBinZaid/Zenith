<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< Updated upstream
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
=======
>>>>>>> Stashed changes

class Payroll extends Model
{
    use HasFactory;
<<<<<<< Updated upstream
    use SoftDeletes;
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
    protected $fillable = [
        'user_id','month','year','deduction','tax','amount','deduction_days','earned_days','half_days','total_days','salary','company_id','unit_id','status'
    ];
    public function getUser()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function getCompany()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }
    public function getUnit()
    {
        return $this->hasOne(Units::class,'id','unit_id');
    }
=======
>>>>>>> Stashed changes
}
