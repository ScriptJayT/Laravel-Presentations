<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface ModelHasUserVisibilityRules
{
    public function presentationVisibility(): BelongsTo;

    public function user(): BelongsTo;
}
