<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // TODO: "roles" is een betere naam, omdat "user_roles" kan impliceren dat het om een koppeltabel gaat
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g. "Editor", "Viewer", etc.
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('user_role_id')->nullable()->constrained('user_roles')->cascadeOnDelete();
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