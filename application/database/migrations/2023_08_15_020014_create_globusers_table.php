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
        Schema::create('globusers', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('admin_type',255)->default('admin');
            $table->string('name');
            $table->string('password');
            $table->string('email')->nullable();
            $table->string('mobile_number');
            $table->string('user_image')->nullable();
            $table->string('setup_done',5)->default('no');
            $table->string('is_secret',5)->default('no');
            $table->string('reset_code',7)->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->json('user_access')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('globusers');
    }
};