<! DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Animal Profile</title>
    <style>
        .container { width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        .form-group { margin-bottom: 20px; }
        label { display:  block; margin-bottom: 8px; font-weight: bold; }
        input, select, textarea { width: 100%; padding:  10px; box-sizing:  border-box; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 12px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #388E3C; }
        .btn-back { display: inline-block; padding: 10px 20px; background: #757575; color:  white; text-decoration: none; border-radius: 4px; margin-right: 10px; }
        .btn-back:hover { background: #616161; }
        .success { color: green; margin-bottom: 15px; }
        .error { color: red; margin-bottom: 15px; }
        .button-group { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Animal Profile</h2>
        
        <!-- Display success message if exists -->
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        
        <!-- Display validation errors -->
        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('animal.update', $animal->animalId) }}">
            @csrf

            <!-- Profile ID (read-only) -->
            <div class="form-group">
                <label>Profile ID</label>
                <input type="text" value="{{ $animal->animalId }}" disabled>
            </div>

            <!-- Species input field -->
            <div class="form-group">
                <label>Species</label>
                <input type="text" name="species" value="{{ old('species', $animal->species) }}" placeholder="e.g.:  Cat/Dog">
            </div>

            <!-- Gender selection -->
            <div class="form-group">
                <label>Gender</label>
                <select name="gender">
                    <option value="male" {{ $animal->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $animal->gender == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="unknown" {{ $animal->gender == 'unknown' ? 'selected' : '' }}>Unknown</option>
                </select>
            </div>

            <!-- Estimated age input -->
            <div class="form-group">
                <label>Estimated Age (Years)</label>
                <input type="number" name="estimated_age_years" min="0" value="{{ old('estimated_age_years', $animal->estimatedAgeYears) }}" placeholder="e.g.: 2">
            </div>

            <!-- Color description -->
            <div class="form-group">
                <label>Color</label>
                <input type="text" name="color" value="{{ old('color', $animal->color) }}" placeholder="e.g.:  Orange/Black & White/Brown">
            </div>

            <!-- Size category -->
            <div class="form-group">
                <label>Size</label>
                <select name="size">
                    <option value="small" {{ $animal->size == 'small' ? 'selected' : '' }}>Small</option>
                    <option value="medium" {{ $animal->size == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="large" {{ $animal->size == 'large' ? 'selected' : '' }}>Large</option>
                </select>
            </div>

            <!-- Distinctive markings -->
            <div class="form-group">
                <label>Markings</label>
                <textarea name="markings" rows="3" placeholder="Describe distinctive features...">{{ old('markings', $animal->markings) }}</textarea>
            </div>

            <!-- Photo URLs -->
            <div class="form-group">
                <label>Photo URLs (comma separated)</label>
                <textarea name="photo_urls" rows="2" placeholder="https://example.com/photo1.jpg, https://example.com/photo2.jpg">{{ old('photo_urls', is_array($animal->photoUrls) ? implode(', ', $animal->photoUrls) : $animal->photoUrls) }}</textarea>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label>Status</label>
                <input type="text" name="status" value="{{ old('status', $animal->status) }}" placeholder="e.g.: neutered, vaccinated">
            </div>

            <!-- Action buttons -->
            <div class="button-group">
                <a href="{{ route('animal.show', $animal->animalId) }}" class="btn-back">← Back to Profile</a>
                <button type="submit" class="btn">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html>