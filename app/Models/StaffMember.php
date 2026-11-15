<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'outlet_id',
        'name',
        'phone',
        'email',
        'designation',
        'role_type',
        'nid',
        'present_address',
        'permanent_address',
        'joining_date',
        'monthly_salary',
        'status',
        'emergency_contact',
        'has_login_access',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'monthly_salary' => 'decimal:2',
        'has_login_access' => 'boolean',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function salaries()
    {
        return $this->hasMany(StaffSalary::class)->latest('payment_date');
    }

    public function totalPaid(): float
    {
        return (float) $this->salaries()->sum('amount');
    }

    public function totalThisYear(): float
    {
        return (float) $this->salaries()
            ->whereYear('payment_date', now()->year)
            ->sum('amount');
    }

    public function totalThisMonth(): float
    {
        return (float) $this->salaries()
            ->whereYear('payment_date', now()->year)
            ->whereMonth('payment_date', now()->month)
            ->sum('amount');
    }
}
