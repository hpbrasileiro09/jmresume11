<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_category');
            $table->dateTime('dt_entry');
            $table->decimal('vl_entry', 5, 2);
            $table->string('nm_entry');
            $table->string('ds_category');
            $table->string('ds_subcategory');
            $table->tinyInteger('status');
            $table->tinyInteger('fixed_costs');
            $table->tinyInteger('checked');
            $table->tinyInteger('published');
            $table->string('ds_detail');
            $table->timestamps();
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('published');
            $table->decimal('vl_prev', 5, 2);
            $table->integer('day_prev');
            $table->integer('ordem');
            $table->string('type');
            $table->timestamps();
        });
        Schema::create('params', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('value');
            $table->string('default');
            $table->dateTime('dt_params');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('params');
    }
};
