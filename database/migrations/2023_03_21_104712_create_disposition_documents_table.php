<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispositionDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposition_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('index')->nullable();
            $table->string('letter_type')->nullable();
            $table->string('code')->nullable();
            $table->date('date_finish')->nullable();
            $table->date('date_number')->nullable();
            $table->string('from')->nullable();
            $table->string('resume_content')->nullable();
            $table->string('agenda_number')->nullable();
            $table->date('agenda_date')->nullable();
            $table->string('uploaded_document')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disposition_documents');
    }
}
