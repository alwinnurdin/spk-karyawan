<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{

    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'dob' => ['required','date'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $lastAlternative = User::latest('id')->first();
        $lastId = $lastAlternative ? $lastAlternative->id : 0;
        $formData['alternative_name'] = 'A' . ($lastId + 1);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob, 'password' => Hash::make($request->string('password')),
            'alternative_name' => 'A' . ($lastId + 1),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
