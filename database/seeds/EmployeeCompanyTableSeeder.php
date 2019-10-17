<?php

use Illuminate\Database\Seeder;

use App\User;

use App\Company;



class EmployeeCompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $employee =  User::create([
            'first_name' =>'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'company' => 1,
            'user_type' => 1,
            'phone' => '09068294174',
        ]);

        for($i = 0; $i < 100; $i++){
            $employee =  User::create([
                'first_name' => $faker->firstName ,
                'last_name' => $faker->lastName ,
                'email' => $faker->email,
                'password' => Hash::make('password'),
                'company' => $faker->numberBetween(1,100),
                'user_type' => 2,
                'phone' =>  $faker->phoneNumber,
            ]);

            $company =  Company::create([
                'name' => $faker->company,
                'website' => "www.".$faker->company.".com",
                'email' => $faker->email,
            ]);
        }

    }
}
