<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExitPermitDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_permit_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('notes')->nullable();
            $table->uuid('user_id')->nullable();
            $table->uuid('unit_id')->nullable();
            $table->dateTime('datetime')->nullable();
            $table->text('reason')->nullable();
            $table->string('status')->nullable();
            $table->string('signature')->nullable();
            $table->string('approver')->nullable();
            $table->boolean('accepted')->default(false);

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
        Schema::dropIfExists('exit_permit_documents');
    }
}
