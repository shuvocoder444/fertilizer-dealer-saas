<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DueCollection extends Model
{
    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'collection_date' => 'date',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
