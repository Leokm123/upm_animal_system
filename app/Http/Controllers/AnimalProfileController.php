<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Sighting;
use Illuminate\Support\Facades\Auth;

class AnimalProfileController extends Controller {
    // Constructor: Only volunteers can access (permission control)
   public function __construct() {
        // Replace default auth middleware, compatible with multi-guard login check
        $this->middleware(function ($request, $next) {
            // 1. Check if any guard is logged in
            if (!$this->isAnyGuardLoggedIn()) {
                return redirect()->route('login')->withErrors('Please login to the system first!');
            }
            // 2. Check if user is a volunteer
            $user = $this->getLoggedInUser();
            if ($user instanceof \App\Models\Volunteer) {
                return $next($request);
            }
            return redirect()->route('dashboard')->withErrors('Only volunteers can manage animal profiles!');
        });
    }

    // 1. Animal profile query matching (match existing profiles based on sighting data)
    public function matchProfiles(Request $request) {
        $sightingData = $request->validate([
            'photo_urls' => 'required|array|min:1',
            'location' => 'required|string',
            'color' => 'required|string',
            'markings' => 'nullable|string',
            'species' => 'nullable|string'
        ]);

        // Convert location to coordinates (simplified implementation: simulate lat/lng, can integrate map API)
        $sightingCoords = $this->convertLocationToCoords($sightingData['location']);

        // Query potential matches: same species + similar color + within 1km
        $potentialMatches = Animal::where(function ($query) use ($sightingData) {
            if (!empty($sightingData['species'])) {
                $query->where('species', $sightingData['species']);
            }
            $query->where('color', 'LIKE', "%{$sightingData['color']}%");
        })->get()->filter(function ($animal) use ($sightingCoords) {
            $animalCoords = $this->convertLocationToCoords($animal->last_sighting_location);
            $distance = $this->calculateDistance($sightingCoords, $animalCoords);
            return $distance < 1; // Match within 1km
        });

        // Calculate feature similarity and sort results
        $matchedProfiles = $potentialMatches->map(function ($animal) use ($sightingData) {
            $similarity = 70; // Base similarity for color + location
            if (!empty($sightingData['markings']) && !empty($animal->markings)) {
                $markingSimilarity = $this->calculateMarkingSimilarity($sightingData['markings'], $animal->markings);
                $similarity += $markingSimilarity;
            }
            return [
                'animal_id' => $animal->animalId,
                'name' => $animal->name ?? 'Unnamed',
                'photo_url' => $animal->photoUrls[0] ?? '',
                'similarity' => min($similarity, 100),
                'last_sighting' => $animal->last_sighting_time->format('Y-m-d H:i')
            ];
        })->sortByDesc('similarity');

        return response()->json(['matched_profiles' => $matchedProfiles]);
    }

    // 2. Create new animal profile
    public function createProfile(Request $request) {
        $validated = $request->validate([
            'species' => 'required|string',
            'gender' => 'required|in:male,female,unknown',
            'estimated_age_years' => 'required|integer|min:0',
            'color' => 'required|string',
            'size' => 'required|in:small,medium,large',
            'markings' => 'required|string',
            'photo_urls' => 'required|string', 
            'initial_sighting_id' => 'required|exists:sightings,sightingId'
    ]);
        $photoUrls = array_map('trim', explode(',', $validated['photo_urls']));
    
    // Validate each URL
        foreach ($photoUrls as $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                return back()->withErrors(['photo_urls' => 'All photo URLs must be valid URLs']);
            }
        }
        // Get initial sighting record
        $initialSighting = Sighting::findOrFail($validated['initial_sighting_id']);

        // Create animal profile
        $animal = Animal::create([
            'animalId' => 'ANIMAL_' . uniqid(),
            'species' => $validated['species'],
            'gender' => $validated['gender'],
            'estimatedAgeYears' => $validated['estimated_age_years'],
            'color' => $validated['color'],
            'size' => $validated['size'],
            'markings' => $validated['markings'],
            'photoUrls' => $photoUrls,
            'last_sighting_time' => $initialSighting->sightingTime,
            'last_sighting_location' => $initialSighting->location
        ]);

        // Associate initial sighting record with new profile
        $initialSighting->update(['animalId' => $animal->animalId]);

        return redirect()->route('animal.show', $animal->animalId)
            ->with('success', 'Animal profile created successfully!');
    }

    // 3. Update existing animal profile
    public function updateProfile(Request $request, $animalId) {
        $animal = Animal::findOrFail($animalId);

        $validated = $request->validate([
            'species' => 'nullable|string',
            'gender' => 'nullable|in:male,female,unknown',
            'estimated_age_years' => 'nullable|integer|min:0',
            'color' => 'nullable|string',
            'size' => 'nullable|in:small,medium,large',
            'markings' => 'nullable|string',
            'photo_urls' => 'nullable|string',
            'status' => 'nullable|string'
        ]);
        // Process photo_urls (if provided).
        if (! empty($validated['photo_urls'])) {
            $photoUrls = array_map('trim', explode(',', $validated['photo_urls']));
        
            // Validate each URL
            foreach ($photoUrls as $url) {
                if (! filter_var($url, FILTER_VALIDATE_URL)) {
                    return back()->withErrors(['photo_urls' => 'All photo URLs must be valid URLs']);
                }
            }
        }
        $validated['photo_urls'] = $photoUrls;
    }

    // 4. View single animal profile
    public function show($animalId) {
        $animal = Animal::findOrFail($animalId);
        return view('animal.show', compact('animal'));
    }

    // Helper method: Convert location to coordinates (simplified simulation)
    private function convertLocationToCoords($location) {
        // In real projects, integrate Amap/Google Maps API, here we simulate lat/lng
        $locationHash = crc32($location);
        $lat = 2.5 + ($locationHash % 10) / 10; // Simulate latitude (2.5-3.5)
        $lng = 101.5 + ($locationHash % 10) / 10; // Simulate longitude (101.5-102.5)
        return ['lat' => $lat, 'lng' => $lng];
    }

    // Helper method: Calculate distance between two points (Haversine formula, unit: km)
    private function calculateDistance($coords1, $coords2) {
        $R = 6371; // Earth radius (km)
        $dLat = deg2rad($coords2['lat'] - $coords1['lat']);
        $dLng = deg2rad($coords2['lng'] - $coords1['lng']);
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($coords1['lat'])) * cos(deg2rad($coords2['lat'])) *
             sin($dLng/2) * sin($dLng/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $R * $c; // Distance (km)
    }

    // Helper method: Feature similarity calculation (simplified: string matching)
    private function calculateMarkingSimilarity($sightingMarkings, $animalMarkings) {
        similar_text(strtolower($sightingMarkings), strtolower($animalMarkings), $percent);
        return min($percent / 10, 30); // Similarity score 0-30 points
    }
}