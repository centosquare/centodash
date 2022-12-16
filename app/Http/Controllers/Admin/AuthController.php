<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

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
}
