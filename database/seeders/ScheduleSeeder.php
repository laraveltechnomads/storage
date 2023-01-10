<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Daily' => ['00:00:00', '23:59:59'],
            'Weekly' => ['00:00:00', '23:59:59'],
            'Monthly' => ['00:00:00', '23:59:59'],
        ];
        foreach ($data as $key => $result) {
            Schedule::create([
                'description' => $key,
                'from_time' => $result[0],
                'to_time' => $result[1],
            ]);
        }
    }
}