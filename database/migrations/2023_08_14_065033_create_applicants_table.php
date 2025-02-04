<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();

            $table->string('identity', 50)->unique();
            $table->year('pmb');

            $table->string('nik', 16)->nullable();
            $table->string('name', 150);
            $table->boolean('gender')->default(true);
            $table->string('religion', 50)->nullable();
            $table->text('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->string('social_media', 100)->nullable();

            $table->string('email', 100)->nullable()->unique();
            $table->string('phone', 20)->nullable()->unique();

            $table->string('education', 20)->nullable();
            $table->string('major', 100)->nullable();
            $table->string('class', 100)->nullable();
            $table->year('year')->nullable();
            $table->text('achievement')->nullable();
            $table->text('kip')->nullable();
            $table->string('nisn')->nullable();


            $table->boolean('schoolarship')->default(false);
            $table->dateTime('scholarship_date')->nullable();
            $table->text('scholarship_type')->nullable();

            $table->text('note')->nullable();
            $table->text('relation')->nullable();

            $table->string('identity_user', 50)->nullable();
            $table->string('program', 255)->nullable();
            $table->string('program_second', 255)->nullable();
            $table->char('isread', 1)->nullable();
            $table->char('come',1)->nullable();

            $table->boolean('is_applicant')->default(false);
            $table->boolean('is_daftar')->default(false);
            $table->boolean('is_register')->default(false);

            $table->char('known', 1)->nullable();
            $table->text('planning')->nullable();
            $table->text('other_campus')->nullable();
            $table->string('income_parent')->nullable();

            $table->text('place_of_working')->nullable();

            $table->unsignedBigInteger('source_daftar_id')->nullable();
            $table->unsignedBigInteger('school')->nullable();
            $table->unsignedBigInteger('followup_id')->nullable();
            $table->unsignedBigInteger('programtype_id')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->unsignedBigInteger('status_id')->default(1);

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
        Schema::dropIfExists('applicants');
    }
}
