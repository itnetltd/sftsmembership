<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_applications', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->enum('status', ['pending','approved','rejected'])->default('pending');
            $t->string('company_name');
            $t->string('sector')->nullable();
            $t->string('location')->nullable();
            $t->string('company_website')->nullable();
            $t->text('products_services')->nullable();
            $t->timestamp('submitted_at')->nullable();
            $t->text('admin_notes')->nullable();
            $t->timestamps();

           // Use short, explicit names to avoid MySQL's 64-char limit
$t->index(['status', 'company_name'], 'ma_status_company_idx');
$t->index(['sector', 'location'], 'ma_sector_location_idx');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_applications');
    }
};
