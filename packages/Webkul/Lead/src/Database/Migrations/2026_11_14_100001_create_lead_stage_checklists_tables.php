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
        if (! Schema::hasTable('lead_stage_checklists')) {
            Schema::create('lead_stage_checklists', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('lead_pipeline_stage_id')->unsigned();
                $table->string('name');
                $table->text('description')->nullable();
                $table->boolean('is_required')->default(false);
                $table->integer('sort_order')->default(0);
                $table->timestamps();

                $table->foreign('lead_pipeline_stage_id')
                    ->references('id')
                    ->on('lead_pipeline_stages')
                    ->onDelete('cascade');
            });
        }

        if (! Schema::hasTable('lead_stage_checklist_completions')) {
            Schema::create('lead_stage_checklist_completions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('lead_id')->unsigned();
                $table->integer('lead_stage_checklist_id')->unsigned();
                $table->boolean('is_completed')->default(true);
                $table->integer('completed_by_user_id')->unsigned()->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();

                $table->foreign('lead_id')
                    ->references('id')
                    ->on('leads')
                    ->onDelete('cascade');

                $table->foreign('lead_stage_checklist_id')
                    ->references('id')
                    ->on('lead_stage_checklists')
                    ->onDelete('cascade');

                $table->foreign('completed_by_user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null');

                $table->unique(['lead_id', 'lead_stage_checklist_id'], 'lead_checklist_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_stage_checklist_completions');
        Schema::dropIfExists('lead_stage_checklists');
    }
};
