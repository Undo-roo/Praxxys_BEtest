<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seederCount = 1000;
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Andrew Dacumos',
            'username' => 'admin',
            'email' => 'admin@admin.com',
        ]);

        for($x = 1; $x < 5; $x++){
            Category::create([
                'title' => 'Category'.$x,
            ]);
        }

        User::factory($seederCount)->create();
        Product::factory($seederCount)->create();
    }
}
