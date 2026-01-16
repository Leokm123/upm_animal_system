<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * System Dashboard (Multi-Guard Login Support)
     */
    public function dashboard()
    {
        // Check multi-guard login status
        if (!$this->isAnyGuardLoggedIn()) {
            return redirect()->route('login')->withErrors('Please login first!');
        }
        // Get current user and set role to session
        $user = $this->getLoggedInUser();
        session(['user_role' => $this->getUserRole($user)]);
        
        return view('dashboard');
    }
}