<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $guarded = [];

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
