<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('application_contacts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('membership_application_id')->constrained()->cascadeOnDelete();
            $t->string('role')->nullable();       // Owner, MD, CEO, HR, etc.
            $t->string('first_name')->nullable();
            $t->string('last_name')->nullable();
            $t->string('gender')->nullable();     // Male/Female
            $t->string('phone')->nullable();
            $t->string('email')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_contacts');
    }
};
