<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();

            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();

            $table->time('monday_starts_at')->nullable();
            $table->time('monday_ends_at')->nullable();

            $table->time('tuesday_starts_at')->nullable();
            $table->time('tuesday_ends_at')->nullable();

            $table->time('wednesday_starts_at')->nullable();
            $table->time('wednesday_ends_at')->nullable();

            $table->time('thursday_starts_at')->nullable();
            $table->time('thursday_ends_at')->nullable();

            $table->time('friday_starts_at')->nullable();
            $table->time('friday_ends_at')->nullable();

            $table->time('sarturday_starts_at')->nullable();
            $table->time('sarturday_ends_at')->nullable();

            $table->time('sunday_starts_at')->nullable();
            $table->time('sunday_ends_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
