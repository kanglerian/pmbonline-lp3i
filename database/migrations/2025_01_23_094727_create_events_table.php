<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->year('pmb');
            $table->string('code',255)->unique();
            $table->string('title');
            $table->text('description');
            $table->integer('view')->default(0);
            $table->boolean('is_scholarship')->default(false);
            $table->boolean('is_files')->default(false);
            $table->boolean('is_employee')->default(false);
            $table->boolean('is_program')->default(false);
            $table->boolean('is_address')->default(false);
            $table->boolean('is_parent')->default(false);
            $table->boolean('is_invite')->default(false);
            $table->char('program', 3)->default('R');
            $table->boolean('is_status')->default(true);
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
        Schema::dropIfExists('events');
    }
}
