<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_notes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('note')->nullable();
            $table->string('datetime')->nullable();
            $table->string('type')->nullable();
            $table->string('amount')->nullable();
            $table->string('remain')->nullable();
            $table->uuid('leave_document_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('leave_document_id')
            ->references('id')
            ->on('leave_documents')
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
        Schema::dropIfExists('leave_notes');
    }
}
