<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('event');
            $table->integer('xp')->default(0);
            $table->integer('coins')->default(0);
            $table->decimal('multiplier', 5, 2)->default(1.00);
            $table->json('conditions')->nullable();
            $table->enum('is_active', ['0', '1'])->default('1');
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
        Schema::dropIfExists('task_rewards');
    }
}
