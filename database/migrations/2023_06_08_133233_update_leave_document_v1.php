<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLeaveDocumentV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_documents', function (Blueprint $table) {
            $table->renameColumn('permit_notes', 'letter_head');
            $table->renameColumn('notes', 'leave_long');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_documents', function (Blueprint $table) {
            $table->renameColumn('letter_head', 'permit_notes');
            $table->renameColumn('leave_long', 'notes');
        });
    }
}
