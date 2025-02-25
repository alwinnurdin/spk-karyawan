<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Models\Score;
use App\Models\User;
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
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
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => fn() => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'flash' => [
                'message' => fn() => $request->session()->get('message'),
                'refresh' => fn() => $request->session()->get('refresh')
            ],
            'data' => fn() => [
                'alternative' => User::all(),
                'criteria' => Criteria::all(),
                'subcriteria' => SubCriteria::all(),
                'score' => Score::all(),
            ]
        ];
    }
}
