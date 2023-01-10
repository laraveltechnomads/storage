<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\MonthMaster;
use Illuminate\Database\Seeder;

class MonthMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            '01' => ['Jan','January'],
            '02' => ['Feb','February'],
            '03' => ['Mar','March'],
            '04' => ['Apr','April'],
            '05' => ['May','May'],
            '06' => ['Jun','June'],
            '07' => ['Jul','July'],
            '08' => ['Aug','Aug'],
            '09' => ['Sep','September'],
            '10' => ['Oct','October'],
            '11' => ['Nov','November'],
            '12' => ['Dec','December'],
        ];
        foreach ($data as $key => $result) {
            MonthMaster::create([
                'code' => $key,
                'slug' => $result[0],
                'description' => $result[1],
                'status' => 1,
            ]);
        }
    }
}
