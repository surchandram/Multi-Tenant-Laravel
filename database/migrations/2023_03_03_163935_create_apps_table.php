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
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->nestedSet();
            $table->string('name', 60)->unique();
            $table->string('key', 30)->unique();
            $table->string('url')->nullable()->unique();
            $table->text('description');
            $table->boolean('usable')->default(false);
            $table->boolean('teams_only')->default(false);
            $table->boolean('primary')->default(false);
            $table->boolean('subscription')->default(false);
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
        Schema::dropIfExists('apps');
    }
};
