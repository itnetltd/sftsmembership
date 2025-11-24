<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('membership_applications', function (Blueprint $table) {
            // Drop PSF-specific / unused fields
            $table->dropColumn([
                'fax',
                'po_box',
                'street',
                'building',
                'quartier',
                'province',
                'district',
                'sector_admin',
                'cell',
                'company_type',
                'ownership',
                'business_activity',
                'business_activity_detail',
                'export_import',
                'export_import_countries',
                'employees_perm',
                'employees_part',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('membership_applications', function (Blueprint $table) {
            // Recreate columns as nullable in case of rollback
            $table->string('fax')->nullable();
            $table->string('po_box')->nullable();
            $table->string('street')->nullable();
            $table->string('building')->nullable();
            $table->string('quartier')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('sector_admin')->nullable();
            $table->string('cell')->nullable();

            $table->string('company_type')->nullable();
            $table->string('ownership')->nullable();
            $table->string('business_activity')->nullable();
            $table->text('business_activity_detail')->nullable();
            $table->text('export_import')->nullable();
            $table->text('export_import_countries')->nullable();
            $table->string('employees_perm')->nullable();
            $table->string('employees_part')->nullable();
        });
    }
};
