<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\TodoTask;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,

        ]);

        // $this->call([
        //     User::factory(9)->create(),
        //     Todo::factory(100)->create(),
        //     TodoTask::factory(1000)->create(),
        // ]);
    }
}
