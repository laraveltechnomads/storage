<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\AppointmentReason;
use Illuminate\Database\Seeder;

class AppointmentReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'other',
        ];
        foreach($data as $k => $insert) {

            $in['code'] = $k+1;
            $in['description'] = $insert;
            $in['status'] = 1;
            AppointmentReason::updateOrCreate( ['code' =>  $in['code']],$in);
        }
    }
}
