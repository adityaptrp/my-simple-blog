<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = collect(['Art', 'Vacation', 'Vintage', 'Code', 'Culture', 'Happy']); //membuat array menjadi collection
        $tags->each(function ($c) { // each hanya bisa dipakai oleh collection
            Tag::create([
                'name' => $c,
                'slug' => Str::slug($c)
            ]);
        });
    }
}
