<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SAAS\App\Support\Saas;
use SAAS\Domain\Countries\Models\Country;

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
            $table->bigIncrements('id');
            $table->forTenant();
            $table->string('name');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('state');
            $table->string('city');
            $table->string('postal_code');
            $table->foreignIdFor(Country::class, 'country_id')
                // ->on(Saas::getCountriesConnectionExpression())
                ->nullable()
                ->nullOnDelete();
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
