<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         DB::table('users')->insert([
            'first_name' => 'Wesley',
            'last_name' => 'Reis',
            'email' => 'wrrdeveloper@gmail.com',
            'password' => bcrypt('Wrr230808'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
