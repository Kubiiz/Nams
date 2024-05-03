<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permission;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name'          => 'User',
            'surname'       => 'Surname',
            'email'         => 'nams@etr.lv',
        ]);

        Permission::create([
            'type'          => 'user',
            'id'            => $user->id,
            'permission'    => 'admin',
        ]);
    }
}
