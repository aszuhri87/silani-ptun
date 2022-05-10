<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_requirements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('document_id')->nullable();
            $table->uuid('document_category_requirement_id')->nullable();
            $table->string('requirement_value')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('document_category_requirement_id')
            ->references('id')
            ->on('document_category_requirements')
            ->onUpdate('cascade')
            ->onDelete('cascade');

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
        Schema::dropIfExists('document_requirements_');
    }
}
