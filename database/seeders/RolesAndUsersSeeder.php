<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SubscriptionPlan;
use App\Models\SupportTicket;
use App\Models\Team;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $roles = [
            'super-admin',
            'global-dealer-manager',
            'dealer',
            'tenant-admin',
            'dealer-manager',
            'salesman',
            'staff',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 2. Super Admin User
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        if (! $superAdmin->personalTeam()) {
            $hqTeam = Team::forceCreate([
                'user_id' => $superAdmin->id,
                'name' => "Super Admin's HQ",
                'personal_team' => true,
            ]);
            $superAdmin->current_team_id = $hqTeam->id;
            $superAdmin->save();
        } else {
            $hqTeam = $superAdmin->personalTeam();
        }
        $superAdmin->syncRoles(['super-admin']);

        // 3. Subscription Plans
        $starterPlan = SubscriptionPlan::updateOrCreate(
            ['slug' => 'starter-dealer'],
            [
                'name' => 'স্টার্টার ডিলার (Starter)',
                'price' => 1500.00,
                'billing_cycle' => 'monthly',
                'max_outlets' => 1,
                'max_staff' => 3,
                'features' => ['১টি শপ/আউটলেট', 'স্টক ট্র্যাকিং', 'কাস্টমার খাতা/ডিউ', 'এসএমএস চালান'],
                'is_active' => true,
            ]
        );

        $proPlan = SubscriptionPlan::updateOrCreate(
            ['slug' => 'business-pro'],
            [
                'name' => 'বিজনেস প্রো (Professional)',
                'price' => 3500.00,
                'billing_cycle' => 'monthly',
                'max_outlets' => 3,
                'max_staff' => 10,
                'features' => ['৩টি আউটলেট', 'বিসিআইসি ও বিএডিসি সার কোটা', 'এআই ডিমান্ড পূর্বাভাস', 'অটো ডিউ রিমাইন্ডার'],
                'is_active' => true,
            ]
        );

        $enterprisePlan = SubscriptionPlan::updateOrCreate(
            ['slug' => 'enterprise-corp'],
            [
                'name' => 'এন্টারপ্রাইজ কর্পোরেট (Enterprise)',
                'price' => 7500.00,
                'billing_cycle' => 'monthly',
                'max_outlets' => 10,
                'max_staff' => 50,
                'features' => ['আনলিমিটেড আউটলেট', 'হোলসেল ও ডিলার নেটওয়ার্ক', 'ডেডিকেটেড একাউন্ট ম্যানেজার', 'কাস্টম এপিআই'],
                'is_active' => true,
            ]
        );

        // 4. Tenant & Tenant Admin User
        $tenantAdmin = User::updateOrCreate(
            ['email' => 'tenantadmin@example.com'],
            [
                'name' => 'মোঃ শফিকুল ইসলাম (ডিলার)',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        $dealerTeam = $tenantAdmin->personalTeam();
        if (! $dealerTeam) {
            $dealerTeam = Team::forceCreate([
                'user_id' => $tenantAdmin->id,
                'name' => 'মেসার্স ভাই ভাই ফার্টিলাইজার্স (বগুড়া)',
                'personal_team' => true,
            ]);
            $tenantAdmin->current_team_id = $dealerTeam->id;
            $tenantAdmin->save();
        } else {
            $dealerTeam->update(['name' => 'মেসার্স ভাই ভাই ফার্টিলাইজার্স (বগুড়া)']);
        }
        $tenantAdmin->syncRoles(['dealer', 'tenant-admin']);

        // 5. Tenant table
        Tenant::updateOrCreate(
            ['id' => 'bhai-bhai-fertilizers'],
            [
                'name' => 'মেসার্স ভাই ভাই ফার্টিলাইজার্স (বগুড়া)',
                'data' => json_encode([
                    'owner' => 'মোঃ শফিকুল ইসলাম',
                    'district' => 'বগুড়া',
                    'plan' => 'business-pro',
                ]),
            ]
        );

        // 6. Dealers record
        $dealer = Dealer::updateOrCreate(
            ['user_id' => $tenantAdmin->id],
            [
                'team_id' => $dealerTeam->id,
                'tenant_id' => 'bhai-bhai-fertilizers',
                'company_name' => 'মেসার্স ভাই ভাই ফার্টিলাইজার্স',
                'trade_license' => 'TL-BGR-2024-8891',
                'contact_person' => 'মোঃ শফিকুল ইসলাম',
                'phone' => '01712-345678',
                'email' => 'tenantadmin@example.com',
                'division' => 'Rajshahi',
                'district' => 'Bogura',
                'upazila' => 'Sherpur',
                'address' => 'শেরপুর বাসস্ট্যান্ড মোড়, বগুড়া',
                'status' => 'active',
                'subscription_plan_id' => $proPlan->id,
                'subscription_ends_at' => now()->addMonths(6),
            ]
        );

        // Additional sample dealers for Platform Super Admin
        $dealersSample = [
            [
                'company_name' => 'জননী সার ভাণ্ডার',
                'contact_person' => 'হাজী মোঃ আবুল কাশেম',
                'phone' => '01819-112233',
                'email' => 'janani.dealer@example.com',
                'district' => 'Dinajpur',
                'upazila' => 'Birganj',
                'plan_id' => $starterPlan->id,
                'status' => 'active',
            ],
            [
                'company_name' => 'বরেন্দ্র এগ্রো ট্রেডার্স',
                'contact_person' => 'মাহবুবুর রহমান',
                'phone' => '01912-998877',
                'email' => 'barendra.agro@example.com',
                'district' => 'Rajshahi',
                'upazila' => 'Godagari',
                'plan_id' => $enterprisePlan->id,
                'status' => 'active',
            ],
            [
                'company_name' => 'তিস্তা সীড & ফার্টিলাইজার',
                'contact_person' => 'কামরুল হাসান',
                'phone' => '01711-445566',
                'email' => 'tista.seed@example.com',
                'district' => 'Rangpur',
                'upazila' => 'Mithapukur',
                'plan_id' => $proPlan->id,
                'status' => 'pending',
            ],
            [
                'company_name' => 'মেঘনা এগ্রো মার্ট',
                'contact_person' => 'মোর্শেদ আলম',
                'phone' => '01678-554433',
                'email' => 'meghna.agro@example.com',
                'district' => 'Cumilla',
                'upazila' => 'Chandina',
                'plan_id' => $starterPlan->id,
                'status' => 'suspended',
            ],
        ];

        foreach ($dealersSample as $s) {
            Dealer::updateOrCreate(
                ['email' => $s['email']],
                [
                    'company_name' => $s['company_name'],
                    'trade_license' => 'TL-' . rand(1000, 9999),
                    'contact_person' => $s['contact_person'],
                    'phone' => $s['phone'],
                    'district' => $s['district'],
                    'upazila' => $s['upazila'],
                    'address' => $s['upazila'] . ', ' . $s['district'],
                    'status' => $s['status'],
                    'subscription_plan_id' => $s['plan_id'],
                    'subscription_ends_at' => now()->addDays(rand(10, 180)),
                ]
            );
        }

        // 7. Outlets for Dealer
        Outlet::updateOrCreate(
            ['dealer_id' => $dealer->id, 'code' => 'OUT-01'],
            [
                'team_id' => $dealerTeam->id,
                'name' => 'শেরপুর প্রধান ডিপো ও শোরুম',
                'incharge_name' => 'সুমন আহমেদ',
                'phone' => '01712-345679',
                'address' => 'শেরপুর বাজার, বগুড়া',
                'is_main' => true,
            ]
        );
        Outlet::updateOrCreate(
            ['dealer_id' => $dealer->id, 'code' => 'OUT-02'],
            [
                'team_id' => $dealerTeam->id,
                'name' => 'ভবানীপুর সাব-আউটলেট',
                'incharge_name' => 'তারিকুল ইসলাম',
                'phone' => '01712-345680',
                'address' => 'ভবানীপুর বাজার, শেরপুর, বগুড়া',
                'is_main' => false,
            ]
        );

        // 8. Fertilizer Products for Dealer
        $products = [
            [
                'name' => 'Urea Fertilizer (BCIC)',
                'bangla_name' => 'ইউরিয়া সার (বিসিআইসি ৫০ কেজি)',
                'category' => 'Chemical Fertilizer',
                'brand' => 'BCIC',
                'unit' => '50kg Bag',
                'buy_price' => 1250.00,
                'sell_price' => 1350.00,
                'stock_quantity' => 450,
                'alert_quantity' => 50,
            ],
            [
                'name' => 'DAP (Di-ammonium Phosphate)',
                'bangla_name' => 'ডিএপি সার (৫০ কেজি)',
                'category' => 'Chemical Fertilizer',
                'brand' => 'BADC',
                'unit' => '50kg Bag',
                'buy_price' => 1050.00,
                'sell_price' => 1150.00,
                'stock_quantity' => 280,
                'alert_quantity' => 40,
            ],
            [
                'name' => 'TSP (Triple Super Phosphate)',
                'bangla_name' => 'টিএসপি সার (টিএসপি ৫০ কেজি)',
                'category' => 'Chemical Fertilizer',
                'brand' => 'TSPCL',
                'unit' => '50kg Bag',
                'buy_price' => 1200.00,
                'sell_price' => 1300.00,
                'stock_quantity' => 190,
                'alert_quantity' => 30,
            ],
            [
                'name' => 'MOP Potash (Muriate of Potash)',
                'bangla_name' => 'এমওপি পটাশ সার (৫০ কেজি)',
                'category' => 'Chemical Fertilizer',
                'brand' => 'BADC',
                'unit' => '50kg Bag',
                'buy_price' => 950.00,
                'sell_price' => 1050.00,
                'stock_quantity' => 25,
                'alert_quantity' => 30,
            ],
            [
                'name' => 'Zinc Sulphate Monohydrate 36%',
                'bangla_name' => 'জিংক সালফেট ৩৬% (১ কেজি)',
                'category' => 'Micronutrient',
                'brand' => 'ACI Godrej',
                'unit' => '1kg Pack',
                'buy_price' => 180.00,
                'sell_price' => 240.00,
                'stock_quantity' => 180,
                'alert_quantity' => 20,
            ],
            [
                'name' => 'Organic Bio-Fertilizer (Vermicompost)',
                'bangla_name' => 'কেঁচো কম্পোস্ট জৈব সার (৪০ কেজি)',
                'category' => 'Organic Fertilizer',
                'brand' => 'Green Earth',
                'unit' => '40kg Bag',
                'buy_price' => 400.00,
                'sell_price' => 550.00,
                'stock_quantity' => 85,
                'alert_quantity' => 25,
            ],
            [
                'name' => 'Gypsum (Calcium Sulphate)',
                'bangla_name' => 'জিপসাম সার (৫০ কেজি)',
                'category' => 'Chemical Fertilizer',
                'brand' => 'BADC',
                'unit' => '50kg Bag',
                'buy_price' => 450.00,
                'sell_price' => 550.00,
                'stock_quantity' => 15,
                'alert_quantity' => 20,
            ],
        ];

        $createdProducts = [];
        foreach ($products as $p) {
            $createdProducts[] = Product::updateOrCreate(
                ['team_id' => $dealerTeam->id, 'name' => $p['name']],
                array_merge($p, ['team_id' => $dealerTeam->id])
            );
        }

        // 9. Customers (Farmers & Retailers)
        $customers = [
            [
                'name' => 'মোঃ রফিকুল ইসলাম (কৃষক)',
                'phone' => '01723-998811',
                'nid' => '19851012345678',
                'customer_type' => 'Farmer',
                'village' => 'মির্জাপুর, শেরপুর',
                'total_purchased' => 48500.00,
                'current_due' => 6500.00,
                'credit_limit' => 30000.00,
            ],
            [
                'name' => 'আলহাজ্ব মোজাম্মেল হক',
                'phone' => '01812-445566',
                'nid' => '19761019876543',
                'customer_type' => 'Farmer',
                'village' => 'খান্দার, শেরপুর',
                'total_purchased' => 112000.00,
                'current_due' => 0.00,
                'credit_limit' => 50000.00,
            ],
            [
                'name' => 'মোতালেব ট্রেডার্স (সাব-ডিলার)',
                'phone' => '01911-332211',
                'nid' => '19881023456789',
                'customer_type' => 'Sub-Dealer',
                'village' => 'ভবানীপুর বাজার',
                'total_purchased' => 345000.00,
                'current_due' => 42000.00,
                'credit_limit' => 100000.00,
            ],
            [
                'name' => 'আনোয়ার হোসেন (কৃষক)',
                'phone' => '01671-887766',
                'nid' => '19921034567890',
                'customer_type' => 'Farmer',
                'village' => 'বাগড়া, শেরপুর',
                'total_purchased' => 28000.00,
                'current_due' => 3200.00,
                'credit_limit' => 20000.00,
            ],
        ];

        $createdCustomers = [];
        foreach ($customers as $c) {
            $createdCustomers[] = Customer::updateOrCreate(
                ['team_id' => $dealerTeam->id, 'phone' => $c['phone']],
                array_merge($c, ['team_id' => $dealerTeam->id])
            );
        }

        // 10. Sample Recent Sales & Invoices
        $invoices = [
            [
                'invoice_no' => 'INV-2026-001',
                'customer_id' => $createdCustomers[0]->id,
                'customer_name' => $createdCustomers[0]->name,
                'sale_date' => now()->subDays(2),
                'subtotal' => 13500.00,
                'discount' => 200.00,
                'total_amount' => 13300.00,
                'paid_amount' => 10000.00,
                'due_amount' => 3300.00,
                'payment_method' => 'Cash',
                'payment_status' => 'Partial',
            ],
            [
                'invoice_no' => 'INV-2026-002',
                'customer_id' => $createdCustomers[1]->id,
                'customer_name' => $createdCustomers[1]->name,
                'sale_date' => now()->subDay(),
                'subtotal' => 23000.00,
                'discount' => 500.00,
                'total_amount' => 22500.00,
                'paid_amount' => 22500.00,
                'due_amount' => 0.00,
                'payment_method' => 'bKash',
                'payment_status' => 'Paid',
            ],
            [
                'invoice_no' => 'INV-2026-003',
                'customer_id' => $createdCustomers[2]->id,
                'customer_name' => $createdCustomers[2]->name,
                'sale_date' => now(),
                'subtotal' => 45000.00,
                'discount' => 1000.00,
                'total_amount' => 44000.00,
                'paid_amount' => 20000.00,
                'due_amount' => 24000.00,
                'payment_method' => 'Bank',
                'payment_status' => 'Partial',
            ],
        ];

        foreach ($invoices as $inv) {
            $sale = Sale::updateOrCreate(
                ['invoice_no' => $inv['invoice_no']],
                array_merge($inv, ['team_id' => $dealerTeam->id])
            );

            SaleItem::firstOrCreate([
                'sale_id' => $sale->id,
                'product_id' => $createdProducts[0]->id,
            ], [
                'quantity' => 10,
                'unit_price' => 1350.00,
                'total_price' => 13500.00,
            ]);
        }

        // 11. Support Tickets
        SupportTicket::updateOrCreate(
            ['ticket_number' => 'TCK-9081'],
            [
                'user_id' => $tenantAdmin->id,
                'team_id' => $dealerTeam->id,
                'subject' => 'বিসিআইসি সরকারি ইউরিয়া কোটা রিপোর্টে সমস্যা',
                'category' => 'Billing & Reports',
                'priority' => 'High',
                'status' => 'In Progress',
                'message' => 'আমাদের বর্তমান মাসের সরকারি ইউরিয়া সার বরাদ্দের সাথে ইনভয়েস স্টক মিলছে না। অনুগ্রহ করে চেক করে দিন।',
                'admin_reply' => 'আমরা আপনার কোটা রিপোর্ট ভেরিফাই করছি। কিছুক্ষণের মধ্যে আপডেট দেওয়া হবে।',
            ]
        );
        SupportTicket::updateOrCreate(
            ['ticket_number' => 'TCK-9082'],
            [
                'user_id' => $tenantAdmin->id,
                'team_id' => $dealerTeam->id,
                'subject' => 'এসএমএস চালান ডেলিভারি ব্যর্থ হচ্ছে',
                'category' => 'SMS Gateway',
                'priority' => 'Medium',
                'status' => 'Open',
                'message' => 'কাস্টমারদের কাছে ইনভয়েস তৈরির পর স্বয়ংক্রিয় এসএমএস যাচ্ছে না।',
            ]
        );

        // 12. Announcements
        Announcement::updateOrCreate(
            ['title' => '২০২৬-২৭ রবি মৌসুমের সরকারি সার বরাদ্দের নীতিমালা জারি'],
            [
                'content' => 'কৃষি মন্ত্রণালয় কর্তৃক সকল অনুমোদিত সার ডিলারদের জন্য রবি মৌসুমে ইউরিয়া ও ডিএপি সার বিক্রির নির্দেশনা প্রকাশ করা হয়েছে। সকল ডিলারকে প্রতিদিনের স্টক হালনাগাদ রাখার অনুরোধ করা হচ্ছে।',
                'type' => 'urgent',
                'target_audience' => 'dealers',
                'is_active' => true,
                'published_at' => now(),
            ]
        );
        Announcement::updateOrCreate(
            ['title' => 'প্ল্যাটফর্ম সিস্টেম মেইনটেন্যান্স নোটিশ'],
            [
                'content' => 'আগামী শুক্রবার রাত ১২:০০ টা থেকে ভোর ৪:০০ টা পর্যন্ত সার্ভার ব্যাকআপ ও আপগ্রেডের জন্য সিস্টেম সাময়িক বন্ধ থাকবে।',
                'type' => 'info',
                'target_audience' => 'all',
                'is_active' => true,
                'published_at' => now()->subDay(),
            ]
        );

        // 13. Activity Logs for Spatie Activitylog
        if (class_exists(Activity::class)) {
            Activity::firstOrCreate(
                ['description' => 'Super Admin logged into Platform Portal'],
                [
                    'log_name' => 'auth',
                    'causer_id' => $superAdmin->id,
                    'causer_type' => User::class,
                    'created_at' => now()->subMinutes(15),
                ]
            );
            Activity::firstOrCreate(
                ['description' => 'Dealer মেসার্স ভাই ভাই ফার্টিলাইজার্স updated stock quota'],
                [
                    'log_name' => 'stock',
                    'causer_id' => $tenantAdmin->id,
                    'causer_type' => User::class,
                    'created_at' => now()->subHours(1),
                ]
            );
            Activity::firstOrCreate(
                ['description' => 'New Subscription Plan Business Pro activated'],
                [
                    'log_name' => 'subscription',
                    'causer_id' => $superAdmin->id,
                    'causer_type' => User::class,
                    'created_at' => now()->subDays(1),
                ]
            );
        }
    }
}
