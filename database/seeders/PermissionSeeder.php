<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'users_index',
            'display_name' => 'Users Index',
            'guard_name' => 'web',
            'description' =>'Users Index',
        ]);

        DB::table('permissions')->insert([
            'name' => 'roles_index',
            'display_name' => 'Roles Index',
            'guard_name' => 'web',
            'description' =>'Roles Index',
        ]);


        DB::table('permissions')->insert([
            'name' => 'proposals_index',
            'display_name' => 'Proposal Index',
            'guard_name' => 'web',
            'description' =>'Proposal Index',
        ]);

        DB::table('permissions')->insert([
            'name' => 'proposal_create',
            'display_name' => 'Proposals Create',
            'guard_name' => 'web',
            'description' =>'Proposals Create',
        ]);

        DB::table('permissions')->insert([
            'name' => 'proposals_index_juridic',
            'display_name' => 'Proposals Index Juridic',
            'guard_name' => 'web',
            'description' =>'Proposals Index Juridic',
        ]);

        DB::table('permissions')->insert([
            'name' => 'proposals_show_aproba_operational',
            'display_name' => 'Proposals Show Aproba Operational',
            'guard_name' => 'web',
            'description' =>'Proposals Show Aproba Operational',
        ]);


        DB::table('permissions')->insert([
            'name' => 'proposals_index_zonal',
            'display_name' => 'Proposals Index Zonal',
            'guard_name' => 'web',
            'description' =>'Proposals Index Zonal',
        ]);


        DB::table('permissions')->insert([
            'name' => 'proposals_index_e',
            'display_name' => 'Proposals Index E',
            'guard_name' => 'web',
            'description' =>'Proposals Index E',
        ]);


        DB::table('permissions')->insert([
            'name' => 'proposals_index_d',
            'display_name' => 'Proposals Index D',
            'guard_name' => 'web',
            'description' =>'Proposals Index D',
        ]);


        DB::table('permissions')->insert([
            'name' => 'opens_index',
            'display_name' => 'Opens Index ',
            'guard_name' => 'web',
            'description' =>'Opens Index ',
        ]);

        DB::table('permissions')->insert([
            'name' => 'shops_index',
            'display_name' => 'Shops Index ',
            'guard_name' => 'web',
            'description' =>'Shops Index ',
        ]);


    }
}
