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
        Schema::create('psychrometry_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->forTenant();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('project_affected_area_id')->constrained('project_affected_areas')->cascadeOnDelete();
            $table->foreignId('psychrometry_measure_point_id')->constrained('psychrometry_measure_points')->cascadeOnDelete();
            $table->float('temperature');
            $table->float('relative_humidity');
            $table->timestamp('recorded_at')->nullable();
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
        Schema::dropIfExists('psychrometry_reports');
    }
};
