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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meet_id')->constrained(
                table: 'meets',
                indexName: 'meet_has_presences'
            );  
            $table->foreignId('registration_id')->constrained(
                table: 'registrations',
                indexName: 'registration_has_presences'
            );
            $table->dateTime('dateTime');
            $table->enum('status', ['approved', 'pending', 'rejected'])->nullable()->default('pending');
            $table->string('proofUrl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
