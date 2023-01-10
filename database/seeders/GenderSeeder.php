<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
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
            $in['description'] = $insert;
            $in['gender_code'] = $k+1;
            $in['status'] = 1;
            Gender::updateOrCreate( ['description' =>  $in['description']],$in);
            Gender::where('description', 'Transgender')->update(['status' => 0]);
        }
    }
}
