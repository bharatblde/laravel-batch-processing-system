<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchTestSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        for ($i = 0; $i < 1000; $i++) {

            $data[] = [
                'name' => 'User_' . rand(1000, 9999),
                'status' => rand(1, 10) <= 7 ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('test_records')->insert($data);
    }
}