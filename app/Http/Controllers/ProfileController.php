<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Cicle;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $cicles = Cicle::all();
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'cicles' => $cicles
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->disabled = true;
        $user->save();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Set the user Language
     */
    public function setLanguage(Request $request, string $lang)
    {
        if (!in_array($lang, ['ca', 'es', 'en'])) {
            abort(400);
        }

        $user = $request->user();
        $user->language = $lang;
        $user->save();

        App::setLocale($lang);
    }

    public function updatePassword(Request $request)
    {
        if ($request->user()->default_password === 0) {
            return Redirect::route('empresa.index');
        }
        return Inertia::render('Auth/UpdatePassword');
    }

    /**
     * Update the user's password.
     */
    public function updateDefaultPassword(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->default_password === 1) {
            return redirect()->route('empresa.index');
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user->default_password = false;
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('empresa.index')->with('status', 'Password updated successfully.');
    }

}
