<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'hotelier_id',
        'item_id',
        'start_date',
        'end_date',
        'accommodation',
    ];
    public function hotelier(): BelongsTo
    {
        return $this->belongsTo(Hotelier::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
