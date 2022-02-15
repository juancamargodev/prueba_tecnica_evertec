<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@test.com',
            'mobile' => 3124214360,
            'password' => Hash::make('t3st')
        ]);
    }
}
