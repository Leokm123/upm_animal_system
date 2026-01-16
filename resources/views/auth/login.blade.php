<! DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UPM Stray Animal System - Login</title>
    <!-- Simple styling to ensure clean and professional login interface -->
    <style>
        /* Reset default browser styles */
        * { margin:  0; padding: 0; box-sizing: border-box; }
        
        /* Main page layout and typography */
        body { background: #f5f5f5; font-family: Arial, sans-serif; }
        
        /* Central login container with card-like appearance */
        .login-box { 
            width: 400px; 
            margin: 100px auto; 
            background: white; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1); 
        }
        
        /* Login title styling */
        .login-box h2 { 
            text-align: center; 
            margin-bottom: 20px; 
            color: #333; 
            font-size: 24px;
        }
        
        /* Error message styling with red theme */
        .error { 
            color: #d32f2f; 
            text-align: center; 
            margin-bottom: 15px; 
            padding: 10px; 
            background: #ffebee; 
            border-radius: 4px; 
            border: 1px solid #ffcdd2;
        }
        
        /* Success message styling with green theme */
        .success { 
            color: #388e3c; 
            text-align: center; 
            margin-bottom: 15px; 
            padding: 10px; 
            background: #e8f5e8; 
            border-radius:  4px; 
            border: 1px solid #c8e6c9;
        }
        
        /* Form field container spacing */
        .form-item { margin-bottom: 20px; }
        
        /* Form labels styling */
        .form-item label { 
            display: block; 
            margin-bottom: 5px; 
            color:  #666; 
            font-weight: 500;
        }
        
        /* Input field styling with focus effects */
        .form-item input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            font-size: 16px; 
            transition: border-color 0.3s;
        }
        .form-item input:focus {
            border-color: #2196F3;
            outline:  none;
        }
        
        /* Primary login button with hover effects */
        .login-btn { 
            width: 100%; 
            padding: 12px; 
            background: #2196F3; 
            color: white; 
            border:  none; 
            border-radius: 4px; 
            font-size: 16px; 
            font-weight: 500;
            cursor: pointer; 
            transition: background-color 0.3s;
        }
        .login-btn:hover { background: #1976D2; }
        .login-btn:active { background: #1565C0; }
    </style>
</head>
<body>
    <div class="login-box">
        <!-- Main login heading -->
        <h2>UPM Stray Animal System</h2>
        
        <!-- Display authentication error messages (e.g., incorrect credentials) -->
        @if($errors->has('login'))
            <div class="error">{{ $errors->first('login') }}</div>
        @endif

        <!-- Display success messages (e.g., successful logout notification) -->
        @if(session('message'))
            <div class="success">{{ session('message') }}</div>
        @endif

        <!-- Login form:  Handles multi-guard authentication for UPM users, managers, and volunteers -->
        <form method="POST" action="{{ route('login.submit') }}">
            <!-- CSRF protection:  Required for all POST requests in Laravel -->
            @csrf

            <!-- Username field:  Supports login for all user types by username -->
            <div class="form-item">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    id="username"
                    name="username" 
                    value="{{ old('username') }}" 
                    placeholder="Enter your username" 
                    required 
                    autocomplete="username"
                >
            </div>

            <!-- Password field:  Verified using Laravel's Hash::check() -->
            <div class="form-item">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    placeholder="Enter your password" 
                    required 
                    autocomplete="current-password"
                >
            </div>

            <!-- Submit button: Triggers authentication process -->
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</body>
</html>