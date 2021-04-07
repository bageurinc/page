<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJudulSeoBgrPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bgr_page', function (Blueprint $table) {
            $table->string('judul_seo')->nullable()->after('judul');
            $table->integer('training_jenis_id')->unsigned()->nullable();
            $table->integer('training_id')->unsigned()->nullable();
            $table->integer('training_group_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bgr_page', function (Blueprint $table) {
            //
        });
    }
}
