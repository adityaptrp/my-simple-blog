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
            'email' => 'adtyaputra1999@gmail.com'
        ]);
    }
}
