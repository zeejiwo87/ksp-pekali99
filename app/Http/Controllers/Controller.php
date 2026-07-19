<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

abstract class Controller
{
    protected function authorizeRoles(array $roles): ?RedirectResponse
    {
        $user = auth()->user();

        if (! $user || ! in_array($user->role, $roles)) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        return null;
    }

    protected function denyPimpinan(): ?RedirectResponse
    {
        if (auth()->user()?->role === 'pimpinan') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        return null;
    }
}
