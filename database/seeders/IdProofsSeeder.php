<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\IdProof;
use Illuminate\Database\Seeder;

class IdProofsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Marriage Certificate',
            'PassPort',
            'Driving License',
            'Voter Card',
            'Pan Card',
            'Adhaar card',
            'Other'
        ];
        
        foreach($data as $k => $insert) {
            $in['description'] = $insert;
            $in['proof_code'] = $k+1;
            $in['status'] = 1;
            IdProof::updateOrCreate( ['description' =>  $in['description']],$in);
        }
    }
}
