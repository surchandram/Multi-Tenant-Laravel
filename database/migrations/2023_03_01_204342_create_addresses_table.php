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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('state');
            $table->string('city');
            $table->string('postal_code');
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $table->morphs('addressable');
            $table->boolean('default')->default(false);
            $table->boolean('billing')->default(false);
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
        Schema::dropIfExists('addresses');
    }
};
