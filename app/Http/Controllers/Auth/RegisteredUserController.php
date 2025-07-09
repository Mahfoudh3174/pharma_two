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
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255',"regex:/^[a-zA-Z\s]+$/"],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

        ],[
            'name.regex' => 'Le nom ne doit contenir que des lettres et des espaces.',
            'email.lowercase' => 'L\'email doit être en minuscules.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password' => 'Le mot de passe doit comporter au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
            'name.required' => 'Le nom est requis.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'email.string' => 'L\'email doit être une chaîne de caractères.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('pharmacy.create');
    }
}
