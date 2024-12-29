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
        Schema::create('jwt_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('unique_id')->unique()->index();
            $table->string('description');
            $table->longText('client_info')->nullable();
            $table->string('origin')->nullable();
            $table->string('ip_address')->nullable();
            $table->json('abilities')->nullable();
            $table->timestamps();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('last_used_at')->nullable();

            // Foreign key to id column of users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jwt_tokens');
    }
};
