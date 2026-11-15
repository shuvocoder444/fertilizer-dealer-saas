<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('outlet_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('designation')->default('কর্মী / Staff');
            $table->string('role_type')->default('staff'); // manager, staff, cashier, incharge, delivery
            $table->string('nid')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->date('joining_date')->nullable();
            $table->decimal('monthly_salary', 12, 2)->default(0);
            $table->string('status')->default('active'); // active, inactive, terminated
            $table->string('emergency_contact')->nullable();
            $table->boolean('has_login_access')->default(false);
            $table->timestamps();
        });

        Schema::create('staff_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('staff_member_id')->constrained()->cascadeOnDelete();
            $table->string('month_year'); // e.g., '2026-11' or 'নভেম্বর ২০২৬'
            $table->date('payment_date');
            $table->decimal('amount', 12, 2);
            $table->string('payment_type')->default('salary'); // salary, advance, bonus, allowance
            $table->string('payment_method')->default('cash'); // cash, bkash, nagad, bank
            $table->text('note')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_salaries');
        Schema::dropIfExists('staff_members');
    }
};
