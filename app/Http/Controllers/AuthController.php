<?php
// [Required] Namespace: Laravel uses this to locate the controller, omitting it will cause "Class not found" error
namespace App\Http\Controllers;

// [Required] Import dependencies: Missing any of these will cause errors
use Illuminate\Http\Request; // Handle form requests
use App\Models\UPMUser;      // Import UPMUser model
use App\Models\Manager;      // Import Manager model
use App\Models\Volunteer;    // Import Volunteer model
use Illuminate\Support\Facades\Auth; // Laravel built-in authentication
use Illuminate\Support\Facades\Hash; // Password encryption/verification

// Controller class name must match the file name (AuthController) and extend the Controller base class
class AuthController extends Controller
{
    // 1. Handle login submission logic (corresponding to form POST request)
    public function login(Request $request)
    {
        // Step 1: Validate form input (username and password are required)
        $request->validate([
            'username' => 'required|string', // Username is required and must be a string
            'password' => 'required|string'  // Password is required and must be a string
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
            Auth::login($user); // Laravel built-in login, automatically maintains user session
            // Store user role in session for use in subsequent pages
            session(['user_role' => $this->getUserRole($user)]);
            return redirect()->route('dashboard'); // Redirect to dashboard on successful login
        }

        // Step 4: Login failed, return to login page with error message
        return back()->withErrors([
            'login' => 'Incorrect username or password, please try again'
        ])->withInput(); // Echo back the entered username to improve user experience
    }

    // 2. Private method: Determine user role (your existing logic)
    private function getUserRole($user)
    {
        if ($user instanceof Manager) return 'manager';
        if ($user instanceof Volunteer) return 'volunteer';
        if ($user instanceof UPMUser) return 'upm_user';
        return '';
    }

    // 3. Handle logout logic (optional, recommended)
    public function logout()
    {
        Auth::logout(); // Clear login state
        session()->flush(); // Clear session
        return redirect('/login')->with('message', 'Successfully logged out!');
    }
}