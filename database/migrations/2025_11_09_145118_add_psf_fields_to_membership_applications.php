<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('membership_applications', function (Blueprint $t) {
            // Membership block
            $t->string('membership_type')->nullable();
            $t->string('chamber')->nullable();
            $t->string('association')->nullable();
            $t->string('cluster_name')->nullable();

            // Registration block
            $t->string('registration_type')->nullable();
            $t->string('registration_number')->nullable();

            // Contacts & address for company
            $t->string('phone')->nullable();
            $t->string('fax')->nullable();
            $t->string('po_box')->nullable();

            // If you want to make an existing column nullable, you need doctrine/dbal.
            // Comment the next line if you don't have it installed.
            // $t->string('company_website')->nullable()->change();

            $t->string('street')->nullable();
            $t->string('building')->nullable();
            $t->string('quartier')->nullable();

            // Location (detailed administrative units)
            $t->string('province')->nullable();
            $t->string('district')->nullable();
            $t->string('sector_admin')->nullable();
            $t->string('cell')->nullable();

            // Company profile
            $t->string('company_type')->nullable();
            $t->string('ownership')->nullable();
            $t->string('business_activity')->nullable();
            $t->text('business_activity_detail')->nullable();
            $t->text('export_import')->nullable();
            $t->text('export_import_countries')->nullable();

            // Employees (label ranges)
            $t->string('employees_perm')->nullable();
            $t->string('employees_part')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('membership_applications', function (Blueprint $t) {
            $t->dropColumn([
                'membership_type','chamber','association','cluster_name',
                'registration_type','registration_number',
                'phone','fax','po_box','street','building','quartier',
                'province','district','sector_admin','cell',
                'company_type','ownership','business_activity','business_activity_detail',
                'export_import','export_import_countries',
                'employees_perm','employees_part',
            ]);
        });
    }
};
