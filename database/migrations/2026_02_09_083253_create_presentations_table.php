<?php

use App\Models\PresentationScript;
use App\Models\PresentationTheme;
use App\Models\PresentationVisibility;
use App\Models\User;
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
        Schema::create('presentations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("title");
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(PresentationScript::class)->nullable();
            $table->foreignIdFor(PresentationVisibility::class)->constrained();
            $table->foreignIdFor(PresentationTheme::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentations');
    }
};
