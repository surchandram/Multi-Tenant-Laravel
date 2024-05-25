<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SAAS\App\Support\Saas;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->forTenant();
            $table->text('body');
            $table->foreignId('project_id')->constrained('projects', 'id')->cascadeOnDelete();
            $table->foreignId('user_id')
                ->nullable()
                ->references('id')
                ->on(Saas::getUsersConnectionExpression())
                ->nullOnDelete();
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
        Schema::dropIfExists('project_logs');
    }
};
