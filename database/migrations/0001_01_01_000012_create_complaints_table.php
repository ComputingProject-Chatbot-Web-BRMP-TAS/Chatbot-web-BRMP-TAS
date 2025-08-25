<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->foreignId('transaction_id')->constrained('transactions', 'transaction_id')->onDelete('cascade');
            $table->id('complaint_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->bigInteger('nomor_kantong')->nullable();
            $table->string('complaint_types');
            $table->text('description');
            $table->string('photo_proof');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('complaints');
    }
}; 