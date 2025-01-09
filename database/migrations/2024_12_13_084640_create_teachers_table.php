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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->string('phone_number');
            $table->string('pfpURL');
            $table->string('email');
            $table->string('password');
            $table->enum('role', ['admin', 'user']);
            $table->string('nuptk');
            $table->string('community');
            $table->string('subjectTaught');
            $table->foreignId('school_id')->constrained(
                table:'schools',
                indexName:'teachers_school_id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
