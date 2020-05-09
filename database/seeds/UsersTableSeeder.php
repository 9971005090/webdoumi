<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\User;
use App\UserProfile;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        //factory(\App\User::class, 1)->create();
        //$role_name = DB::table('roles')->pluck('name');
        //$role_name = Role::all()->random(1)->first();;

        //echo $role_name->name;
        for($i=0;$i<100;$i++)
        {
            $role_name = Role::all()->random(1)->first();;
            $user = User::create([
                'role_name' => $role_name->name,
                'user_name' => $faker->unique()->streetName,
                'real_name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => $faker->datetime(),
                'password' => Hash::make("111111"),
                'confirmed' => $faker->boolean,
                'suspended' => $faker->boolean,
                'last_login' => $faker->datetime(),
                'last_login_ip' => $faker->ipv4,
                'joined' => $faker->datetime(),
                'created_at' => $faker->datetime(),
                'updated_at' => $faker->datetime()
            ]);
            UserProfile::create([
                'user_id' => $user->id,
                'phone' => $faker->phoneNumber,
                'mobile_phone' => $faker->phoneNumber,
                'gender' => $faker->randomElements(['M', 'F'])[0],
                'birthday' => $faker->datetime(),
                'zipcode' => substr($faker->postcode, 0, 5),
                'address1' => $faker->address,
                'address2' => $faker->sentence
            ]);
        }

    }
}
