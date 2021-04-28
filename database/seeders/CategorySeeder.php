<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect(['Travels', 'Lifestyle', 'Informative', 'Moments']); //membuat array menjadi collection
        $categories->each(function ($c) { // each hanya bisa dipakai oleh collection
            Category::create([
                'name' => $c,
                'slug' => Str::slug($c)
            ]);
        });
    }
}
