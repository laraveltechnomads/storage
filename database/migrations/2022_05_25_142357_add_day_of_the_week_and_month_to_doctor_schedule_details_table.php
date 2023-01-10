<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDayOfTheWeekAndMonthToDoctorScheduleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_schedule_details', function (Blueprint $table) {
            $table->string('day_of_the_week')->nullable()->after('updated_windows_login_name');
            $table->string('month')->nullable()->after('day_of_the_week');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_schedule_details', function (Blueprint $table) {
            $table->dropColumn(['day_of_the_week', 'month']);
        });
    }
}
