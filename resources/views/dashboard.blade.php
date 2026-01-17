<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Dashboard</title>
    <style>
        /* Main layout and typography */
        body { padding: 20px; font-family: Arial; }
        .container { width: 800px; margin: 0 auto; }
        
        /* User role styling */
        .role { color: #2196F3; font-weight: bold; }
        
        /* Navigation box container */
        .nav-box { margin: 30px 0; padding: 20px; background:  #f8f9fa; border-radius: 8px; }
        .nav-box h3 { margin-bottom: 20px; color: #333; }
        
        /* Navigation item styling with hover effects */
        .nav-item { 
            display: block; 
            padding: 12px 20px; 
            margin: 10px 0; 
            background: #2196F3; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 16px; 
        }
        .nav-item:hover { background:  #1976D2; }
        
        /* Logout button styling */
        .logout { 
            margin-top: 20px; 
            display: inline-block; 
            padding: 8px 16px; 
            background: #f44336; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
        }
        .logout:hover { background: #d32f2f; }
    </style>
</head>
<body>
    <div class="container">
        {{-- Check login status based on Session (Multi-guard authentication already verified in controller) --}}
        @if(session('user_role'))
            <!-- Main welcome header -->
            <h1>Welcome to UPM Stray Animal Management System!</h1>
            <p>Current login role: <span class="role">{{ session('user_role') }}</span></p>

            {{-- Volunteer exclusive function navigation --}}
            @if(session('user_role') == 'volunteer')
            <div class="nav-box">
                <h3>Volunteer Function Center</h3>
                <!-- Core volunteer features for animal sighting management -->
                <a href="{{ route('sighting.create') }}" class="nav-item">📝 Report Animal Sighting</a>
                <a href="{{ route('sighting.index') }}" class="nav-item">📜 View My Sighting Records</a>
                <a href="{{ route('animal.index') }}" class="nav-item">🐾 Manage Animal Profiles</a>
            </div>
            @endif

            {{-- Manager exclusive function navigation (placeholder for future features) --}}
            @if(session('user_role') == 'manager')
            <div class="nav-box">
                <h3>Manager Function Center</h3>
                {{-- TODO: Add manager-specific navigation items here --}}
                <!-- Features like:  user management, system reports, data analytics -->
                 {{-- Manager Feeding Point & Task Management Navigation --}}
                  <a href="/manager/create-feeding-point" style="display:block; margin:8px 0; color:#009688; text-decoration:none;">➡ Create Feeding Point</a>
                  <a href="/manager/feeding-point-list" style="display:block; margin:8px 0; color:#009688; text-decoration:none;">➡ View All Feeding Points</a>
                  <a href="/manager/assign-task" style="display:block; margin:8px 0; color:#009688; text-decoration:none;">➡ Assign Task to Volunteer</a>
                  <a href="/manager/task-list" style="display:block; margin:8px 0; color:#009688; text-decoration:none;">➡ View All Assigned Tasks</a>
                  <a href="/manager/volunteer-report" style="display:block; margin:8px 0; color:#009688; text-decoration:none;">➡ Volunteer Task Report</a>
                  <a href="/manager/view-reports" style="display:block; margin:8px 0; color:#009688; text-decoration:none;">➡ View All Task Reports</a>
            </div>
            @endif

            {{-- UPM User exclusive function navigation (placeholder for future features) --}}
            @if(session('user_role') == 'upm_user')
            <div class="nav-box">
                <h3>UPM User Function Center</h3>
                {{-- TODO: Add UPM user-specific navigation items here --}}
                <!-- Features like: view public reports, search animals, contact volunteers -->
            </div>
            @endif

            <!-- Logout functionality -->
            <a href="{{ route('logout') }}" class="logout">🔒 Logout</a>
        @else
            <!-- Redirect to login if not authenticated -->
            <p>Please <a href="{{ route('login') }}">login</a> to the system first!</p>
        @endif
    </div>
</body>
</html>