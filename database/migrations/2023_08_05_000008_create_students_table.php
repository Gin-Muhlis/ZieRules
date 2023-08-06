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
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nis', 9)->unique();
            $table->string('name');
            $table->string('password');
            $table->string('password_show');
            $table->string('image')->nullable();
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->unsignedBigInteger('class_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
