<?php

namespace App\Tasks;

use App\Models\User;

class RefreshBotUsers
{
    public function __invoke()
    {
        // User::where('type', '=', 'bot');
        var_dump('test');
    }
}
