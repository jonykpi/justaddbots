<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('companies')->delete();
        
        \DB::table('companies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'name' => 'Docs2ai',
                'personal_company' => 1,
                'created_at' => '2023-04-30 10:25:22',
                'updated_at' => '2023-04-30 10:25:22',
            ),
        ));
        
        
    }
}