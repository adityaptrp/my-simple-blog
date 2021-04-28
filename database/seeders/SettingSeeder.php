<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'email' => 'sp.adityaptrp@gmail.com',
            'email_name' => 'Aditya Putra',
            'auth_caption' => 'Ciucaș Peak, Romania',
            'auth_owner_name' => 'David Marcu',
            'auth_unsplash_username' => 'davidmarcu'
        ]);
    }
}
