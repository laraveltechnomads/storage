<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\TimeSlot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            '00:30' => ['AM','00:30 AM', 'night'],
            '00:45' => ['AM','00:45 AM', 'night'],
            '01:00' => ['AM','01:00 AM', 'night'],
            '01:15' => ['AM','01:15 AM', 'night'],
            '01:30' => ['AM','01:30 AM', 'night'],
            '01:45' => ['AM','01:45 AM', 'night'],
            '02:00' => ['AM','02:00 AM', 'night'],
            '02:15' => ['AM','02:15 AM', 'night'],
            '02:30' => ['AM','02:30 AM', 'night'],
            '02:45' => ['AM','02:45 AM', 'night'],
            '03:00' => ['AM','03:00 AM', 'night'],
            '03:15' => ['AM','03:15 AM', 'night'],
            '03:30' => ['AM','03:30 AM', 'night'],
            '03:45' => ['AM','03:45 AM', 'night'],
            '04:00' => ['AM','04:00 AM', 'night'],
            '04:15' => ['AM','04:15 AM', 'night'],
            '04:30' => ['AM','04:30 AM', 'night'],
            '04:45' => ['AM','04:45 AM', 'night'],
            '05:00' => ['AM','05:00 AM', 'morning'],
            '05:15' => ['AM','05:15 AM', 'morning'],
            '05:30' => ['AM','05:30 AM', 'morning'],
            '05:45' => ['AM','05:45 AM', 'morning'],
            '06:00' => ['AM','06:00 AM', 'morning'],
            '06:15' => ['AM','06:15 AM', 'morning'],
            '06:30' => ['AM','06:30 AM', 'morning'],
            '06:45' => ['AM','06:45 AM', 'morning'],
            '07:00' => ['AM','07:00 AM', 'morning'],
            '07:15' => ['AM','07:15 AM', 'morning'],
            '07:30' => ['AM','07:30 AM', 'morning'],
            '07:45' => ['AM','07:45 AM', 'morning'],
            '08:00' => ['AM','08:00 AM', 'morning'],
            '08:15' => ['AM','08:15 AM', 'morning'],
            '08:30' => ['AM','08:30 AM', 'morning'],
            '08:45' => ['AM','08:45 AM', 'morning'],
            '09:00' => ['AM','09:00 AM', 'morning'],
            '09:15' => ['AM','09:15 AM', 'morning'],
            '09:30' => ['AM','09:30 AM', 'morning'],
            '09:45' => ['AM','09:45 AM', 'morning'],
            '10:00' => ['AM','10:00 AM', 'morning'],
            '10:15' => ['AM','10:15 AM', 'morning'],
            '10:30' => ['AM','10:30 AM', 'morning'],
            '10:45' => ['AM','10:45 AM', 'morning'],
            '11:00' => ['AM','11:00 AM', 'morning'],
            '11:15' => ['AM','11:15 AM', 'morning'],
            '11:30' => ['AM','11:30 AM', 'morning'],
            '11:45' => ['AM','11:45 AM', 'morning'],
            '12:00' => ['PM','00:00 PM', 'afternoon'],
            '12:15' => ['PM','00:15 PM', 'afternoon'],
            '12:30' => ['PM','00:30 PM', 'afternoon'],
            '12:40' => ['PM','00:45 PM', 'afternoon'],
            '13:00' => ['PM','01:00 PM', 'afternoon'],
            '13:15' => ['PM','01:15 PM', 'afternoon'],
            '13:30' => ['PM','01:30 PM', 'afternoon'],
            '13:45' => ['PM','01:45 PM', 'afternoon'],
            '14:00' => ['PM','02:00 PM', 'afternoon'],
            '14:15' => ['PM','02:15 PM', 'afternoon'],
            '14:30' => ['PM','02:30 PM', 'afternoon'],
            '14:45' => ['PM','02:45 PM', 'afternoon'],
            '15:00' => ['PM','03:00 PM', 'afternoon'],
            '15:15' => ['PM','03:15 PM', 'afternoon'],
            '15:30' => ['PM','03:30 PM', 'afternoon'],
            '15:45' => ['PM','03:45 PM', 'afternoon'],
            '16:00' => ['PM','04:00 PM', 'afternoon'],
            '16:15' => ['PM','04:15 PM', 'afternoon'],
            '16:30' => ['PM','04:30 PM', 'afternoon'],
            '16:45' => ['PM','04:45 PM', 'afternoon'],
            '17:00' => ['PM','05:00 PM', 'evening'],
            '17:15' => ['PM','05:15 PM', 'evening'],
            '17:30' => ['PM','05:30 PM', 'evening'],
            '17:45' => ['PM','05:45 PM', 'evening'],
            '18:00' => ['PM','06:00 PM', 'evening'],
            '18:15' => ['PM','06:15 PM', 'evening'],
            '18:30' => ['PM','06:30 PM', 'evening'],
            '18:45' => ['PM','06:45 PM', 'evening'],
            '19:00' => ['PM','07:00 PM', 'night'],
            '19:15' => ['PM','07:15 PM', 'night'],
            '19:30' => ['PM','07:30 PM', 'night'],
            '19:45' => ['PM','07:45 PM', 'night'],
            '20:00' => ['PM','08:00 PM', 'night'],
            '20:15' => ['PM','08:15 PM', 'night'],
            '20:30' => ['PM','08:30 PM', 'night'],
            '20:45' => ['PM','08:45 PM', 'night'],
            '21:00' => ['PM','09:00 PM', 'night'],
            '21:15' => ['PM','09:15 PM', 'night'],
            '21:30' => ['PM','09:30 PM', 'night'],
            '21:45' => ['PM','09:45 PM', 'night'],
            '22:00' => ['PM','10:00 PM', 'night'],
            '22:15' => ['PM','10:15 PM', 'night'],
            '22:30' => ['PM','10:30 PM', 'night'],
            '22:45' => ['PM','10:45 PM', 'night'],
            '23:00' => ['PM','11:00 PM', 'night'],
            '23:15' => ['PM','11:15 PM', 'night'],
            '23:30' => ['PM','11:30 PM', 'night'],
            '23:45' => ['PM','11:45 PM', 'night'],
            '23:59' => ['PM','11:59 PM', 'night'],
        ];
        foreach ($data as $key => $result) {
            TimeSlot::create([
                'time' => $key,
                'type' => $result[0],
                'description' => $result[1],
                'time_of_day' => $result[2],
            ]);
        }
    }
}
