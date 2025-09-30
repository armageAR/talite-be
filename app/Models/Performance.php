<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Performance extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Allow mass assignment for these attributes.
     */
    protected $fillable = [
        'play_id',
        'uid',
        'scheduled_at',
        'location',
        'comment',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    protected $appends = [
        'status',
    ];

    protected static function booted(): void
    {
        static::creating(function (Performance $performance) {
            if (empty($performance->uid)) {
                $performance->uid = Str::upper(Str::random(12));
            }
        });
    }

    public function play(): BelongsTo
    {
        return $this->belongsTo(Play::class);
    }

    public function getStatusAttribute(): ?string
    {
        $scheduledAt = $this->scheduled_at instanceof CarbonInterface ? $this->scheduled_at : null;
        $startedAt = $this->started_at instanceof CarbonInterface ? $this->started_at : null;
        $endedAt = $this->ended_at instanceof CarbonInterface ? $this->ended_at : null;

        if ($scheduledAt === null) {
            return null;
        }

        if ($scheduledAt->isFuture() && $startedAt === null && $endedAt === null) {
            return 'futuro';
        }

        if ($scheduledAt->isPast() && $startedAt !== null && $endedAt !== null && $startedAt->equalTo($endedAt)) {
            return 'suspendida';
        }

        if ($scheduledAt->isPast() && $startedAt !== null && $endedAt === null) {
            return 'representandose';
        }

        if ($scheduledAt->isPast() && $startedAt !== null && $endedAt !== null) {
            return 'representada';
        }

        return null;
    }
}
