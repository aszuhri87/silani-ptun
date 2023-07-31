<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddRoleToAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('role')->nullable();
            $table->dropColumn('unit_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->uuid('unit_id')->nullable();

            $table->foreign('unit_id')
            ->references('id')
            ->on('units')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->dropColumn('role');
        });
    }
}
