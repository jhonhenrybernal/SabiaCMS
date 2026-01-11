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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('content');              // mensaje principal
            $table->string('author')->nullable(); // lo que estaba entre ()
            $table->string('language', 5);         // es, en, fr, it
            $table->string('source')->nullable();  // opcional: proverbio, biblia, etc
            $table->timestamps();

            $table->index('language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
