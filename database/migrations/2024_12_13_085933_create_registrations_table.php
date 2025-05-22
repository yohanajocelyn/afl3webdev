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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('paymentProof')->nullable();
            $table->boolean('isApproved')->nullable()->default(false);
            $table->enum('courseStatus', ['assigned', 'finished']);
            $table->foreignId('teacher_id')->constrained(
                table: 'teachers',
                indexName:'registering_teacher_id'
            );
            $table->foreignId('workshop_id')->constrained(
                table: 'workshops',
                indexName:'workshop_registered_id'
            );
            // $table->string('certificateUrl')->default("");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
