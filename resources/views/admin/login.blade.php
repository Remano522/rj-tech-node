<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - RJ Tech Node</title>
    @php
        $styleVersion = filemtime(public_path('style.css'));
        $faviconVersion = filemtime(public_path('favicon.ico'));
    @endphp
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ $faviconVersion }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}?v={{ $styleVersion }}">
    <style>
        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .login-box { background: rgba(255, 255, 255, 0.14); padding: 40px; border-radius: 18px; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(10px); width: min(100%, 400px); }
        .brand-badge { width: 68px; height: 68px; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; background: linear-gradient(135deg, #0056b3, #4da3ff); color: #fff; font-size: 1.3rem; font-weight: 700; box-shadow: 0 10px 24px rgba(0, 86, 179, 0.25); }
        .brand-name { text-align: center; font-size: 0.95rem; font-weight: 600; color: #1e3a5f; margin-bottom: 16px; }
        .login-box h1 { margin-bottom: 8px; text-align: center; }
        .login-box p { text-align: center; color: #475569; margin-bottom: 24px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; color: #334155; }
        input { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; }
        button { width: 100%; padding: 12px; background: #4da3ff; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; margin-top: 8px; }
        .error-box { background: rgba(127, 29, 29, 0.9); color: #fff; padding: 12px 14px; border-radius: 10px; margin-bottom: 18px; }
        .hint { font-size: 13px; color: #64748b; margin-top: 12px; }
        .back-link { color: #1d4ed8; display: block; margin-top: 20px; text-decoration: none; font-size: 14px; text-align: center; font-weight: 600; }
    </style>
</head>
<body>
    <main class="login-box">
        <div class="brand-badge" aria-hidden="true">RJ</div>
        <div class="brand-name">RJ Tech Node</div>
        <h1>Admin Login</h1>
        <p>Sign in with your username to manage portfolio data and creator CVs.</p>

        @if($errors->any())
            <div class="error-box" role="alert">{{ $errors->first() }}</div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Username</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" autocomplete="current-password" required>
            </div>
            <button type="submit">Go to Dashboard</button>
            <div class="hint">Use the admin username and password configured for this account.</div>
        </form>

        <a href="{{ url('/') }}" class="back-link">&larr; Back to Home</a>
    </main>
</body>
</html>
