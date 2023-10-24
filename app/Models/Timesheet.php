<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'is_working',
        'project',
        'ticket',
        'worktime',
        'is_podio_updated',
        'worktime_with_coef',
        'note'
    ];
}
