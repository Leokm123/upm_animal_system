<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UPMUser;
use App\Models\Manager;
use App\Models\Volunteer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = UPMUser::where('name', $request->username)->first();
        $guard = 'web';
        $role = 'upm_user';

        if (!$user) {
            $user = Manager::where('name', $request->username)->first();
            if ($user) { $guard = 'manager'; $role = 'manager'; }
        }
        if (!$user) {
            $user = Volunteer::where('name', $request->username)->first();
            if ($user) { $guard = 'volunteer'; $role = 'volunteer'; }
        }

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::guard($guard)->login($user);
            $request->session()->regenerate();
            session(['user_role' => $role]);
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'login' => 'Incorrect username or password, please try again.',
        ])->withInput();
    }

    public function logout()
    {
        foreach (['web', 'manager', 'volunteer'] as $g) {
            if (Auth::guard($g)->check()) {
                Auth::guard($g)->logout();
            }
        }
        session()->flush();
        return redirect('/login')->with('message', 'Successfully logged out!');
    }
}