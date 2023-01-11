<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Tong dung';
        $user->email = 'vuivuivuibun@gmail.com';
        $user->password = Hash::make('10Tongdung10');
        $user->save();
    }
}
