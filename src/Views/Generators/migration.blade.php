<?php echo '<?php' ?>

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
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->boolean('constrained')->default(false);
            $table->string('value_type');
            $table->double('min_value')->nullable();
            $table->double('max_value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('{{$allowedSettingValuesTable}}', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('setting_id')->unsigned();
            $table->foreign('setting_id')->references('id')->on('{{$settingsTable}}')->onUpdate('cascade');
            $table->string('value');
            $table->string('caption');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('{{$entitySettingsTable}}', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->morphs('entity');
            $table->bigInteger('value_id')->unsigned()->nullable();
            $table->foreign('value_id')->references('id')->on('{{$allowedSettingValuesTable}}')->onUpdate('cascade');
            $table->string('value')->nullable();
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
