<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\SlotSchedule;
use Illuminate\Database\Seeder;

class SlotScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            '1' => ['Morning', '05:00:00', '11:59:00'],
            '2' => ['Afternoon', '12:00:00', '04:59:00'],
            '3' => ['Evening', '05:00:00', '06:59:00'],
            '4' => ['Full Day', '00:00:00', '23:59:00'],
        ];
        foreach ($data as $key => $result) {
            SlotSchedule::create([
                'code' => $key,
                'description' => $result[0],
                'start_time' => $result[1],
                'end_time' => $result[2],
            ]);
        }
    }
}
