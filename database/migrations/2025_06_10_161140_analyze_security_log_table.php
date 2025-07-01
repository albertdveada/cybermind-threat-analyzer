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
        Schema::create('analyze_security', function (Blueprint $table) {
            $table->id();
            $table->string('client_id', 10)->index();
            $table->enum('status', ['triggered', 'resolved'])->default('triggered')->index();
            $table->string('type')->index();
            $table->string('source_ip')->nullable()->index();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->enum('security_level', ['none', 'low', 'medium', 'high', 'critical'])->default('none')->index();
            $table->text('log_message');
            $table->string('source')->nullable();
            $table->string('tag')->nullable();
            $table->string('platform')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->index('created_at');

            $table->foreign('client_id')->references('client_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analyze_security');
    }
};
