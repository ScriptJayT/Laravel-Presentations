<?php

use App\Models\PresentationScript;
use App\Models\PresentationTheme;
use App\Models\PresentationVisibility;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\Flysystem\Visibility;

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
            $table->foreignIdFor(User::class, "creator");
            $table->foreignIdFor(PresentationScript::class)->nullable();
            $table->foreignIdFor(PresentationVisibility::class, "visibility");
            $table->foreignIdFor(PresentationTheme::class, "default_theme");
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
