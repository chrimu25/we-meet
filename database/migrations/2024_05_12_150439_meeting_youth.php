<?php

use App\Models\Meeting;
use App\Models\Youth;
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
        Schema::create('meeting_youth', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Meeting::class)->constrained();
            $table->foreignIdFor(Youth::class)->constrained();
            $table->enum('status', ['Pending', 'Approved'])->default('Pending'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_youth');
    }
};
