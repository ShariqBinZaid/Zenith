<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< Updated upstream
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
=======
>>>>>>> Stashed changes

class Tax extends Model
{
    use HasFactory;
<<<<<<< Updated upstream
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
    protected $fillable = [
        'from','to','tax_percent','amount','company_id'
    ];
    public function getCompany()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }
=======
>>>>>>> Stashed changes
}
