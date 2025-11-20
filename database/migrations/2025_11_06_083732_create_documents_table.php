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
        Schema::create('documents', function (Blueprint $t) {
            $t->id();
            $t->foreignId('membership_application_id')
              ->constrained('membership_applications')
              ->cascadeOnDelete();
            $t->string('type');          // 'RDB_certificate','TIN','ID_copy'
            $t->string('path');          // storage path
            $t->string('original_name');
            $t->string('mime')->nullable();
            $t->unsignedBigInteger('size')->nullable();
            $t->timestamps();

            // optional: uncomment if you want this index
            // $t->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
