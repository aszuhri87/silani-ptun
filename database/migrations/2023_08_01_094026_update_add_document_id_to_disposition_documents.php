<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddDocumentIdToDispositionDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disposition_documents', function (Blueprint $table) {
            $table->uuid('document_id')->nullable();

            $table->foreign('document_id')
            ->references('id')
            ->on('documents')
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
        Schema::table('disposition_documents', function (Blueprint $table) {
            $table->dropColumn('document_id');
        });
    }
}
