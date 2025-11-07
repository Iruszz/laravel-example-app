<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g. "Editor", "Viewer", etc.
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('user_role_id')->nullable()->constrained('user_roles')->cascadeOnDelete();
            $table->string('phone')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_role_id']);
            $table->dropColumn(['user_role_id', 'phone']);
        });

        Schema::dropIfExists('user_roles');
    }
};