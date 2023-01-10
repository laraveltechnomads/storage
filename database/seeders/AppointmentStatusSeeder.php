<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\AppointmentStatus;
use Illuminate\Database\Seeder;

class AppointmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'New',
            'Cancel',
            'Reschedule'
        ];
        foreach($data as $k => $insert) {
            $in['description'] = $insert;
            $in['status'] = 1;
            AppointmentStatus::updateOrCreate( ['description' =>  $in['description']],$in);
        }
    }
}
