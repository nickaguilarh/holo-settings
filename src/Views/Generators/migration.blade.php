<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHoloSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();

        Schema::create('{{$settingsTable}}', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name')->unique();
            $table->boolean('constrained')->default(false);
            $table->string('value_type');
            $table->double('min_value')->nullable();
            $table->double('max_value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('{{$allowedSettingValuesTable}}', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('setting_uuid');
            $table->foreign('setting_uuid')->references('uuid')->on('{{$settingsTable}}')->onUpdate('cascade');
            $table->string('value');
            $table->string('caption');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('{{$entitySettingsTable}}', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->morphs('entity');
            $table->string('value')->nullable();
            $table->uuid('value_uuid')->nullable();
            $table->foreign('value_uuid')->references('uuid')->on('{{$allowedSettingValuesTable}}')->onUpdate('cascade');
            $table->uuid('setting_uuid')->nullable();
            $table->foreign('setting_uuid')->references('uuid')->on('{{$settingsTable}}')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('{{$entitySettingsTable}}');
        Schema::drop('{{$allowedSettingValuesTable}}');
        Schema::drop('{{$settingsTable}}');
    }
}
