<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBorrow - Sign Up</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <div class="auth-container">
        <div class="logo-container">
            <img src="/storage/images/logo.png" alt="BookBorrow Logo" class="logo">
            <div class="app-name">BookBorrow</div>
        </div>

        <h1>Create a new account</h1>

        @if (session('success'))
        <x-alert type="success" :message="session('success')" />
        @elseif (session('error'))
        <x-alert type="error" :message="session('error')" />
        @endif




        <!-- Registration Form -->
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="input-field" placeholder="Enter your full name" value="{{ old('name') }}" required>
             
                    
               
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="input-field" placeholder="Enter your email" value="{{ old('email') }}" required>
               
                    
              
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="input-field" placeholder="Enter your password" required>
                <span class="password-toggle" onclick="togglePassword('password')">👁️</span>
           
                
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="input-field" placeholder="Confirm your password" required>
                <span class="password-toggle" onclick="togglePassword('password_confirmation')">👁️</span>
            </div>
            <button type="submit" class="btn">Sign Up</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('login') }}" class="auth-link">Sign in</a>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const toggleIcon = passwordField.nextElementSibling;
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.textContent = '👁️‍🗨️';
            } else {
                passwordField.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }
    </script>
</body>
</html>