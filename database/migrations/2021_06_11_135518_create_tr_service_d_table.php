<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrServiceDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_service_d', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('service_h_id')->unsigned();
            $table->bigInteger('service_id')->unsigned();
            $table->bigInteger('service_type_id')->unsigned();
            $table->bigInteger('price');
            $table->string('status', 2)->default('00');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->index([
                'status'
            ]);
            $table->foreign('service_h_id')->references('id')->on('tr_service_h');
            $table->foreign('service_id')->references('id')->on('ms_services');
            $table->foreign('service_type_id')->references('id')->on('ms_service_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_service_d');
    }
}
