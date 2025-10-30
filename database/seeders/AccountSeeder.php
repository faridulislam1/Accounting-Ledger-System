<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['name' => 'Cash', 'balance' => 10000.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bank', 'balance' => 50000.00, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($accounts as $account) {
            Account::firstOrCreate(
                ['name' => $account['name']],
                $account
            );
        }
    }
}