<?php

namespace Database\Seeders;

use App\Models\Plan;
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
        if(!Plan::where('name', 'Free Plan')->exists())
        {
            $this->call(PlansTableSeeder::class);
        }

        if(!User::where('email', 'superadmin@example.com')->exists())
        {
            $this->call(UsersTableSeeder::class);
        }
    }
}
