<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    protected $connection = 'admin_panel';
    public function run(): void
    {
        // User::factory(10)->create();

        AdminUser::create([
            'name' => 'Jito Jeap Admin',
            'email' => 'jitojeapadmin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin@jitojeap'),

        ]);
    }
}
