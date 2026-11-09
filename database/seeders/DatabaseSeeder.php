<?php
namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@demo.com'], ['name' => 'Demo Owner', 'password' => Hash::make('password')]);

        $c1 = Customer::firstOrCreate(['name' => 'Ali Traders'], ['email' => 'ali@example.com', 'phone' => '0300-1111111', 'address' => 'Saddar, Karachi']);
        $c2 = Customer::firstOrCreate(['name' => 'Sara Boutique'], ['email' => 'sara@example.com', 'phone' => '0321-2222222', 'address' => 'Gulshan, Karachi']);

        if (Invoice::count() === 0) {
            foreach ([[$c1, 5, 'paid'], [$c2, 3, 'unpaid'], [$c1, 1, 'paid'], [$c2, 0, 'unpaid']] as $i => [$c, $monthsAgo, $status]) {
                $inv = Invoice::create([
                    'customer_id' => $c->id,
                    'number' => Invoice::nextNumber(),
                    'issue_date' => now()->subMonths($monthsAgo)->toDateString(),
                    'due_date' => now()->subMonths($monthsAgo)->addDays(15)->toDateString(),
                    'status' => $status,
                ]);
                $inv->items()->createMany([
                    ['description' => 'Website maintenance', 'qty' => 1, 'unit_price' => 15000 + $i * 2500],
                    ['description' => 'Hosting (monthly)', 'qty' => 2, 'unit_price' => 1500],
                ]);
            }
        }
    }
}
