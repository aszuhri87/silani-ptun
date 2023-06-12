<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_approvals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->string('note')->nullable();
            $table->string('signature')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('leave_approvals');
    }
}
