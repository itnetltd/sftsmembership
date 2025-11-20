<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('payments', function (Blueprint $t) {
            if (!Schema::hasColumn('payments','transaction_id')) {
                $t->string('transaction_id')->nullable()->index();
            }
            if (!Schema::hasColumn('payments','reference')) {
                $t->string('reference')->nullable()->index(); // our own ref
            }
            if (!Schema::hasColumn('payments','currency')) {
                $t->string('currency', 10)->default('RWF');
            }
            if (!Schema::hasColumn('payments','amount')) {
                $t->decimal('amount', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('payments','status')) {
                $t->string('status')->default('pending'); // pending|completed|failed|refunded
            }
            if (!Schema::hasColumn('payments','method')) {
                $t->string('method')->nullable(); // card|momo|bank|…
            }
            if (!Schema::hasColumn('payments','paid_at')) {
                $t->timestamp('paid_at')->nullable();
            }
            if (!Schema::hasColumn('payments','meta')) {
                $t->json('meta')->nullable();
            }
        });
    }
    public function down(): void {
        // keep columns (harmless)
    }
};
