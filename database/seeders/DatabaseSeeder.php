<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\Ledger;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        
        $this->call([
            AdminSeeder::class,
            LedgerSeeder::class,
            PatientCategorySeeder::class,
            BloodGroupSeeder::class,
            DayMasterSeeder::class,
            MaritalStatusSeeder::class,
            GenderSeeder::class,
            IdProofsSeeder::class,
            AppointmentStatusSeeder::class,
            AppointmentTypesSeeder::class,
            TimeSlotSeeder::class,
            SlotScheduleSeeder::class,
            ScheduleSeeder::class,
            MonthMasterSeeder::class,
            AppointmentReasonsSeeder::class,
            ConsultationVisitTypeSeeder::class,
            AutoNumberFormatSeeder::class
        ]);
    }
}