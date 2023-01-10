<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegTypeLetterToPatientCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_categories', function (Blueprint $table) {
            $table->string('reg_type_letter')->collation('utf8_general_ci')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_categories', function (Blueprint $table) {
            $table->dropColumn('reg_type_letter');
        });
    }
}
