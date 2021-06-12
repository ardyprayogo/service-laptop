<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('service_type_id')->unsigned();
            $table->string('service', 50);
            $table->integer('price')->default(0);
            $table->string('desc', 150)->nullable();
            $table->string('status', 2)->default('00');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->index([
                'status'
            ]);
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
        Schema::dropIfExists('ms_services');
    }
}
