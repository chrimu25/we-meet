<?php

use App\Enums\SpeakerCategory;
use App\Models\Meeting;
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
        Schema::create('speakers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Meeting::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('type')->default(SpeakerCategory::GUEST->value);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speakers');
    }
};
