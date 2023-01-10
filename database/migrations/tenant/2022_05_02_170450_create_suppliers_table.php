<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_code',10)->nullable();
            $table->string('description',100)->nullable();
            $table->string('address_line_1',100)->nullable();
            $table->string('address_line_2',100)->nullable();
            $table->string('address_line_3',100)->nullable();
            $table->string('country_code',10)->nullable();
            $table->string('state_code',10)->nullable();
            $table->string('city_code',10)->nullable();
            $table->string('pin_code',10)->nullable();
            $table->string('contact_person1_name',20)->nullable();
            $table->string('contact_person1_mobile_no',20)->nullable();
            $table->string('contact_person1_email_id',50)->nullable();
            $table->string('contact_person2_name',50)->nullable();
            $table->string('contact_person2_mobile_no',20)->nullable();
            $table->string('contact_person2_email_id',50)->nullable();
            $table->string('phone_no',20)->nullable();
            $table->string('fax',20)->nullable();
            $table->string('mode_of_payment',20)->nullable();
            $table->string('tax_nature',20)->nullable();
            $table->string('term_of_payment',20)->nullable();
            $table->string('cu_id',20)->nullable();
            $table->string('mast_number',20)->nullable();
            $table->string('vat_number',20)->nullable();
            $table->string('cst_number',20)->nullable();
            $table->string('drug_licence_number',20)->nullable();
            $table->string('service_tax_number',20)->nullable();
            $table->string('pan_number',20)->nullable();
            $table->string('m_flag',20)->nullable();
            $table->string('depreciation',20)->nullable();
            $table->string('rating_system',20)->nullable();
            $table->unsignedBigInteger('supplier_category_id')->nullable();
            $table->string('status',10)->nullable();
            $table->unsignedBigInteger('created_unit_id')->nullable();
            $table->unsignedBigInteger('updated_unit_id')->nullable();
            $table->string('added_by',10)->nullable();
            $table->string('added_on',10)->nullable();
            $table->timestamp('added_date_time')->nullable();
            $table->string('added_utc_date_time',10)->nullable();
            $table->string('updated_by', 10)->nullable();
            $table->timestamp('updated_date_time')->nullable();
            $table->string('updated_utc_date_time',10)->nullable();
            $table->string('added_windows_login_name', 12)->nullable();
            $table->string('update_windows_login_name', 10)->nullable();
            $table->tinyInteger('synchronized')->nullable();

            $table->foreign('supplier_category_id')->references('id')->on('supplier_categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}

