<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Subscription Plans
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('billing_cycle')->default('monthly'); // monthly, yearly
            $table->integer('max_outlets')->default(1);
            $table->integer('max_staff')->default(5);
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Dealers Information
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('team_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('tenant_id')->nullable();
            $table->string('company_name');
            $table->string('trade_license')->nullable();
            $table->string('contact_person');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->text('address')->nullable();
            $table->string('status')->default('active'); // active, pending, suspended
            $table->foreignId('subscription_plan_id')->nullable()->constrained('subscription_plans')->nullOnDelete();
            $table->timestamp('subscription_ends_at')->nullable();
            $table->timestamps();
        });

        // 3. Dealership Outlets / Warehouses
        Schema::create('outlets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dealer_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('incharge_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_main')->default(false);
            $table->timestamps();
        });

        // 4. Fertilizer Products & Stock
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('bangla_name')->nullable();
            $table->string('category')->default('Chemical Fertilizer'); // Chemical, Organic, Micronutrient, Pesticide
            $table->string('brand')->nullable(); // BADC, BCIC, Private
            $table->string('unit')->default('50kg Bag'); // 50kg Bag, 25kg Bag, Litre, Kg
            $table->decimal('buy_price', 10, 2)->default(0);
            $table->decimal('sell_price', 10, 2)->default(0);
            $table->decimal('stock_quantity', 12, 2)->default(0);
            $table->decimal('alert_quantity', 12, 2)->default(10);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Farmers & Retailers (Customers)
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('nid')->nullable();
            $table->string('customer_type')->default('Farmer'); // Farmer, Sub-Dealer, Retailer
            $table->string('village')->nullable();
            $table->text('address')->nullable();
            $table->decimal('total_purchased', 12, 2)->default(0);
            $table->decimal('current_due', 12, 2)->default(0);
            $table->decimal('credit_limit', 12, 2)->default(50000);
            $table->timestamps();
        });

        // 6. Purchases (Stock In from BADC / BCIC / Importers)
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('supplier_name');
            $table->string('memo_no')->nullable();
            $table->date('purchase_date');
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 12, 2);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 12, 2);
            $table->timestamps();
        });

        // 7. Sales (Invoices to Farmers / Retailers)
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name')->nullable();
            $table->string('invoice_no')->unique();
            $table->date('sale_date');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->default(0);
            $table->string('payment_method')->default('Cash'); // Cash, bKash, Nagad, Bank, Credit
            $table->string('payment_status')->default('Paid'); // Paid, Partial, Due
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 12, 2);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 12, 2);
            $table->timestamps();
        });

        // 8. Due Collections
        Schema::create('due_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('payment_method')->default('Cash');
            $table->date('collection_date');
            $table->string('receipt_no')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 9. Support Tickets
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('ticket_number')->unique();
            $table->string('subject');
            $table->string('category')->default('General');
            $table->string('priority')->default('Medium'); // Low, Medium, High, Urgent
            $table->string('status')->default('Open'); // Open, In Progress, Resolved, Closed
            $table->text('message');
            $table->text('admin_reply')->nullable();
            $table->timestamps();
        });

        // 10. Platform Announcements
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('type')->default('info'); // info, warning, urgent, success
            $table->string('target_audience')->default('all'); // all, dealers, managers
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('due_collections');
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('purchase_items');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('products');
        Schema::dropIfExists('outlets');
        Schema::dropIfExists('dealers');
        Schema::dropIfExists('subscription_plans');
    }
};
