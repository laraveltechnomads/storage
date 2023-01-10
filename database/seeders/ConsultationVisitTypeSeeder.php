<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\API\V1\Patients\ConsultationVisitType;


class ConsultationVisitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Consultation',
            'Day Procedures',
            'Follow Up Consultation',
            'Laboratory',
            'Pharmacy',
            'Registration',
        ];
        foreach($data as $insert) {
            $in['description'] = $insert;
            ConsultationVisitType::create($in);
        }
       
    }
}
