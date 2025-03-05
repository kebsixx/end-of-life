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
        Schema::create('versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('version_name');
            $table->string('version_number');
            $table->date('release_date');
            $table->date('expiry_date');
            $table->text('version_description');
            $table->string('progress')->nullable();
            $table->boolean('notify_90_days')->default(false);
            $table->boolean('notify_30_days')->default(false);
            $table->boolean('notify_7_days')->default(false);
            $table->boolean('is_notified_90')->default(false);
            $table->boolean('is_notified_30')->default(false);
            $table->boolean('is_notified_7')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versions');
    }
};
