<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'user01',
            'email' => 'user01@foo.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'username' => 'user02',
            'email' => 'user02@foo.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'username' => 'user03',
            'email' => 'user03@foo.com',
            'password' => Hash::make('password'),
        ]);
    }
}
