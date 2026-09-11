<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Silsilah Keluarga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            border-radius: 24px;
        }

        .input-glass {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 14px 18px;
            border-radius: 12px;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 15px;
        }

        .input-glass:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
        }

        .input-glass::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .btn-primary {
            background: white;
            color: #667eea;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(255, 255, 255, 0.3);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="w-full max-w-md mx-auto px-4 fade-in">
        <div class="glass p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">🔐</div>
                <h1 class="text-3xl font-bold text-white mb-2">Login Admin</h1>
                <p class="text-white/70 text-sm">Area terbatas untuk pengelola silsilah</p>
            </div>

            <!-- Error -->
            @if($errors->any())
                <div class="bg-red-500/20 border border-red-400/30 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-2 text-red-200">
                        <span>⚠️</span>
                        <span class="text-sm">{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500/20 border border-red-400/30 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-2 text-red-200">
                        <span>⚠️</span>
                        <span class="text-sm">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="block text-white/80 text-sm font-medium mb-2">👤 Username</label>
                    <input type="text"
                           name="username"
                           value="{{ old('username') }}"
                           placeholder="Masukkan username"
                           class="input-glass"
                           required
                           autofocus>
                </div>

                <div class="mb-6">
                    <label class="block text-white/80 text-sm font-medium mb-2">🔑 Password</label>
                    <input type="password"
                           name="password"
                           placeholder="Masukkan password"
                           class="input-glass"
                           required>
                </div>

                <div class="flex items-center mb-6">
                    <input type="checkbox" name="remember" id="remember"
                           class="w-4 h-4 rounded bg-white/10 border-white/30 text-purple-600">
                    <label for="remember" class="ml-2 text-white/70 text-sm">Ingat saya</label>
                </div>

                <button type="submit" class="btn-primary">
                    🚀 Masuk
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <a href="{{ route('welcome') }}" class="text-white/60 hover:text-white text-sm transition-colors">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        <div class="text-center mt-6 text-white/40 text-xs">
            © {{ date('Y') }} Silsilah Keluarga • Area Admin
        </div>
    </div>
</body>
</html>
