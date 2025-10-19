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
        Schema::create('doc_embeddings', function (Blueprint $table) {
            $table->id('embedding_id');
            $table->string('source_table',32);
            $table->unsignedBigInteger('source_id');
            $table->text('chunk');
            $table->json('embedding');
            $table->timestamps();
            $table->index(['source_table', 'source_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_embeddings',function (Blueprint $table) {
            $table->dropColumn('embedding_id');
        });
    }
};
