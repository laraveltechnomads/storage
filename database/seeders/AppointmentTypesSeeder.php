<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\AppointmentType;
use Illuminate\Database\Seeder;

class AppointmentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Turned Up',
            'Non Turned Up'
        ];
        
        foreach($data as $k => $insert) {
            $in['description'] = $insert;
            $in['status'] = 1;
            AppointmentType::updateOrCreate( ['description' =>  $in['description']],$in);
        }
    }
}
