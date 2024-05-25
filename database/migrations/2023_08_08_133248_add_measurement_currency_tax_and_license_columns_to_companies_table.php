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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('measurement_unit')->nullable()->default('feet');
            $table->string('currency')->nullable()->default('usd');
            $table->unsignedFloat('default_tax')->nullable();
            $table->string('license_no')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('projects_prefix')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('measurement_unit');
            $table->dropColumn('currency');
            $table->dropColumn('default_tax');
            $table->dropColumn('license_no');
            $table->dropColumn('tax_id');
            $table->dropColumn('projects_prefix');
        });
    }
};
