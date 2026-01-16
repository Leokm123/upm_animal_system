<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Sighting Records</title>
    <style>
        .container { width: 800px; margin: 50px auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        table { width: 100%; border-collapse:  collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background:  #f5f5f5; }
        .btn { display: inline-block; padding: 8px 16px; background: #2196F3; color: white; text-decoration: none; border-radius: 4px; }
        .btn-back { display: inline-block; padding: 10px 20px; background: #757575; color:  white; text-decoration: none; border-radius: 4px; margin-bottom: 20px; }
        .btn-back:hover { background: #616161; }
        .success { color: green; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back to Dashboard button -->
        <a href="{{ route('dashboard') }}" class="btn-back">⬅ Back to Dashboard</a>
        
        <!-- Page header with title -->
        <h2>My Sighting Records</h2>
        
        <!-- Button to create new sighting report -->
        <a href="{{ route('sighting.create') }}" class="btn">Report New Sighting</a>
        
        <!-- Display success message if available -->
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <!-- Sightings data table -->
        <table>
            <thead>
                <tr>
                    <th>Sighting ID</th>
                    <th>Animal</th>
                    <th>Location</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through all sightings -->
                @foreach($sightings as $sighting)
                <tr>
                    <td>{{ $sighting->sightingId }}</td>
                    <td>
                        <!-- Check if animal is identified or unidentified -->
                        @if($sighting->animalId != 'UNIDENTIFIED')
                            <!-- Link to animal profile if identified -->
                            <a href="{{ route('animal. show', $sighting->animalId) }}">
                                {{ $sighting->animal->name ??  'Animal Profile' }}
                            </a>
                        @else
                            <!-- Show unidentified status with create profile link -->
                            Unidentified (<a href="{{ route('animal.create', ['initial_sighting_id' => $sighting->sightingId]) }}">Create Profile</a>)
                        @endif
                    </td>
                    <td>{{ $sighting->location }}</td>
                    <td>{{ $sighting->sightingTime->format('Y-m-d H:i') }}</td>
                    <td>{{ $sighting->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>