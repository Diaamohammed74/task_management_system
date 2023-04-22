<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => Str::random(8),
            'email' => Str::random(8).'@dada.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'type' => 'Supervisor',
        ]);
    }
}