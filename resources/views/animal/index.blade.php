<! DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Animal Profiles</title>
    <style>
        body { padding: 20px; font-family: Arial; }
        .container { width: 900px; margin: 0 auto; }
        .btn-back { display: inline-block; padding: 10px 20px; background: #757575; color: white; text-decoration: none; border-radius:  4px; margin-bottom: 20px; }
        .btn-back:hover { background: #616161; }
        h2 { color: #333; margin-bottom: 20px; }
        .success { color: green; margin-bottom: 15px; padding: 10px; background: #e8f5e9; border-radius: 4px; }
        
        /* Table styling */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background:  #2196F3; color: white; }
        tr:hover { background:  #f5f5f5; }
        
        /* Action button styling */
        .btn-edit { 
            display: inline-block; 
            padding: 6px 12px; 
            background: #FFC107; 
            color:  #333; 
            text-decoration: none; 
            border-radius: 4px; 
            margin-right: 5px;
        }
        .btn-edit:hover { background: #FFA000; }
        .btn-view { 
            display: inline-block; 
            padding: 6px 12px; 
            background: #2196F3; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
        }
        .btn-view:hover { background: #1976D2; }
        
        /* Empty state */
        .empty-state { 
            text-align: center; 
            padding: 40px; 
            color: #666; 
            background: #f9f9f9; 
            border-radius: 8px; 
            margin-top: 20px;
        }
        
        /* Photo thumbnail */
        .photo-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back to Dashboard button -->
        <a href="{{ route('dashboard') }}" class="btn-back">← Back to Dashboard</a>
        
        <h2>🐾 Manage Animal Profiles</h2>
        
        <!-- Display success message if exists -->
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($animals->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Profile ID</th>
                        <th>Species</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Last Sighting</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($animals as $animal)
                    <tr>
                        <td>
                            @if($animal->photoUrls && count($animal->photoUrls) > 0)
                                <img src="{{ $animal->photoUrls[0] }}" class="photo-thumb" alt="Animal Photo">
                            @else
                                <span>No Photo</span>
                            @endif
                        </td>
                        <td>{{ $animal->animalId }}</td>
                        <td>{{ $animal->species }}</td>
                        <td>{{ $animal->color }}</td>
                        <td>{{ ucfirst($animal->size) }}</td>
                        <td>{{ $animal->last_sighting_time ? $animal->last_sighting_time->format('Y-m-d') : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('animal.edit', $animal->animalId) }}" class="btn-edit">✏️ Edit</a>
                            <a href="{{ route('animal.show', $animal->animalId) }}" class="btn-view">👁️ View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <p>No animal profiles found. </p>
                <p>Animal profiles will appear here after you report a sighting for an unidentified animal.</p>
            </div>
        @endif
    </div>
</body>
</html>