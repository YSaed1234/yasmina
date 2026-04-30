<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Admin Login') }} | {{ config('app.name', 'Yasmina') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --yasmina-primary: #865d58;
            --yasmina-primary-hover: #75514c;
            --yasmina-secondary: #d6a6a1;
            --yasmina-bg: #fdfaf9;
            --card-shadow: 0 20px 40px -10px rgba(134, 93, 88, 0.1);
        }

        [data-theme="barbie"] {
            --yasmina-primary: #e0218a;
            --yasmina-primary-hover: #c2146e;
            --yasmina-secondary: #ff64b1;
            --yasmina-bg: #fffafc;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--yasmina-bg);
            background-image: 
                radial-gradient(at 100% 0%, var(--yasmina-secondary) 0, transparent 30%),
                radial-gradient(at 0% 100%, var(--yasmina-secondary) 0, transparent 30%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            background: #ffffff;
            border-radius: 2rem;
            width: 100%;
            max-width: 440px;
            padding: 3.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(134, 93, 88, 0.05);
            transition: transform 0.3s ease;
        }

        .input-group label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            display: block;
            transition: color 0.2s;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.25rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            color: #1e293b;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--yasmina-secondary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(214, 166, 161, 0.15);
        }

        .btn-submit {
            width: 100%;
            padding: 1.125rem;
            background: var(--yasmina-primary);
            color: white;
            border: none;
            border-radius: 1rem;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 15px -3px rgba(134, 93, 88, 0.2);
        }

        .btn-submit:hover {
            background: var(--yasmina-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(134, 93, 88, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .error-alert {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
            color: #991b1b;
            font-size: 0.875rem;
        }

        .footer-link {
            color: var(--yasmina-primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-link:hover {
            color: var(--yasmina-primary-hover);
            text-decoration: underline;
        }
    </style>
    <script>
        const savedTheme = localStorage.getItem('yasmina-theme') || 'yasmina';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-2 tracking-tight">
                Yasmina<span style="color: var(--yasmina-primary)">.</span>
            </h1>
            <p class="text-sm text-slate-400 font-medium">{{ __('Admin Dashboard Login') }}</p>
        </div>

        @if ($errors->any())
            <div class="error-alert">
                <ul class="list-none p-0 m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
            @csrf

            <div class="input-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="form-input"
                    placeholder="admin@yasmina.com">
            </div>

            <div class="input-group">
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="m-0">{{ __('Password') }}</label>
                </div>
                <input id="password" type="password" name="password" required
                    class="form-input"
                    placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center cursor-pointer group">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-[var(--yasmina-primary)] focus:ring-[var(--yasmina-primary)]">
                    <span class="ml-2 text-sm text-slate-500 group-hover:text-slate-700 transition-colors">{{ __('Remember me') }}</span>
                </label>
                <a href="#" class="text-xs font-bold footer-link uppercase tracking-tighter">{{ __('Forgot Password?') }}</a>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-submit">
                    {{ __('Sign In') }}
                </button>
            </div>
        </form>

        <div class="mt-10 text-center">
            <p class="text-sm text-slate-400">
                {{ __('Don\'t have an account?') }} 
                <a href="mailto:support@yasmina.com" class="footer-link ml-1">{{ __('Contact Support') }}</a>
            </p>
        </div>
    </div>
</body>
</html>
