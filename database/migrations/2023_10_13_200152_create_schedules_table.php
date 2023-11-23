<?php

use App\Enums\ScheduleType;
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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('day_of_week');
            $table->string('hour', 5);
            $table->string('description')->nullable();
            $table->string('professor');
            $table->boolean('active')->default(true);
            // $table->date('event_date')->nullable();
            $table->unsignedSmallInteger('limit')->default(12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
