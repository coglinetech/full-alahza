<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Al-Ahza</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@400;500;600&family=Amiri&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --gold: #C5A04E;
            --gold-dark: #A07C35;
            --gold-light: #E8D5A3;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #111008;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23C5A04E' fill-opacity='0.04'%3E%3Cpath d='M30 0l4 8H26L30 0zm0 60l4-8H26L30 60zM0 30l8 4V26L0 30zm60 0l-8 4V26L60 30z'/%3E%3C/g%3E%3C/svg%3E");
        }

        .login-wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 380px;
            padding: 24px;
            animation: fadeUp 0.6s ease forwards;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* HEADER */
        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .login-header p {
            font-size: 11px;
            color: rgba(197,160,78,0.55);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* CARD */
        .login-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(197,160,78,0.12);
            border-radius: 16px;
            padding: 32px;
        }

        /* ALERT */
        .alert-error {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            background: rgba(248,113,113,0.07);
            border: 1px solid rgba(248,113,113,0.2);
            border-radius: 8px;
            padding: 11px 14px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #fca5a5;
            line-height: 1.5;
        }
        .alert-error svg { width: 14px; height: 14px; flex-shrink: 0; margin-top: 2px; }

        /* FORM */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
            margin-bottom: 8px;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px; height: 15px;
            pointer-events: none;
        }
        .form-input {
            width: 100%;
            padding: 11px 12px 11px 38px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(197,160,78,0.15);
            border-radius: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px;
            color: white;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }
        .form-input::placeholder { color: rgba(255,255,255,0.18); }
        .form-input:focus {
            border-color: var(--gold);
            background: rgba(197,160,78,0.06);
        }
        .form-input.is-error { border-color: #f87171; }

        /* REMEMBER */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }
        .remember-row input[type="checkbox"] {
            width: 14px; height: 14px;
            accent-color: var(--gold);
            cursor: pointer;
        }
        .remember-row label {
            font-size: 12px;
            color: rgba(255,255,255,0.35);
            cursor: pointer;
            user-select: none;
        }

        /* BUTTON */
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border: none;
            border-radius: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: opacity 0.2s, transform 0.2s;
        }
        .btn-login:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-login svg { width: 14px; height: 14px; }

        /* BACK LINK */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
            font-size: 12px;
            color: rgba(255,255,255,0.25);
            text-decoration: none;
            transition: color 0.2s;
        }
        .back-link:hover { color: var(--gold); }
        .back-link svg { width: 12px; height: 12px; }
    </style>
</head>
<body>

<div class="login-wrap">

    <div class="login-header">
    <img src="{{ asset('images/logo.png') }}"
         alt="Al-Ahza"
         style="height:48px;width:auto;object-fit:contain;display:block;margin:0 auto 12px;">
    <p>Admin Panel</p>
</div>

    <div class="login-card">

        @if($errors->any())
        <div class="alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>{{ $errors->first('email') }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}" novalidate>
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-wrap">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <input type="email" id="email" name="email"
                           class="form-input {{ $errors->has('email') ? 'is-error' : '' }}"
                           value="{{ old('email') }}"
                           placeholder="admin@alahza.co.id"
                           autocomplete="email" autofocus required>
                </div>
            </div>

            {{-- Tambahkan setelah <div class="login-card"> --}}
            @if(session('session_expired'))
            <div class="alert-session" id="alertSession">
                <div class="alert-session-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div>
                    <div class="alert-session-title">Sesi telah berakhir</div>
                    <div class="alert-session-sub">Silakan masuk kembali untuk melanjutkan.</div>
                </div>
            </div>
            @endif

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" id="password" name="password"
                           class="form-input {{ $errors->has('email') ? 'is-error' : '' }}"
                           placeholder="••••••••"
                           autocomplete="current-password" required>
                </div>
            </div>

            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Masuk
            </button>
        </form>

    </div>

    <a href="{{ route('home') }}" class="back-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Kembali ke website
    </a>

</div>

</body>
</html>