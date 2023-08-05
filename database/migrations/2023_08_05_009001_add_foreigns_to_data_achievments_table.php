<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('data_achievments', function (Blueprint $table) {
            $table
                ->foreign('achievment_id')
                ->references('id')
                ->on('achievments')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_achievments', function (Blueprint $table) {
            $table->dropForeign(['achievment_id']);
            $table->dropForeign(['student_id']);
            $table->dropForeign(['teacher_id']);
        });
    }
};
