<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // for($i = 0 ; $i < 10; $i++){
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => "thuhuongnguyenthi20vp@gmail.com",
                'password' => Hash::make(123123),
                'phone' => $faker->phoneNumber,
                // 'role' => $faker->randomElement(['admin','customer']),
                'role' => 'customer',
                'status'=>'1',
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        // }
    }
}
