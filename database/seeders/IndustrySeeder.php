<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IndustrySeeder extends Seeder
{
    public function run()
    {
        DB::table('industries')->insert([
            [
                'industry_id'   => 1,
                'industry_name' => 'Information Technology',
                'status'        => 'Active',
                'created_at'    => Carbon::now(),
                'created_by'    => 1,
                'updated_by'    => null,
                'deleted_at'    => null,
                'deleted_by'    => null,
            ],
            [
                'industry_id'   => 2,
                'industry_name' => 'Manufacturing',
                'status'        => 'Active',
                'created_at'    => Carbon::now(),
                'created_by'    => 1,
                'updated_by'    => null,
                'deleted_at'    => null,
                'deleted_by'    => null,
            ],
            [
                'industry_id'   => 3,
                'industry_name' => 'Finance',
                'status'        => 'Inactive',
                'created_at'    => Carbon::now(),
                'created_by'    => 2,
                'updated_by'    => null,
                'deleted_at'    => null,
                'deleted_by'    => null,
            ],
        ]);
    }
}
