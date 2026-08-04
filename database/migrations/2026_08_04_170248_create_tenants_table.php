<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->string('id')->primary(); // Tenant identification name or code (e.g. 'company_a')
            $table->string('name');
            $table->timestamps();
            $table->json('data')->nullable(); // Extra settings if needed
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
