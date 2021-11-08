<?php

namespace Database\Seeders;

use Faker\Provider\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            [
                'uuid' => Uuid::uuid(),
                'first_name' => Str::random(5),
                'last_name' => Str::random(5),
                'email' => 'habib@gmail.com',
                'password' => Hash::make('1234567'),
            ],
            [
                'uuid' => Uuid::uuid(),
                'first_name' => Str::random(5),
                'last_name' => Str::random(5),
                'email' => 'abc@gmail.com',
                'password' => Hash::make('1234567'),
            ],
            [
                'uuid' => Uuid::uuid(),
                'first_name' => Str::random(5),
                'last_name' => Str::random(5),
                'email' => 'fgh@gmail.com',
                'password' => Hash::make('1234567'),
            ]
        ]);
    }
}
