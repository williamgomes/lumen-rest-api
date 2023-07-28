<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    protected $dates = ['deleted_at'];

    public function hotelier(): BelongsTo
    {
        return $this->belongsTo(Hotelier::class);
    }

    public function badge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }

    public function location(): HasOne
    {
        return $this->hasOne(Location::class);
    }
}
