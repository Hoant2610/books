<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private function createUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = 1;

        // Check if the slug already exists
        while (DB::table('books')->where('slug', $slug)->exists()) {
            $slug = Str::slug($name) . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            $name = $faker->sentence;
            $slug = $this->createUniqueSlug($name);

            DB::table('books')->insert([
                'category_id' => $faker->randomElement(["1", "2"]),
                'name' => $name, // Sử dụng tên từ Faker
                'original_price' => $faker->numberBetween(100000, 1000000),
                'sale_price' => $faker->numberBetween(100000, 1000000),
                'description' => $faker->paragraph,
                'quantity' => $faker->numberBetween(100, 200),
                'author' => 'unknown',
                'publish' => 'unknown',
                'status' => '1',
                'thumbnail' => 'image',
                'slug' => $slug,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}