<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftdeleteToDoctorSlotAppointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('doctor_slot_appointments', 'deleted_at')) {
            Schema::table('doctor_slot_appointments', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
        if (!Schema::hasColumn('doctor_slot_appointments', 'is_complete')) {
            Schema::table('doctor_slot_appointments', function (Blueprint $table) {
                $table->boolean('is_complete')->default(0)->after('status');    
            });
        }

        Schema::table('appointments', function (Blueprint $table) {
            $table->boolean('visit_mark')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('doctor_slot_appointments', 'deleted_at')) {
            Schema::table('doctor_slot_appointments', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
        if (!Schema::hasColumn('doctor_slot_appointments', 'is_complete')) {
            Schema::table('doctor_slot_appointments', function (Blueprint $table) {
                $table->dropColumn(['is_complete']);
            });
        }

        Schema::table('appointments', function (Blueprint $table) {
            $table->string('visit_mark')->nullable()->change();
        });
    }
}
