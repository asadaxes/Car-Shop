<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Users;

class UsersSeeder extends Seeder
{
    public function run()
    {
        Users::create([
            'full_name' => 'Superuser',
            'email' => 'admin@gmail.com',
            'phone' => '+8801234567890',
            'whatsapp_no' => '+8801234567890',
            'password' => Hash::make('admin123'),
            'avatar' => 'users/default_avatar.png',
            'flag' => 'default_flag.svg',
            'country' => 'Turkiye',
            'city' => 'Istanbul',
            'state' => 'Istanbul',
            'zip_code' => '12345',
            'gender' => 'male',
            'birth_date' => '06 Apr 2003',
            'is_active' => true,
            'is_admin' => true,
            'joined_date' => now(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}