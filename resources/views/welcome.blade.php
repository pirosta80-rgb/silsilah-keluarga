<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silsilah Keluarga - Beranda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .glass {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .glass:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: white;
            color: #667eea;
            padding: 14px 36px;
            border-radius: 14px;
            font-weight: 700;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(255, 255, 255, 0.3);
            background: #f7fafc;
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            padding: 14px 36px;
            border-radius: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.4);
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 32px 24px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        .feature-card .icon {
            font-size: 48px;
            margin-bottom: 16px;
            display: block;
        }

        .feature-card h3 {
            color: white;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .feature-card p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            line-height: 1.6;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
        }

        .stat-card .number {
            font-size: 36px;
            font-weight: 800;
            color: white;
            line-height: 1;
        }

        .stat-card .label {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 6px;
            font-weight: 500;
        }

        .hero-title {
            font-size: 52px;
            font-weight: 800;
            color: white;
            line-height: 1.1;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .hero-subtitle {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto;
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer {
            color: rgba(255, 255, 255, 0.6);
            text-align: center;
            padding: 40px 0;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 32px;
            }

            .hero-subtitle {
                font-size: 16px;
            }

            .feature-card {
                padding: 24px 16px;
            }

            .stat-card .number {
                font-size: 28px;
            }

            .btn-primary,
            .btn-outline {
                padding: 12px 24px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🌳</span>
                <span class="text-white font-bold text-lg">Silsilah Keluarga Besar Imam Koesnaeni</span>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('dashboard') }}" class="btn-outline text-sm px-5 py-2">
                    Masuk
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="px-6 py-16 text-center">
        <div class="max-w-4xl mx-auto fade-in">
            <div class="text-7xl mb-6 floating">🌳</div>
            <h1 class="hero-title mb-4">
                Silsilah Keluarga Besar Imam Koesnaeni
            </h1>
            <p class="hero-subtitle mb-8">
                Abadikan warisan keluarga Anda. Catat, kelola, dan visualisasikan silsilah keluarga besar dengan mudah
                dan indah.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('dashboard') }}" class="btn-primary">
                    🚀 Mulai Sekarang
                </a>
                <a href="{{ route('silsilah.index') }}" class="btn-outline">
                    📋 Lihat Silsilah
                </a>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="px-6 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="stat-card">
                    <div class="number">{{ \App\Models\Individual::count() }}</div>
                    <div class="label">👨‍👩‍👧‍👦 Anggota</div>
                </div>
                <div class="stat-card">
                    <div class="number">{{ \App\Models\Marriage::count() }}</div>
                    <div class="label">💑 Pernikahan</div>
                </div>
                <div class="stat-card">
                    <div class="number">
                        {{ \App\Models\Individual::where('gender', 'male')->count() }}
                    </div>
                    <div class="label">👨 Laki-laki</div>
                </div>
                <div class="stat-card">
                    <div class="number">
                        {{ \App\Models\Individual::where('gender', 'female')->count() }}
                    </div>
                    <div class="label">👩 Perempuan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="px-6 py-16">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-white text-center mb-4">
                ✨ Fitur Unggulan
            </h2>
            <p class="text-white/70 text-center mb-12 max-w-2xl mx-auto">
                Semua yang Anda butuhkan untuk mengelola silsilah keluarga besar dalam satu aplikasi.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Fitur 1 -->
                <div class="feature-card">
                    <span class="icon">🌳</span>
                    <h3>Pohon Keluarga</h3>
                    <p>Visualisasi silsilah interaktif dengan zoom, drag, dan tampilan yang indah.</p>
                </div>

                <!-- Fitur 2 -->
                <div class="feature-card">
                    <span class="icon">📋</span>
                    <h3>Daftar Silsilah</h3>
                    <p>Lihat garis keturunan dalam bentuk daftar berindentasi yang rapi dan mudah dibaca.</p>
                </div>

                <!-- Fitur 3 -->
                <div class="feature-card">
                    <span class="icon">🔍</span>
                    <h3>Cari Hubungan</h3>
                    <p>Temukan hubungan antara dua anggota keluarga dengan cepat dan akurat.</p>
                </div>

                <!-- Fitur 4 -->
                <div class="feature-card">
                    <span class="icon">💑</span>
                    <h3>Kelola Pernikahan</h3>
                    <p>Catat pernikahan, pasangan, dan anak-anak dari setiap pasangan.</p>
                </div>

                <!-- Fitur 5 -->
                <div class="feature-card">
                    <span class="icon">📊</span>
                    <h3>Database Lengkap</h3>
                    <p>Simpan data lengkap: nama, tanggal lahir, tempat, bio, dan foto.</p>
                </div>

                <!-- Fitur 6 -->
                <div class="feature-card">
                    <span class="icon">📱</span>
                    <h3>Responsif</h3>
                    <p>Akses dari mana saja: HP, tablet, atau desktop dengan tampilan yang optimal.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="px-6 py-16">
        <div class="max-w-3xl mx-auto text-center">
            <div class="glass p-10">
                <h2 class="text-3xl font-bold text-white mb-4">
                    Siap Memulai?
                </h2>
                <p class="text-white/80 mb-8 text-lg">
                    Mulai abadikan silsilah keluarga Anda sekarang. Gratis dan mudah digunakan.
                </p>
                <a href="{{ route('dashboard') }}" class="btn-primary">
                    🚀 Masuk ke Dashboard
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <p>© {{ date('Y') }} Silsilah Keluarga • Dibuat dengan ❤️ untuk keluarga Indonesia</p>
            <a href="{{ route('admin.login') }}" class="text-white/40 hover:text-white/80 transition-colors text-lg"
                title="Admin Area">
                🔒
            </a>
        </div>
    </footer>
</body>

</html>
