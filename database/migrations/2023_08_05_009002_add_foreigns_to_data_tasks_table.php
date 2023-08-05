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
        Schema::table('data_tasks', function (Blueprint $table) {
            $table
                ->foreign('task_id')
                ->references('id')
                ->on('tasks')
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
        Schema::table('data_tasks', function (Blueprint $table) {
            $table->dropForeign(['task_id']);
            $table->dropForeign(['student_id']);
            $table->dropForeign(['teacher_id']);
        });
    }
};
