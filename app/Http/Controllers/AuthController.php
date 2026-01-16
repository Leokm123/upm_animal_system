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
        // Step 1: Validate form input (username and password are required)
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // Step 2: Query 3 user tables sequentially to find matching username
        $user = UPMUser::where('name', $request->username)->first();
        if (!$user) {
            $user = Manager::where('name', $request->username)->first();
        }
        if (!$user) {
            $user = Volunteer::where('name', $request->username)->first();
        }

        // Step 3: Verify password (Hash::check matches encrypted password)
        if ($user && Hash::check($request->password, $user->password)) {
            // Choose guard based on user type
            $guard = 'web';
            if ($user instanceof Manager) {
                $guard = 'manager';
            } elseif ($user instanceof Volunteer) {
                $guard = 'volunteer';
            }

            // Log in with the correct guard
            Auth::guard($guard)->login($user);

            // Store user role in session for use in subsequent pages
            session(['user_role' => $this->getUserRole($user)]);

            return redirect()->route('dashboard'); // Redirect to dashboard on successful login
        }

        // Step 4: Login failed, return to login page with error message
        return back()->withErrors([
            'login' => 'Incorrect username or password, please try again'
        ])->withInput(); // Echo back the entered username to improve user experience
    }

    private function getUserRole($user)
    {
        if ($user instanceof Manager) return 'manager';
        if ($user instanceof Volunteer) return 'volunteer';
        if ($user instanceof UPMUser) return 'upm_user';
        return '';
    }

    public function logout()
    {
        // Logout from all possible guards to be safe
        foreach (['web', 'manager', 'volunteer'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }
        session()->flush();
        return redirect('/login')->with('message', 'Successfully logged out!');
    }
}