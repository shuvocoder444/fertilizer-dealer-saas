<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    protected $casts = [
        'total_purchased' => 'decimal:2',
        'current_due' => 'decimal:2',
        'credit_limit' => 'decimal:2',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function dueCollections()
    {
        return $this->hasMany(DueCollection::class);
    }
}
