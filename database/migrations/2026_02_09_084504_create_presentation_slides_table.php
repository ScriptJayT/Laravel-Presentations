<?php

use App\Models\Presentation;
use App\Models\PresentationTheme;
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
        Schema::create('presentation_slides', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Presentation::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->integer('order');
            $table->foreignIdFor(PresentationTheme::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentation_slides');
    }
};
