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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('status_payment')->nullable()->after('status');
        });

        // Copy data from status to status_payment
        DB::statement('UPDATE payments SET status_payment = status WHERE status_payment IS NULL');

        // Drop the old status column
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('status')->nullable()->after('status_payment');
        });

        // Copy data back
        DB::statement('UPDATE payments SET status = status_payment WHERE status IS NULL');

        // Drop the new column
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('status_payment');
        });
    }
};
