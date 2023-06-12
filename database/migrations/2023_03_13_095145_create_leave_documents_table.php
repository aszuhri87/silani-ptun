<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('permit_notes')->nullable();
            $table->uuid('unit_id')->nullable();
            $table->text('notes')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('permit_type')->nullable();
            $table->uuid('user_id')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->text('reason')->nullable();
            $table->string('working_time')->nullable();
            $table->string('status')->nullable();
            $table->string('signature')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('unit_id')
            ->references('id')
            ->on('units')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_documents');
    }
}
