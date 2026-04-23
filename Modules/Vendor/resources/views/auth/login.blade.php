<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Vendor Login') }} - Yasmina</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .bg-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .text-gradient {
            background: linear-gradient(135deg, #1a1a1a 0%, #4a4a4a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-[#f8f9fa] min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-lg">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black text-gray-900 mb-2">{{ __('Vendor Panel') }}</h1>
            <p class="text-gray-500">{{ __('Login to manage your institution') }}</p>
        </div>

        <div class="bg-glass p-10 rounded-[3rem] shadow-2xl shadow-gray-200/50">
            <form action="{{ route('vendor.login.submit') }}" method="POST" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                    <div class="p-4 bg-red-50 border border-red-100 text-red-600 rounded-2xl text-sm font-bold">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 ml-2">{{ __('Email Address') }}</label>
                    <input type="email" name="email" required autofocus
                           class="w-full px-8 py-5 bg-white border border-gray-100 rounded-3xl focus:ring-4 focus:ring-black/5 outline-none transition-all font-bold text-gray-700 placeholder:text-gray-300"
                           placeholder="vendor@yasmina.com">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 ml-2">{{ __('Password') }}</label>
                    <input type="password" name="password" required
                           class="w-full px-8 py-5 bg-white border border-gray-100 rounded-3xl focus:ring-4 focus:ring-black/5 outline-none transition-all font-bold text-gray-700 placeholder:text-gray-300"
                           placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between px-2">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-5 h-5 border-gray-200 rounded-lg text-black focus:ring-black">
                        <span class="text-sm font-bold text-gray-500 group-hover:text-gray-900 transition-colors">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-5 bg-gray-900 text-white rounded-3xl font-black text-lg shadow-xl shadow-gray-900/20 hover:bg-black transition-all transform hover:-translate-y-1 active:scale-95">
                    {{ __('Login to Dashboard') }}
                </button>
            </form>
        </div>

        <p class="text-center mt-10 text-gray-400 text-sm font-bold">
            &copy; 2026 Yasmina Marketplace. {{ __('All rights reserved.') }}
        </p>
    </div>
</body>
</html>
