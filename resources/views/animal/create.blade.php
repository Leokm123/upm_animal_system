<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Animal Profile</title>
    <style>
        .container { width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 12px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #388E3C; }
        .success { color: green; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Animal Electronic Profile</h2>
        
        <!-- Display success message if exists -->
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        
        <!-- Display validation errors -->
        @if($errors->any())
            <div style="color: red; margin-bottom: 15px;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('animal.store') }}">
            @csrf
            <!-- Hidden field: Associate with initial sighting ID -->
            <input type="hidden" name="initial_sighting_id" value="{{ request('initial_sighting_id') }}" required>

            <!-- Species input field -->
            <div class="form-group">
                <label>Species</label>
                <input type="text" name="species" placeholder="e.g.: Cat/Dog" required>
            </div>

            <!-- Gender selection -->
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="unknown">Unknown</option>
                </select>
            </div>

            <!-- Estimated age input -->
            <div class="form-group">
                <label>Estimated Age (Years)</label>
                <input type="number" name="estimated_age_years" min="0" placeholder="e.g.: 2" required>
            </div>

            <!-- Color description -->
            <div class="form-group">
                <label>Color</label>
                <input type="text" name="color" placeholder="e.g.: Orange/Black & White/Brown" required>
            </div>

            <!-- Size category -->
            <div class="form-group">
                <label>Size</label>
                <select name="size" required>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
            </div>

            <!-- Identifying markings - required field -->
            <div class="form-group">
                <label>Identifying Markings (Required)</label>
                <textarea name="markings" rows="2" placeholder="e.g.: White left front paw/Black spot on forehead" required></textarea>
            </div>

            <!-- Photo URLs input -->
            <div class="form-group">
                <label>Photo URLs (Separate multiple URLs with commas)</label>
                <input type="text" name="photo_urls" placeholder="https://xxx.jpg,https://yyy.jpg" required>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn">Create Profile</button>
        </form>
    </div>
</body>
</html>