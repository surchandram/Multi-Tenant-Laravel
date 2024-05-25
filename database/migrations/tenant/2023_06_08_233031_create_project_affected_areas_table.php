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
        Schema::create('project_affected_areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->forTenant();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('affected_area_id')->constrained('affected_areas')->cascadeOnDelete();
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
        Schema::dropIfExists('project_affected_areas');
    }
};
