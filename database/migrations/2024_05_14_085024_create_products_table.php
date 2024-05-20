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
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name', 255)->nullable(false);
            $table->text('description', 255);
            $table->integer('price')->nullable(false);
            $table->string('image', 255);
            $table->unsignedInteger('category_id')->nullable(false);
            $table->date('expired_at')->nullable(false);
            $table->string('modified_by', 255)->nullable(false)->comment('email user');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
