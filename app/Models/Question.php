<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Attributes that can be mass assigned.
     */
    protected $fillable = [
        'play_id',
        'question',
        'order',
        'observations',
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Each question belongs to a play.
     */
    public function play(): BelongsTo
    {
        return $this->belongsTo(Play::class);
    }
}
