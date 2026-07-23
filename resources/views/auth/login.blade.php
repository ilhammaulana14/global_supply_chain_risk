<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SCRI Supply Chain Risk Intelligence</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            width: 100%;
            max-width: 440px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        .logo-area {
            text-align: center;
            margin-bottom: 32px;
        }
        .logo-icon {
            font-size: 40px;
            margin-bottom: 12px;
            display: inline-block;
        }
        .logo-title {
            color: #fff;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .logo-subtitle {
            color: #94a3b8;
            font-size: 13px;
            margin-top: 4px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .form-input {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 16px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }
        .form-input:focus {
            border-color: #2D9F6F;
            box-shadow: 0 0 0 3px rgba(45, 159, 111, 0.15);
        }
        .flex-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 24px;
            margin-bottom: 24px;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8;
            font-size: 13px;
            cursor: pointer;
        }
        .checkbox-input {
            accent-color: #2D9F6F;
            width: 16px;
            height: 16px;
        }
        .forgot-link {
            color: #3b82f6;
            font-size: 13px;
            text-decoration: none;
            font-weight: 500;
        }
        .forgot-link:hover {
            text-decoration: underline;
        }
        .btn-submit {
            width: 100%;
            background: #2D9F6F;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(45, 159, 111, 0.2);
        }
        .btn-submit:hover {
            background: #248a5e;
            box-shadow: 0 6px 16px rgba(45, 159, 111, 0.3);
            transform: translateY(-1px);
        }
        .register-text {
            text-align: center;
            margin-top: 24px;
            color: #94a3b8;
            font-size: 13.5px;
        }
        .register-link {
            color: #2D9F6F;
            text-decoration: none;
            font-weight: 600;
        }
        .register-link:hover {
            text-decoration: underline;
        }
        .error-card {
            background: rgba(224, 75, 75, 0.15);
            border: 1px solid rgba(224, 75, 75, 0.3);
            border-radius: 12px;
            padding: 12px 16px;
            color: #f87171;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .error-card ul {
            list-style: none;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="logo-area">
        <span class="logo-icon">🌍</span>
        <h1 class="logo-title">SCRI Platform</h1>
        <p class="logo-subtitle">Supply Chain Risk Intelligence Login</p>
    </div>

    @if ($errors->any())
        <div class="error-card">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input class="form-input" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input class="form-input" id="password" type="password" name="password" required autocomplete="current-password">
        </div>

        <div class="flex-row">
            <label class="checkbox-label" for="remember_me">
                <input class="checkbox-input" id="remember_me" type="checkbox" name="remember">
                Remember me
            </label>
            @if (Route::has('password.request'))
                <a class="forgot-link" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <button class="btn-submit" type="submit">Log In</button>
    </form>

    <div class="register-text">
        Don't have an account? <a class="register-link" href="{{ route('register') }}">Register here</a>
    </div>
</div>

</body>
</html>
