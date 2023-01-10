<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('qty')->after('item_category_id')->nullable();
            $table->string('purchase_uom')->after('qty')->nullable();
            $table->text('remarks')->collation('utf8_general_ci')->nullable()->after('purchase_uom');
            $table->string('expiry_alert',20)->nullable()->after('remarks');
            $table->unsignedBigInteger('clinic_id')->nullable()->after('expiry_alert');
            $table->foreign('clinic_id')->references('id')->on('units')->onDelete('cascade');
            $table->string('rank',10)->nullable()->after('clinic_id');
            $table->string('shelf',10)->nullable()->after('rank');
            $table->string('container',10)->nullable()->after('shelf');
            $table->text('list_of_supplier')->nullable()->after('container');
            $table->string('base_unit_cost_price',10)->nullable()->after('list_of_supplier');
            $table->string('staff_discount_on_sale',10)->nullable()->after('base_unit_cost_price');
            $table->string('regi_patient_discount_on_sale',10)->nullable()->after('staff_discount_on_sale');
            $table->string('walk_in_patient_discount_on_sale',10)->nullable()->after('regi_patient_discount_on_sale');
            $table->string('cgst',10)->nullable()->after('walk_in_patient_discount_on_sale');
            $table->string('sgst',10)->nullable()->after('cgst');
            $table->string('igst',10)->nullable()->after('sgst');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('qty');
            $table->dropColumn('purchase_uom');
            $table->dropColumn('remarks');
            $table->dropColumn('expiry_alert');
            $table->dropForeign(['clinic_id']);
            $table->dropColumn('clinic_id');
            $table->dropColumn('rank');
            $table->dropColumn('shelf');
            $table->dropColumn('container');
            $table->dropColumn('list_of_supplier');
            $table->dropColumn('base_unit_cost_price');
            $table->dropColumn('staff_discount_on_sale');
            $table->dropColumn('regi_patient_discount_on_sale');
            $table->dropColumn('walk_in_patient_discount_on_sale');
            $table->dropColumn('cgst');
            $table->dropColumn('sgst');
            $table->dropColumn('igst');
        });
    }
}
