<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_name = Role::where("name", "admin") -> first();
        $user = new User();
        $user -> role_name = $role_name -> name;
        $user -> confirmed = true;
        $user -> user_name = "admin";
        $user -> real_name = "관리자";
        $user -> email = "admin@test.com";
        $user -> password = Hash::make(111111);
        $user -> joined = now();
        $user -> save();

    }
}
