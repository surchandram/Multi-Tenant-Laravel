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
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->forTenant();
            $table->string('name');
            $table->uuid('uuid');
            $table->string('slug')->unique();
            $table->string('description', 300)->nullable();
            $table->text('overview')->nullable();
            $table->foreignId('type_id')->nullable()->constrained('project_types')->nullOnDelete();
            $table->foreignId('class_id')->nullable()->constrained('project_classes')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('project_categories')->nullOnDelete();
            $table->foreignId('status_id')->nullable()->constrained('project_statuses')->nullOnDelete();
            $table->string('point_of_loss')->nullable();
            $table->date('loss_occurred_at')->nullable();
            $table->date('contacted_at')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('projects');
    }
};
