<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToPackagesTable extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            if (!Schema::hasColumn('packages', 'image')) {
                $table->string('image')->nullable()->after('max_guests');
            }

            if (!Schema::hasColumn('packages', 'amenities')) {
                $table->text('amenities')->nullable()->after('image');
            }

            if (!Schema::hasColumn('packages', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('amenities');
            }
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            if (Schema::hasColumn('packages', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('packages', 'amenities')) {
                $table->dropColumn('amenities');
            }

            if (Schema::hasColumn('packages', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
}