<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBgrPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_page', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->json('semua_meta');
            $table->enum('type', ['S', 'D'])->default('S');;
            $table->enum('status', ['A', 'T'])->default('A');;
            $table->longText('konten')->nullable();
            $table->string('view')->nullable();
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
        Schema::dropIfExists('bgr_page');
    }
}
