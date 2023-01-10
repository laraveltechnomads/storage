<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\DayMaster;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DayMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
        ];
        
        foreach($data as $k => $insert) {
            $in['description'] = $insert;
            $in['code'] = $k+1;
            $in['status'] = 1;
            DayMaster::updateOrCreate( ['description' =>  $in['description']],$in);
        }
    }
}
