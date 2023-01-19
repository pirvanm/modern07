<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Cities\Entities\City;
use Modules\Cities\Entities\County;

class CountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @r    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $county = County::factory(1)->create([
            'name' => 'Bucuresti',
            'abbr' => 'B',
        ])->each(function ($county) {
            $county->cities()->save(City::create([
                'name' => 'Bucuresti',
            ]));
            $county->cities()->save(City::create([
                'name' => 'Municipiul Bucuresti',
            ]));
        });
    }
}
