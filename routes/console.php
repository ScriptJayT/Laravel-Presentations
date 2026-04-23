<?php

use App\Tasks\RefreshBotUsers;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::call(new RefreshBotUsers)
    ->name('refresh bot user params')
    ->withoutOverlapping()
    ->everyOddHour();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
