<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Companies\Entities\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::factory(1)->create([
            'name' => 'PJ AUTO STORE UNIVERSAL S.R.L',
            'cui' => '46863948',
            'reg' => 'J40/18547/20.09.2022',
            'city_id' => 1,
            'phone' => '0745069444',
            'email' => 'lunguliviuionut@gmail.com',
            'type' => 'PARTNER',
        ]);
    }
}
