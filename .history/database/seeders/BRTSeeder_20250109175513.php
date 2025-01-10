<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BRT;

class BRTSeeder extends Seeder
{
    public function run()
    {
        BRT::create([
            'user_id' => 1,
            'brt_code' => 'BRT12345',
            'reserved_amount' => 100.00,
            'status' => 'active',
        ]);

        BRT::create([
            'user_id' => 2,
            'brt_code' => 'BRT67890',
            'reserved_amount' => 150.50,
            'status' => 'expired',
        ]);

        BRT::create([
            'user_id' => 3,
            'brt_code' => 'BRT11223',
            'reserved_amount' => 200.00,
            'status' => 'active',
        ]);
    }
}
