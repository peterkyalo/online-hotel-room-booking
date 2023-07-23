<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('12345678');
        $adminRecords = [
            ['id'=> 1, 'name'=> "Admin", 'email'=> "admin@gmail.com", 'password'=> $password,'photo'=> "admin.jpg", 'token'=> ""],
        ];
        Admin::insert($adminRecords);
    }
}