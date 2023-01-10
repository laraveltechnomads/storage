<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\MaritalStatus;
use Illuminate\Database\Seeder;

class MaritalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'MARRIED',
            'SINGLE',
            'DIVORCED',
            'WIDOW'
        ];
        
        foreach($data as $k => $insert) {
            $in['description'] = $insert;
            $in['code'] = $k+1;
            $in['status'] = 1;
            MaritalStatus::updateOrCreate( ['description' =>  $in['description']],$in);
        }
    }
}
