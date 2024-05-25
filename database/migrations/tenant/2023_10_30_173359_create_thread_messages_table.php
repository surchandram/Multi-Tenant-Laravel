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
        Schema::create('thread_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->forTenant();
            $table->foreignId('thread_id')->constrained('threads', 'id')->cascadeOnDelete();
            $table->foreignId('user_id')
                ->nullable()
                ->references('id')
                ->on(Saas::getUsersConnectionExpression())
                ->nullOnDelete();
            $table->text('body');
            $table->nestedSet();
            $table->timestamp('edited_at')->nullable();
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
        Schema::dropIfExists('thread_messages');
    }
};
