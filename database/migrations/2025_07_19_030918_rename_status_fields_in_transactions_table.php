<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('status_order')->nullable()->after('status');
        });

        // Copy data from status to status_order
        DB::statement('UPDATE transactions SET status_order = status WHERE status_order IS NULL');

        // Drop the old status column
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('status')->nullable()->after('status_order');
        });

        // Copy data back
        DB::statement('UPDATE transactions SET status = status_order WHERE status IS NULL');

        // Drop the new column
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('status_order');
        });
    }
};
