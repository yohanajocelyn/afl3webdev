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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained(
                table: 'registrations',
                indexName: 'registration_has_submissions'
            );
            $table->foreignId('assignment_id')->constrained(
                table: 'assignments',
                indexName: 'assignment_has_submissions'
            );  
            $table->string('title');
            $table->text('note')->nullable();
            $table->string('url');
            $table->string('path');
            $table->enum('status', ['approved', 'pending', 'rejected'])->nullable()->default('pending');
            $table->text('revisionNote')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
