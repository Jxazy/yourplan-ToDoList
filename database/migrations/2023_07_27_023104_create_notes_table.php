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
        Schema::create('notes', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('title', 100);
            $table->text('content');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('deadline')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign('users_id_foreign');
            
            
        });
        Schema::dropIfExists('table');
        
    }
};
