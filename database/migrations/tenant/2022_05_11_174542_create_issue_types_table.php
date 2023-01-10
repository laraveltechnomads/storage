<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateIssueTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_types', function (Blueprint $table) {
            $table->id();
            $table->string('description',100)->nullable();
            $table->tinyInteger('status')->default(1)->comment('1= active, 0=inactive');
            $table->unsignedBigInteger('unit_id')->index();
            $table->unsignedBigInteger('client_id')->index();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('client_id')->references('id')->on('clients');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issue_types', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['client_id']);
        });
        Schema::dropIfExists('issue_types');
    }
}
