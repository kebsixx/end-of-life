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
            $table->string('product-name');
            $table->string('license-duration');
            $table->string('license-number');
            $table->string('first-installation-date');
            $table->string('last-installation-date');
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
