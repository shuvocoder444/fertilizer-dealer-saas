<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\StaffMember;
use App\Models\StaffSalary;
use App\Models\Team;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $team = Team::find(3) ?? Team::first();
        if (!$team) {
            return;
        }

        $outlet1 = Outlet::where('team_id', $team->id)->first();
        $outlet2 = Outlet::where('team_id', $team->id)->skip(1)->first();

        $s1 = StaffMember::firstOrCreate(
            ['team_id' => $team->id, 'phone' => '01712-345678'],
            [
                'outlet_id' => $outlet1?->id,
                'name' => 'মো: শফিকুল ইসলাম',
                'email' => 'shafiq.manager@vaivai.com',
                'designation' => 'প্রধান গোডাউন ও সেলস ম্যানেজার',
                'role_type' => 'manager',
                'nid' => '19881012345678901',
                'present_address' => 'শেরপুর বাসস্ট্যান্ড মোড়, শেরপুর, বগুড়া',
                'permanent_address' => 'গ্রাম: গাড়ীদহ, শেরপুর, বগুড়া',
                'joining_date' => '2025-01-01',
                'monthly_salary' => 18000,
                'status' => 'active',
                'emergency_contact' => '01711-223344 (স্ত্রী)',
                'has_login_access' => true,
            ]
        );

        $s2 = StaffMember::firstOrCreate(
            ['team_id' => $team->id, 'phone' => '01819-876543'],
            [
                'outlet_id' => $outlet1?->id,
                'name' => 'মো: রফিকুল আলম',
                'email' => 'rafiq.sales@vaivai.com',
                'designation' => 'সিনিয়র বিক্রয় প্রতিনিধি ও ক্যাশিয়ার',
                'role_type' => 'salesman',
                'nid' => '19922098765432100',
                'present_address' => 'উপজেলা রোড, শেরপুর, বগুড়া',
                'permanent_address' => 'গ্রাম: খামারকান্দি, শেরপুর, বগুড়া',
                'joining_date' => '2025-06-15',
                'monthly_salary' => 14000,
                'status' => 'active',
                'emergency_contact' => '01815-998877 (ভাই)',
                'has_login_access' => true,
            ]
        );

        $s3 = StaffMember::firstOrCreate(
            ['team_id' => $team->id, 'phone' => '01912-112233'],
            [
                'outlet_id' => $outlet2?->id,
                'name' => 'মো: তারেক হাসান',
                'designation' => 'ভবানীপুর গোডাউন ইনচার্জ',
                'role_type' => 'incharge',
                'nid' => '19955055443322110',
                'present_address' => 'ভবানীপুর বাজার, শেরপুর, বগুড়া',
                'permanent_address' => 'গ্রাম: ভবানীপুর, শেরপুর, বগুড়া',
                'joining_date' => '2026-02-01',
                'monthly_salary' => 12000,
                'status' => 'active',
                'emergency_contact' => '01911-334455 (বাবা)',
                'has_login_access' => false,
            ]
        );

        $s4 = StaffMember::firstOrCreate(
            ['team_id' => $team->id, 'phone' => '01733-445566'],
            [
                'name' => 'মো: করিম মিয়া',
                'designation' => 'ডেলিভারি ড্রাইভার ও লোড-আনলোড কর্মী',
                'role_type' => 'delivery',
                'nid' => '19853011223344556',
                'present_address' => 'বাসস্ট্যান্ড এলাকা, শেরপুর, বগুড়া',
                'permanent_address' => 'গ্রাম: মির্জাপুর, শেরপুর, বগুড়া',
                'joining_date' => '2025-08-01',
                'monthly_salary' => 10000,
                'status' => 'active',
                'emergency_contact' => '01722-110099 (ভাই)',
                'has_login_access' => false,
            ]
        );

        if (StaffSalary::where('staff_member_id', $s1->id)->count() == 0) {
            StaffSalary::create(['team_id' => $team->id, 'staff_member_id' => $s1->id, 'month_year' => 'আগস্ট ২০২৬', 'payment_date' => '2026-09-02', 'amount' => 18000, 'payment_type' => 'salary', 'payment_method' => 'bank', 'note' => 'আগস্ট মাসের নিয়মিত বেতন (ব্যাংক ট্রান্সফার)']);
            StaffSalary::create(['team_id' => $team->id, 'staff_member_id' => $s1->id, 'month_year' => 'সেপ্টেম্বর ২০২৬', 'payment_date' => '2026-10-03', 'amount' => 18000, 'payment_type' => 'salary', 'payment_method' => 'bank', 'note' => 'সেপ্টেম্বর মাসের নিয়মিত বেতন']);
            StaffSalary::create(['team_id' => $team->id, 'staff_member_id' => $s1->id, 'month_year' => 'অক্টোবর ২০২৬', 'payment_date' => '2026-11-02', 'amount' => 18000, 'payment_type' => 'salary', 'payment_method' => 'bank', 'note' => 'অক্টোবর মাসের নিয়মিত বেতন']);
            StaffSalary::create(['team_id' => $team->id, 'staff_member_id' => $s1->id, 'month_year' => 'নভেম্বর ২০২৬', 'payment_date' => '2026-11-10', 'amount' => 18000, 'payment_type' => 'salary', 'payment_method' => 'bank', 'note' => 'নভেম্বর মাসের বেতন পরিশোধ']);
        }

        if (StaffSalary::where('staff_member_id', $s2->id)->count() == 0) {
            StaffSalary::create(['team_id' => $team->id, 'staff_member_id' => $s2->id, 'month_year' => 'সেপ্টেম্বর ২০২৬', 'payment_date' => '2026-10-02', 'amount' => 14000, 'payment_type' => 'salary', 'payment_method' => 'cash', 'note' => 'সেপ্টেম্বর মাসের নগদ বেতন']);
            StaffSalary::create(['team_id' => $team->id, 'staff_member_id' => $s2->id, 'month_year' => 'অক্টোবর ২০২৬', 'payment_date' => '2026-11-01', 'amount' => 14000, 'payment_type' => 'salary', 'payment_method' => 'bkash', 'note' => 'অক্টোবর মাসের বেতন (বিকাশ)']);
            StaffSalary::create(['team_id' => $team->id, 'staff_member_id' => $s2->id, 'month_year' => 'নভেম্বর ২০২৬', 'payment_date' => '2026-11-05', 'amount' => 5000, 'payment_type' => 'advance', 'payment_method' => 'cash', 'note' => 'জরুরি পারিবারিক প্রয়োজনে অগ্রিম গ্রহণ']);
        }

        if (StaffSalary::where('staff_member_id', $s3->id)->count() == 0) {
            StaffSalary::create(['team_id' => $team->id, 'staff_member_id' => $s3->id, 'month_year' => 'অক্টোবর ২০২৬', 'payment_date' => '2026-11-03', 'amount' => 12000, 'payment_type' => 'salary', 'payment_method' => 'cash', 'note' => 'অক্টোবর মাসের বেতন']);
        }

        if (StaffSalary::where('staff_member_id', $s4->id)->count() == 0) {
            StaffSalary::create(['team_id' => $team->id, 'staff_member_id' => $s4->id, 'month_year' => 'অক্টোবর ২০২৬', 'payment_date' => '2026-11-02', 'amount' => 10000, 'payment_type' => 'salary', 'payment_method' => 'cash', 'note' => 'অক্টোবর মাসের নিয়মিত মজুরি']);
        }
    }
}
