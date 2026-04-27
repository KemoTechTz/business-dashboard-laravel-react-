<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\ServiceCatalog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $business = Business::create([
            'name' => 'Kemo Cuts Mikocheni',
            'slug' => 'kemo-cuts-mikocheni',
            'location' => 'Mikocheni, Dar es Salaam',
            'email' => 'ops@kemocuts.co.tz',
            'phone' => '+255754000111',
        ]);

        $admin = User::create([
            'business_id' => $business->id,
            'name' => 'Asha Mwakalinga',
            'email' => 'admin@kemocuts.co.tz',
            'password' => Hash::make('Password123!'),
            'role' => 'admin',
        ]);

        $staff = User::create([
            'business_id' => $business->id,
            'name' => 'Neema Julius',
            'email' => 'staff@kemocuts.co.tz',
            'password' => Hash::make('Password123!'),
            'role' => 'staff',
        ]);

        $service = ServiceCatalog::create([
            'business_id' => $business->id,
            'name' => 'Executive Fade + Beard Sculpt',
            'category' => 'Barbering',
            'description' => 'Premium barbershop service package.',
            'price_tzs' => 25000,
            'duration_minutes' => 60,
            'is_active' => true,
        ]);

        $customer = Customer::create([
            'business_id' => $business->id,
            'name' => 'Baraka Chacha',
            'email' => 'baraka.chacha@gmail.com',
            'phone' => '+255713555444',
            'address' => 'Sinza, Dar es Salaam',
            'notes' => 'Prefers evening slots after work hours.',
        ]);

        $booking = Booking::create([
            'business_id' => $business->id,
            'customer_id' => $customer->id,
            'service_id' => $service->id,
            'staff_id' => $staff->id,
            'scheduled_for' => Carbon::now()->addDay()->setTime(18, 0),
            'status' => 'pending',
        ]);

        Payment::create([
            'business_id' => $business->id,
            'booking_id' => $booking->id,
            'amount_tzs' => 25000,
            'method' => 'mpesa',
            'status' => 'unpaid',
            'transaction_reference' => null,
            'metadata' => ['provider' => 'M-Pesa', 'phone' => '+255713555444'],
        ]);

        $admin->createToken('seed-token');
    }
}
