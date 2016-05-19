<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('star')->default(1);
            $table->string('place', 150)->default('');
            $table->string('name', 150)->default('');
            $table->text('description')->nullable();
            $table->string('link', 150)->default('');
            $table->string('target', 30)->default('_self');
            $table->dateTime('published_at');
            $table->dateTime('until_then')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('banners');
    }
}
