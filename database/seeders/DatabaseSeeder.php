<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Apartment;
use App\Models\User;
use App\Models\Company;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'          => 'Nams',
            'surname'       => 'Surname',
            'email'         => 'nams@etr.lv',
            'access'        => true,
        ]);

        User::factory()->create([
            'name' => 'Game',
            'surname' => 'Surname',
            'email' => 'game@etr.lv',
        ]);

        User::factory()->create([
            'name' => 'Davis953',
            'surname' => 'Surname',
            'email' => 'davis953@inbox.lv',
        ]);

        // $user = User::factory()->create([
        //     'name' => 'User',
        //     'surname' => 'Surname',
        //     'email' => 'nams@etr.lv',
        //     'access' => true,
        // ]);

        // $company = Company::create([
        //     'name' => 'Test',
        //     'owner' => $user->email,
        // ]);

        // $address = Address::create([
        //     'company_id' => $company->id,
        //     'address' => 'testaddress',
        // ]);

        // $address = Apartment::create([
        //     'address_id' => $address->id,
        //     'apartment' => 1,
        // ]);
    }
}
