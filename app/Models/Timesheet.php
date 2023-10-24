<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
