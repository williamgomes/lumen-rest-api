<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'account_id',
        'title',
        'post',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
