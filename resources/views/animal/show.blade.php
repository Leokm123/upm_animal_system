<! DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Dynamic page title using animal name or default -->
    <title>{{ $animal->name ?? 'Animal Profile' }}</title>
    <style>
        .container { width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        .info-item { margin-bottom: 15px; }
        .label { font-weight: bold; display: inline-block; width: 120px; }
        .photo { margin: 10px 0; max-width: 200px; height: auto; }
        .btn { display: inline-block; padding: 8px 16px; margin-right: 10px; margin-bottom: 10px; background: #2196F3; color: white; text-decoration: none; border-radius: 4px; }
        .btn-edit { background: #FFC107; }
        .btn-back { background: #6c757d; }
        .success { color: green; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Main page heading -->
        <h2>Animal Profile Details</h2>
        
        <!-- Success message display -->
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <!-- Animal Profile ID -->
        <div class="info-item">
            <span class="label">Profile ID:</span>
            <span>{{ $animal->animalId }}</span>
        </div>
        
        <!-- Species information -->
        <div class="info-item">
            <span class="label">Species:</span>
            <span>{{ $animal->species }}</span>
        </div>
        
        <!-- Gender with translation -->
        <div class="info-item">
            <span class="label">Gender:</span>
            <span>{{ $animal->gender == 'male' ?  'Male' : ($animal->gender == 'female' ? 'Female' : 'Unknown') }}</span>
        </div>
        
        <!-- Estimated age -->
        <div class="info-item">
            <span class="label">Estimated Age:</span>
            <span>{{ $animal->estimatedAgeYears }} years</span>
        </div>
        
        <!-- Color information -->
        <div class="info-item">
            <span class="label">Color:</span>
            <span>{{ $animal->color }}</span>
        </div>
        
        <!-- Size with translation -->
        <div class="info-item">
            <span class="label">Size:</span>
            <span>{{ $animal->size == 'small' ? 'Small' : ($animal->size == 'medium' ?  'Medium' : 'Large') }}</span>
        </div>
        
        <!-- Distinctive markings -->
        <div class="info-item">
            <span class="label">Markings:</span>
            <span>{{ $animal->markings }}</span>
        </div>
        
        <!-- Photo gallery section -->
        <div class="info-item">
            <span class="label">Photos:</span>
            <br>
            @foreach($animal->photoUrls as $photoUrl)
                <img src="{{ $photoUrl }}" class="photo" alt="Animal Photo">
            @endforeach
        </div>
        
        <!-- Last sighting information -->
        <div class="info-item">
            <span class="label">Last Sighting:</span>
            <span>{{ $animal->last_sighting_time->format('Y-m-d H:i') }} ({{ $animal->last_sighting_location }})</span>
        </div>
        
        <!-- Current status -->
        <div class="info-item">
            <span class="label">Status:</span>
            <span>{{ $animal->status ?? 'None' }}</span>
        </div>

        <!-- Action buttons -->
        <a href="{{ route('dashboard') }}" class="btn btn-back">← Back to Dashboard</a>
        <a href="{{ route('animal.edit', $animal->animalId) }}" class="btn btn-edit">Edit Profile</a>
        <a href="{{ route('sighting.create') }}" class="btn">Report New Sighting</a>
    </div>
</body>
</html>