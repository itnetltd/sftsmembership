<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Add JSON meta if missing / or convert text to json
            if (!Schema::hasColumn('payments', 'meta')) {
                $table->json('meta')->nullable()->after('status');
            } else {
                // If meta exists but is not json, you can switch it:
                // $table->json('meta')->nullable()->change();
            }

            // Optional, used by admin search/export
            if (!Schema::hasColumn('payments', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('method');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Rollback cautiously (keep columns if used)
            // $table->dropColumn(['meta', 'transaction_id']);
        });
    }
};
