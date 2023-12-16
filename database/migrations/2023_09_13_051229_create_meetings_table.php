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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('moto')->nullable();
            $table->longText('description')->nullable();
            $table->string('location');
            $table->string('venue');
            $table->date('meeting_date');
            $table->string('start_time');
            $table->string('end_time');
            $table->foreignId('coordinator_id')->constrained('coordinators');
            $table->string('cover_image');
            $table->text('meeting_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
