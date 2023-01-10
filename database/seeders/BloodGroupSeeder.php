<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\BloodGroup;
use Illuminate\Database\Seeder;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'A +ve',
            'B +ve',
            'AB +ve',
            'O +ve',
            'A -ve',
            'B -ve',
            'AB -ve',
            'O -ve',
            'Not Known'
        ];
        
        foreach($data as $k => $insert) {
            $in['description'] = $insert;
            $in['blood_code'] = $k+1;
            $in['status'] = 1;
            BloodGroup::updateOrCreate( ['description' =>  $in['description']],$in);
        }
    }
}
