<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('number')->collation('utf8_general_ci')->nullable();
            $table->date('date')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('from')->collation('utf8_general_ci')->nullable();
            $table->float('concession_percentage')->nullable();
            $table->double('concession_amount')->nullable();
            $table->float('excise')->nullable()->comment('discount');
            $table->double('excise_amount')->nullable();
            $table->float('tax')->nullable()->comment('cgst');
            $table->double('tax_amount')->nullable();
            $table->float('sgst')->nullable();
            $table->double('sgst_amount')->nullable();
            $table->float('igst')->nullable();
            $table->double('igst_amount')->nullable();
            $table->double('net_amount')->nullable();
            $table->string('specification')->nullable();  
            $table->string('item_ids')->collation('utf8_general_ci')->nullable();  
            // attachment with denormalization
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
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
        Schema::dropIfExists('quotations');
    }
}
