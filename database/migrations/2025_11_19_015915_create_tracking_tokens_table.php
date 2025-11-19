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
        Schema::create('tracking_tokens', function (Blueprint $table) {
             $table->uuid('id')->primary();
        $table->uuid('website_id');
        $table->string('token')->unique();
        $table->boolean('active')->default(true);
        $table->timestamps();

        $table->foreign('website_id')
            ->references('id')
            ->on('websites')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_tokens');
    }
};
