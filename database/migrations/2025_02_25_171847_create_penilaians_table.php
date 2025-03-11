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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('mentor_id');
            $table->unsignedBigInteger('indikator_grup_id');
            $table->unsignedBigInteger('indikator_nilai_id');
            $table->timestamps();
    
            // Foreign key constraints
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mentor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('indikator_grup_id')->references('id')->on('master_indikator_grup')->onDelete('cascade');
            $table->foreign('indikator_nilai_id')->references('id')->on('master_indikator_nilai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
