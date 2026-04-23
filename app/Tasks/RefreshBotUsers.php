<?php

namespace App\Tasks;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RefreshBotUsers
{
    public function __invoke()
    {
        $res = User::whereHas('roles', fn ($q) => $q->where('roles.name', 'Bot'))
            ->update(['password' => Hash::make(uniqid())]);
        if ($res < 1) {
            echo 'No bot users updated?';
        }
    }
}
