<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           $admin = User::create([
                'name'           => "Admin",
                'email'          => "admin@example.com",
                'password'       => bcrypt('password'),
            
            ]);

            $admin->roles()->sync(1);
           

            $sales = User::create([
                'name'           => "Salesperson",
                'email'          => "salesperson@example.com",
                'password'       => bcrypt('password'),
            
            ]);
            $sales->roles()->sync(2);
            
    }
}
