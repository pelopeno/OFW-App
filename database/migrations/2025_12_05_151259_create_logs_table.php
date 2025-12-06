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
    Schema::create('logs', function (Blueprint $table) {
        $table->id(); // LOG ID
        $table->unsignedBigInteger('user_id'); // USER ID
        $table->string('action_type'); // ACTION TYPE
        $table->text('remarks'); // REMARKS
        $table->timestamps(); // created_at = TIMESTAMP

        // Optional: foreign key if users table exists
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
