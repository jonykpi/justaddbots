<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@docs2ai.com',
                'email_verified_at' => '2023-04-30 10:04:36',
                'password' => '$2y$10$KNiECPcOfikyb5JWvW725OJONdzHXP0fM30adVmuT6BKZUbOfSAgy',
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'two_factor_confirmed_at' => NULL,
                'remember_token' => NULL,
                'current_company_id' => 1,
                'current_connected_account_id' => NULL,
                'profile_photo_path' => NULL,
                'created_at' => '2023-04-30 10:04:18',
                'updated_at' => '2023-04-30 16:13:03',
                'role' => 'admin',
            ),
        ));
        
        
    }
}