<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
        if (Auth::check()) {

            $user = $request->user() ? $request->user()->only('id', 'name', 'email', 'email_verified_at') : null;

            $user['verified'] = $user['email_verified_at'] ? true : false;
            unset($user['email_verified_at']);

            $role = $request->user() ? $request->user()->role : null;

            $user['role'] = $role->only('id', 'name');

            $previous = $request->session()->get('_previous');
            $errors = $request->session()->get('errors');

            $props = [
                'appName' => config('app.name'),
                'previous' => [
                    'url' => $previous ? $previous['url'] : null,
                ],
                'auth' => [
                    'user' => $user,
                ],
                'flash' => [
                    'message' => $request->session()->get('message'),
                ],
                'debug' => $request->session()->all(),
            ];

            $errors ?? $props['errors'] = $errors;

            return array_merge(parent::share($request), $props);
        }

        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
        ]);
    }
}
