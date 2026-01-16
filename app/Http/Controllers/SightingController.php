<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sighting;
use App\Models\Animal;
use Illuminate\Support\Facades\Auth;

class SightingController extends Controller
{

    /**
     * Constructor: Restrict access to volunteers only
     * Implements custom middleware for multi-guard authentication
     */
    public function __construct()
    {
        // Replace default auth middleware to support multi-guard login verification
        $this->middleware(function ($request, $next) {
            // 1. Check if any guard is logged in
            if (! $this->isAnyGuardLoggedIn()) {
                return redirect()->route('login')->withErrors('Please login to the system first!');
            }

            // 2. Verify user is a volunteer
            $user = $this->getLoggedInUser();
            if ($user instanceof \App\Models\Volunteer) {
                return $next($request);
            }

            return redirect()->route('dashboard')->withErrors('Only volunteers can report sightings!');
        });
    }

    /**
     * Display the animal sighting report form
     * Shows form for volunteers to submit new animal sightings
     */
    public function create()
    {
        return view('sighting.report');
    }

    /**
     * Submit animal sighting record (Core functionality)
     * Processes sighting data and either updates existing animal profile or creates new one
     */
    public function store(Request $request)
    {
        // Validate sighting form input
        $validated = $request->validate([
            'animal_id' => 'nullable|exists:animals,animalId',
            'photo_urls' => 'required|string',
            'location' => 'required|string',
            'sighting_time' => 'required|date',
            'status' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);
        $photoUrls = array_map('trim', explode(',', $validated['photo_urls']));

        // Validate each URL
        foreach ($photoUrls as $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                return back()->withErrors(['photo_urls' => 'All photo URLs must be valid URLs']);
            }
        }

        // Create new sighting record
        $sighting = Sighting::create([
            'sightingId' => 'SIGHT_' . uniqid(), // Generate unique sighting ID
            'animalId' => $validated['animal_id'] ?? 'UNIDENTIFIED', // Link to animal or mark as unidentified
            'sightingTime' => $validated['sighting_time'],
            'location' => $validated['location'],
            'photoUrls' => $photoUrls,
            'status' => $validated['status'] ?? 'healthy', // Default to healthy if not specified
            'notes' => $validated['notes']
        ]);

        // If animal is identified, update its last sighting information
        if (!empty($validated['animal_id'])) {
            Animal::find($validated['animal_id'])->update([
                'last_sighting_time' => $validated['sighting_time'],
                'last_sighting_location' => $validated['location']
            ]);

            return redirect()->route('animal.show', $validated['animal_id'])
                ->with('success', 'Sighting reported successfully! Animal profile updated.');
        }

        // Unidentified animal:  Redirect to create profile page (link current sighting ID)
        return redirect()->route('animal.create', ['initial_sighting_id' => $sighting->sightingId])
            ->with('success', 'Sighting reported successfully!  Please create a profile for the unidentified animal.');
    }

    /**
     * Display all sighting records for the current volunteer
     * Shows historical sighting data submitted by the logged-in volunteer
     */
    public function index()
    {
        $user = $this->getLoggedInUser();

        // TODO: Filter by volunteer if Sighting table has volunteer_id field
        // $sightings = Sighting::where('volunteer_id', $user->id)->get();

        // Currently shows all sighting records (can be filtered by volunteer in future)
        $sightings = Sighting::all();

        return view('sighting.index', compact('sightings'));
    }

    /**
     * Helper method:  Check if any authentication guard has a logged-in user
     * Supports multiple user types (UPMUser, Manager, Volunteer)
     */
    protected function isAnyGuardLoggedIn(): bool
    {
        return Auth::guard('web')->check() ||
            Auth::guard('manager')->check() ||
            Auth::guard('volunteer')->check();
    }

    /**
     * Helper method: Get the currently logged-in user from any guard
     * Returns the user instance regardless of which guard they're authenticated with
     */
    protected function getLoggedInUser()
    {
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->user();
        }
        if (Auth::guard('manager')->check()) {
            return Auth::guard('manager')->user();
        }
        if (Auth::guard('volunteer')->check()) {
            return Auth::guard('volunteer')->user();
        }
        return null;
    }

    // API: Retrieve the latest animal records (AJAX only)
    public function getAnimals()
    {
        $animals = Animal::orderBy('name', 'asc')->get();
        return response()->json($animals); // Return JSON format
    }
}
