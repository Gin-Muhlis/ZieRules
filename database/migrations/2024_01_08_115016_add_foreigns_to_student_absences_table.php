<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('student_absences', function (Blueprint $table) {
            $table
            ->foreign('student_id')
            ->references('id')
            ->on('students')
            ->onUpdate('CASCADE')
            ->onDelete('CASCADE');

            $table
            ->foreign('presence_id')
            ->references('id')
            ->on('presences')
            ->onUpdate('CASCADE')
            ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_absences', function (Blueprint $table) {
            //
        });
    }
};
