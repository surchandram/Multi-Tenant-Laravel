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
        Schema::create('project_insurance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->forTenant();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained('persons')->nullOnDelete();
            $table->foreignId('adjuster_id')->nullable()->constrained('persons')->nullOnDelete();
            $table->string('claim_no')->unique();
            $table->string('policy_no')->nullable();
            $table->integer('deductible')->nullable();
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
        Schema::dropIfExists('project_insurance');
    }
};
