<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BRT;

class BRTSeeder extends Seeder
{
    public function run()
    {
        BRT::create([
            'user_id' => 4,
            'brt_code' => 'BRT12345',
            'reserved_amount' => 100.00,
            'status' => 'active',
        ]);

        BRT::create([
            'user_id' => 5,
            'brt_code' => 'BRT67891',
            'reserved_amount' => 150.50,
            'status' => 'expired',
        ]);

        BRT::create([
            'user_id' => 3,
            'brt_code' => 'BRT11224',
            'reserved_amount' => 300.00,
            'status' => 'pending',
        ]);
    }
}
