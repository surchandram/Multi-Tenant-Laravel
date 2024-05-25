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
        Schema::table('moisture_maps', function (Blueprint $table) {
            $table->foreignId('device_id')->nullable()->constrained('devices')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moisture_maps', function (Blueprint $table) {
            $table->dropConstrainedForeignId('device_id');
        });
    }
};
