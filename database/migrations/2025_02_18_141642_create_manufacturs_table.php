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
        Schema::create('manufacturs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('license_duration');
            $table->string('license_number');
            $table->date('first_installation_date');
            $table->date('last_installation_date');
            $table->string('notification_period');
            $table->boolean('is_notified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufacturs');
    }
};
