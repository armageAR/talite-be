<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Play extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Always eager load question count for responses.
     */
    protected $withCount = ['questions'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * A play contains many questions.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }
}
