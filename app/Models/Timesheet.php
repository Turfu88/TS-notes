<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timesheet extends Model
{
    use HasFactory;

    public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

    protected $fillable = [
        'date',
        'isWorking',
        'project',
        'ticket',
        'worktime',
        'isPodioUpdated',
        'worktimeWithCoef'
    ];
}
