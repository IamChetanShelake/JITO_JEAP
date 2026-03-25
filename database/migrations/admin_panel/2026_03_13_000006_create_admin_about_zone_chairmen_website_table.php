<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('admin_panel')->create('admin_about_zone_chairmen_website', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('post')->nullable();
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('status')->default(true);
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
        Schema::connection('admin_panel')->dropIfExists('admin_about_zone_chairmen_website');
    }
};
