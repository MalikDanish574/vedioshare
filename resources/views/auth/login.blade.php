<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to VideoShare - Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Poppins:wght@500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h2>Welcome Back!</h2>
            <p>Log in to share your moments with the VideoShare community.</p>
            <form action="{{ route('login') }}" method="POST" id="login-form">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-options">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    @endif
                </div>
                <button type="submit">Log In</button>
            </form>
            <p class="register-link">
                Not a member? <a href="{{ route('register') }}">Join Now</a>
            </p>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

