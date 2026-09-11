<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('individuals')->onDelete('cascade');
            $table->foreignId('father_id')->nullable()->constrained('individuals')->onDelete('cascade');
            $table->foreignId('mother_id')->nullable()->constrained('individuals')->onDelete('cascade');
            $table->foreignId('marriage_id')->nullable()->constrained('marriages')->onDelete('cascade');
            $table->enum('relationship_type', ['biological', 'adopted', 'step'])->default('biological');
            $table->timestamps();

            $table->unique(['child_id']);
            $table->index(['father_id', 'mother_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
