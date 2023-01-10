<?php

namespace Database\Seeders;

use App\Models\API\V1\ANF\OpdFormat;
use App\Models\API\V1\Master\MrnFormat;
use Illuminate\Database\Seeder;

class AutoNumberFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Male',
            'Female',
            'Transgender'
        ];
        
        foreach($data as $k => $insert) {
            $in['sequence_name'] = $insert;
            $in['status'] = 1;
            MrnFormat::updateOrCreate( ['sequence_name' =>  $in['sequence_name']],$in);
        }
        foreach($data as $k => $insert) {
            $in['sequence_name'] = $insert;
            $in['status'] = 1;
            OpdFormat::updateOrCreate( ['sequence_name' =>  $in['sequence_name']],$in);
        }
    }
}
