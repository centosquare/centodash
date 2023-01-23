<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\User\LoginRequest;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\User\RegisterUserRequest;

class AuthController extends Controller
{
    /**
     * Function to view register page
     * @return View
     */
    public function registerView(): View
    {
        return view('admin.auth.register');
    }

    /**
     * Function to authenticate the user,save the data of the user, and log in
     * @param RegisterUserRequest $request
     * @return RedirectResponse
     */
    public function checkRegister(RegisterUserRequest $request): RedirectResponse
    {
        try {
            $user = User::create($request->validated());

            Auth::attempt($request->only('email', 'password'));

            $user->assignRole(Role::where('name', 'ordinary')->first());

            if ($user) {
                return redirect()->route('user.index')->withSuccess('You have successfully registered');
            } else {
                return back()->withError('Something went wrong !');
            }
        } catch (Exception $ex) {
            return back()->withError('Something went wrong');
        }
    }

    /**
     * Function to view login page
     * @return View
     */
    public function loginView(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Function to authenticate the logged in user
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function userLogin(LoginRequest $request): RedirectResponse
    {
        $validatedUser = $request->validated();

        try {
            if (Auth::attempt($validatedUser)) {
                return redirect()->route('user.index');
            } else {
                return back()->withError('Either the email or the password is incorrect');
            }
        } catch (Exception $ex) {
            return back()->withError('Something went wrong');
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }

    // Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google Callback
    public function handleGoogleCallback()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id', $google_user->getId())->first();
            if (!$user) {
                $newUser = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'avatar' => $google_user->getAvatar(),
                    'google_id' => $google_user->getId(),
                ]);
                Auth::login($newUser);
                return redirect()->route('user.index');
            } else {
                Auth::login($user);
                return redirect()->route('user.index');
            }
        } catch (Exception $e) {
            return back()->withError($e->getMessage());
        }
    }


    // Github login
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    //Github callback
    public function handleGithubCallback()
    {
        try {
            $github_user = Socialite::driver('github')->user();
            $user = User::where('github_id', $github_user->getId())->first();
            if (!$user) {
                $newUser = User::create([
                    'name' => $github_user->getName(),
                    'email' => $github_user->getEmail(),
                    'avatar' => $github_user->getAvatar(),
                    'github_id' => $github_user->getId(),
                ]);
                Auth::login($newUser);
                return redirect()->route('user.index');
            } else {
                Auth::login($user);
                return redirect()->route('user.index');
            }
        } catch (Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    // Facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $facebook_user = Socialite::driver('facebook')->stateless()->user();
        $finduser = User::where('facebook_id', $facebook_user->getId())->first();

        if ($finduser) {
            Auth::login($finduser);
            return redirect()->route('user.index');
        } else {
            $newUser = User::create([
                'name' => $facebook_user->name,
                'email' => $facebook_user->email,
                'facebook_id' => $facebook_user->id,
            ]);
            Auth::login($newUser);
            return redirect()->route('user.index');
        }
    }
}
