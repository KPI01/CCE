<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'root';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user() ? $request->user()->only('id', 'name', 'email', 'email_verified_at') : null;

        $role = $request->user() ? $request->user()->role : null;

        $user['role'] = $role;

        $session = $request->session()->all();
        foreach ($session as $key => $value) {
            if (str_starts_with($key, '_') || str_contains($key, 'login_web')) {
                unset($session[$key]);
            }
        }

        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'auth' => [
                'user' => $user,
            ],
            'session' => $session,
        ]);
    }
}
