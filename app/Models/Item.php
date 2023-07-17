<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'name',
        'category',
        'image',
        'reputation',
        'badge_id',
        'price',
        'availability',
    ];

    public function hotelier(): BelongsTo
    {
        return $this->belongsTo(Hotelier::class);
    }

    public function badge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}
