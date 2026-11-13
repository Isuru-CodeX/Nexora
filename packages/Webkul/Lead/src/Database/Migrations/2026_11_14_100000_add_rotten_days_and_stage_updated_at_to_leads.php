<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('lead_pipeline_stages', 'rotten_days')) {
            Schema::table('lead_pipeline_stages', function (Blueprint $table) {
                $table->integer('rotten_days')->nullable()->after('sort_order');
            });
        }

        if (! Schema::hasColumn('leads', 'stage_updated_at')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->timestamp('stage_updated_at')->nullable()->after('lead_pipeline_stage_id');
            });

            // Populate stage_updated_at for existing leads
            DB::table('leads')
                ->whereNull('stage_updated_at')
                ->update(['stage_updated_at' => DB::raw('created_at')]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('lead_pipeline_stages', 'rotten_days')) {
            Schema::table('lead_pipeline_stages', function (Blueprint $table) {
                $table->dropColumn('rotten_days');
            });
        }

        if (Schema::hasColumn('leads', 'stage_updated_at')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->dropColumn('stage_updated_at');
            });
        }
    }
};
