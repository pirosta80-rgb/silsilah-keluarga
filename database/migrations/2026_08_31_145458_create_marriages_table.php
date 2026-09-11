<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marriages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('husband_id')->constrained('individuals')->onDelete('cascade');
            $table->foreignId('wife_id')->constrained('individuals')->onDelete('cascade');
            $table->date('marriage_date')->nullable();
            $table->date('divorce_date')->nullable();
            $table->string('marriage_place')->nullable();
            $table->enum('status', ['married', 'divorced', 'widowed'])->default('married');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['husband_id', 'wife_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marriages');
    }
};
