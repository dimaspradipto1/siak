<?php

namespace App\Traits;

trait AuthorizeTransactionData
{
    public static function middleware(): array
    {
        return [
            function ($request, $next) {
                $user = auth()->user();
                if ($user && in_array($user->roles, ['siswa', 'orang tua'])) {
                    $action = $request->route()->getActionMethod();
                    if (in_array($action, ['create', 'store', 'edit', 'update', 'destroy', 'import', 'template', 'export'])) {
                        abort(403, 'Anda tidak memiliki akses (Read-Only).');
                    }
                }
                return $next($request);
            }
        ];
    }
}
