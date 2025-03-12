<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('course_name', 256);
            $table->integer('credit_hours');
            $table->float('grade');
            $table->string('term', 50); // زي "Fall 2024" أو "Spring 2025"
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('grades');
    }
};