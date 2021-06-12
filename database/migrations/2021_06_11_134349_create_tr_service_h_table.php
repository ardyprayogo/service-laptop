<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrServiceHTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_service_h', function (Blueprint $table) {
            $table->id();
            $table->string('service_code', 50);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('total_price');
            $table->bigInteger('down_payment');
            $table->timestamp('date_time')->useCurrent();
            $table->string('laptop', 150);
            $table->string('case', 150);
            $table->string('service_status', 2)->default('00');
            $table->string('status', 2)->default('00');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->index([
                'service_status',
                'status'
            ]);
            $table->foreign('customer_id')->references('id')->on('ms_customers');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_service_h');
    }
}
