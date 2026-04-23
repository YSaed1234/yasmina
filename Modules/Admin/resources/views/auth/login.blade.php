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
            --yasmina-bg-soft: #fdf8f7;
        }

        [data-theme="barbie"] {
            --yasmina-primary: #e0218a;
            --yasmina-primary-hover: #c2146e;
            --yasmina-secondary: #ff64b1;
            --yasmina-bg-soft: #fffafb;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--yasmina-bg-soft);
            background-image: 
                radial-gradient(at 0% 0%, var(--yasmina-secondary) 0, transparent 50%),
                radial-gradient(at 100% 0%, var(--yasmina-primary) 0, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
            border-radius: 2.5rem;
            width: 100%;
            max-width: 450px;
            padding: 3.5rem;
            position: relative;
            z-index: 1;
        }

        .flower-pattern {
            position: fixed;
            z-index: 0;
            opacity: 0.2;
            pointer-events: none;
        }

        .flower-tr { top: -5%; right: -5%; width: 40%; }
        .flower-bl { bottom: -5%; left: -5%; width: 40%; transform: rotate(180deg); }

        .input-group:focus-within label {
            color: var(--yasmina-primary);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--yasmina-primary) 0%, var(--yasmina-secondary) 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(var(--yasmina-primary), 0.4);
        }
    </style>
    <script>
        // Load saved theme immediately to prevent flash
        const savedTheme = localStorage.getItem('yasmina-theme') || 'yasmina';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</head>
<body>
    <!-- Decorative patterns -->
    <svg class="flower-pattern flower-tr" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
        <path fill="#FCE7F3" d="M40,-67.2C51.7,-61.8,61,-50.8,67.6,-38.4C74.2,-26,78,-13,76.5,-0.9C74.9,11.2,68,22.4,60.1,32.4C52.2,42.4,43.2,51.3,32.7,58.4C22.1,65.5,11,70.9,-1,72.6C-13,74.3,-26,72.3,-37.2,65.8C-48.4,59.3,-57.8,48.4,-64.1,36.2C-70.4,24,-73.6,10.5,-72.1,-2.5C-70.6,-15.5,-64.4,-28,-55.8,-38.3C-47.2,-48.6,-36.2,-56.7,-24.5,-62.1C-12.8,-67.5,-0.4,-70.2,12,-67.2C24.5,-64.2,33.5,-59,40,-67.2Z" transform="translate(100 100)" />
    </svg>
    <svg class="flower-pattern flower-bl" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
        <path fill="#FFF1F2" d="M44.7,-76.4C58.3,-69.2,69.9,-57.4,77.5,-43.6C85.1,-29.8,88.7,-14.9,87.6,-0.6C86.5,13.6,80.7,27.3,71.9,39C63.1,50.7,51.2,60.4,37.8,67.5C24.4,74.6,9.5,79.1,-5,87.7C-19.5,96.3,-33.5,108.9,-45.5,105.8C-57.5,102.7,-67.5,83.9,-75.4,67.4C-83.3,50.9,-89.1,36.7,-91.1,22.2C-93.1,7.7,-91.3,-7.1,-86.3,-20.9C-81.3,-34.7,-73.1,-47.5,-61.7,-55.7C-50.3,-63.9,-35.7,-67.5,-22.1,-74.7C-8.5,-81.9,4.1,-92.7,18.7,-88.7C33.3,-84.7,44.7,-76.4,44.7,-76.4Z" transform="translate(100 100)" />
    </svg>

    <div class="login-card">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-2 tracking-tight">Yasmina</h1>
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400 font-semibold">{{ __('Admin Dashboard') }}</p>
        </div>

        @if ($errors->any())
            <div class="mb-8 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
            @csrf

            <div class="input-group">
                <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1 transition-colors">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="block w-full px-5 py-4 bg-gray-50/50 border-none rounded-2xl focus:ring-2 focus:ring-pink-500/20 focus:bg-white transition-all text-gray-900 placeholder-gray-300"
                    placeholder="admin@yasmina.com">
            </div>

            <div class="input-group">
                <div class="flex justify-between items-center mb-2 ml-1">
                    <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-widest transition-colors">{{ __('Password') }}</label>
                </div>
                <input id="password" type="password" name="password" required
                    class="block w-full px-5 py-4 bg-gray-50/50 border-none rounded-2xl focus:ring-2 focus:ring-pink-500/20 focus:bg-white transition-all text-gray-900 placeholder-gray-300"
                    placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between pt-2">
                <label class="flex items-center group cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-pink-600 focus:ring-pink-500 transition-all">
                    <span class="ml-2 text-sm text-gray-500 group-hover:text-gray-700 transition-colors">{{ __('Remember me') }}</span>
                </label>
                <a href="#" class="text-xs font-bold text-pink-600 hover:text-pink-700 transition-colors uppercase tracking-widest">{{ __('Forgot Password?') }}</a>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-5 btn-primary text-white rounded-2xl font-bold text-lg shadow-xl shadow-pink-200">
                    {{ __('Sign In') }}
                </button>
            </div>
        </form>

        <div class="mt-12 text-center">
            <p class="text-sm text-gray-400">
                {{ __('Don\'t have an account?') }} 
                <a href="mailto:support@yasmina.com" class="text-pink-600 font-bold hover:underline ml-1">{{ __('Contact Yasmina Admin') }}</a>
            </p>
        </div>
    </div>
</body>
</html>
