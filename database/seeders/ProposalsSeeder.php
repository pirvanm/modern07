<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProposalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proposals')->insert([
            'city_id' => 2,
            'created_by' => 1,
            'type' => 'Casa JV',
            'note' => 'PBuna seara,Aceasta propunere este pentru ag Jv Fortuna,Spatiul este situat in Mun Targoviste ,intr-un loc cu vad foarte bun.
            Vom deschide cu tot pachetul nostru BET+SSBT+SLOTURI.Cu acest partener mai avem doaua locatii.I.L.Caragiale si I.L.Caragiale-Mija.Multumesc,o seara buna!',

            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('proposal_owners')->insert([
            'proposal_id' => 1,
            'name' => 1,
            'company' => 'Casa JV',
            'phone' => "0745885211",
            'email' => 'Proposals Index E',
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('proposal_owners')->insert([
            'proposal_id' => 1,
            'name' => 99,
            'company' => 'manus',
            'phone' =>2,
            'email' => 'marcopolo@gmail.com',
        ]);

        DB::table('proposal_spaces')->insert([
            'proposal_id' => 1,
            'agency_type' => 'FTN JV2',
            'space_type' => '99',
            'total_area' => '66',
            'area_annexes' => '99',
            'street_front' => 'frontala',
            'street_type' => 'ROAD',
            'grade' => 9,
            'bathroom' => 0,
        ]);
    }
}
