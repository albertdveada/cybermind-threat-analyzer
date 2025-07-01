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
        Schema::create('analyze_login', function (Blueprint $table) {
            $table->id();
            $table->string('client_id', 10)->index();
            $table->string('ip_address')->nullable()->index();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('username')->nullable()->index();
            $table->enum('status', ['success', 'failed', 'none'])->default('none')->index();
            $table->text('user_agent')->nullable();
            $table->string('device')->nullable();
            $table->string('platform')->nullable();
            $table->string('browser')->nullable();
            $table->string('login_method')->nullable();
            $table->string('session_id')->nullable();
            $table->timestamps();
            $table->index('created_at');
            
            $table->foreign('client_id')->references('client_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyze_login');
    }
};
