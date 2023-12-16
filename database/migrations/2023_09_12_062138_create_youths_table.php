<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('youths', function (Blueprint $table) {
            $table->id();   
            $table->string('phone')->unique();
            $table->string('national_id')->unique();
            $table->date('date_of_birth')->nullable();
            $table->string('province');
            $table->string('district');
            $table->string('sector');
            $table->string('cell')->nullable();
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youths');
    }
};
