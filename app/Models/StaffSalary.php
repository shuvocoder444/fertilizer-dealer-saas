<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'staff_member_id',
        'month_year',
        'payment_date',
        'amount',
        'payment_type',
        'payment_method',
        'note',
        'recorded_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function staffMember()
    {
        return $this->belongsTo(StaffMember::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
