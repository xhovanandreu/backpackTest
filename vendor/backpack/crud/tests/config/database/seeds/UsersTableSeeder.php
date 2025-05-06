<?php

namespace Backpack\CRUD\Tests\Config\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $now = \Carbon\Carbon::now();

        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('secret'),
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('secret'),
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('user_role')->insert([
            [
                'user_id' => 1,
                'role_id' => 1,
            ],
            [
                'user_id' => 2,
                'role_id' => 1,
            ],
            [
                'user_id' => 2,
                'role_id' => 2,
            ],
        ]);

        DB::table('account_details')->insert([
            'user_id' => 1,
            'nickname' => $faker->firstName(),
            'profile_picture' => $faker->imageUrl(),
        ]);

        DB::table('addresses')->insert([
            'account_details_id' => 1,
            'city' => $faker->city,
            'street' => $faker->streetName,
            'number' => $faker->randomDigitNotNull,
        ]);
    }
}
