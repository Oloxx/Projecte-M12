<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

use App\Models\Cicle;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $cicles = Cicle::all();
        return Inertia::render('Auth/Register', ['cicles' => $cicles]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cognoms' => 'required|string|max:255',
            'cicle_id' => 'required',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        $user = User::create([
            'name' => $request->name,
            'cognoms' => $request->cognoms,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => 2,
            'cicle_id' => $request->cicle_id
        ]);

        // Send e-mail to new user:

        $email = $request->email;

        $data = ([
            'name' => $request->name,
            'cognoms' => $request->cognoms,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        Mail::to($email)->send(new WelcomeMail($data));

        event(new Registered($user));

        //Auth::login($user);

        return redirect()->route('empresa.index')->with('status', 'Nou usuari ' . $user->name . ' creat!');
    }
}
