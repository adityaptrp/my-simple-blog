<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Aditya Putra',
            'username' => 'adityaptrp',
            'password' => bcrypt('12345'),
            'email' => 'adtyaputra1999@gmail.com',
            'bio' => 'Student at ITB STIKOM BALI, art enthusiast, newbie programmer',
            'instagram' => 'adityaptrp',
            'twitter' => 'adityaptrp_',
            'facebook' => 'adityaptrp.me',
            'website' => 'https://www.youtube.com/watch?v=zOUtK--JPhc',
            'youtube_link' => 'UC62n-2EB6U7cPm4yrjBBsPA',
            'is_admin' => true,
        ]);
    }
}
