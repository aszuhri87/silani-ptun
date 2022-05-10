<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentCategoryRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_category_requirements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('document_category_id')->nullable();
            $table->string('requirement_type')->nullable();
            $table->string('requirement')->nullable();
            $table->integer('required')->nullable();
            $table->string('data_min')->nullable();
            $table->string('data_max')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('document_category_id')
            ->references('id')
            ->on('document_categories')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('requirement_type')
            ->references('requirement_type')
            ->on('requirement_types')
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
        Schema::dropIfExists('document_category_requirements');
    }
}
