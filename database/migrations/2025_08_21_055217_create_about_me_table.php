<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_me', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 255);
            $table->text('bio');
            $table->string('profile_image')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->text('skills')->nullable(); // JSON أو نص عادي
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('about_me');
    }
};
