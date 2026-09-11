<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Silsilah Keluarga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.1);
        }

        .header-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 24px 32px;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .stat-card .icon {
            font-size: 36px;
            margin-bottom: 8px;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: 800;
            color: #2d3748;
            line-height: 1;
        }

        .stat-card .label {
            font-size: 13px;
            color: #a0aec0;
            margin-top: 6px;
            font-weight: 500;
        }

        .menu-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #2d3748;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .menu-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.15);
            background: white;
        }

        .menu-card .icon {
            font-size: 40px;
            display: block;
            margin-bottom: 12px;
        }

        .menu-card .title {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .menu-card .desc {
            font-size: 13px;
            color: #a0aec0;
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(34, 197, 94, 0.2);
            color: #16a34a;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .guest-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(251, 191, 36, 0.2);
            color: #d97706;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .header-gradient {
                padding: 16px 20px;
            }
            .stat-card .number {
                font-size: 24px;
            }
            .stat-card .icon {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="header-gradient mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white drop-shadow-lg">
                        📊 Dashboard Silsilah Keluarga
                    </h1>
                    <p class="text-white/80 text-sm mt-1">
                        @if(Auth::guard('admin')->check())
                            Login sebagai: <span class="font-bold">{{ Auth::guard('admin')->user()->name }}</span>
                        @else
                            Selamat datang, Tamu
                        @endif
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    @if(Auth::guard('admin')->check())
                        <span class="admin-badge">🔐 Admin</span>
                        <a href="{{ route('welcome') }}" class="btn-outline">🏠 Beranda</a>
                        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn-outline">🚪 Logout</button>
                        </form>
                    @else
                        <span class="guest-badge">👤 Tamu</span>
                        <a href="{{ route('welcome') }}" class="btn-outline">🏠 Beranda</a>
                        <a href="{{ route('admin.login') }}" class="btn-primary">🔒 Login Admin</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Alert -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Info Tamu -->
        @if(!Auth::guard('admin')->check())
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">ℹ️</span>
                    <div>
                        <div class="font-semibold text-amber-800 text-sm">Mode Tamu</div>
                        <div class="text-amber-700 text-sm mt-1">
                            Anda hanya bisa melihat data.
                            <a href="{{ route('admin.login') }}" class="font-semibold underline hover:text-amber-900">
                                Login sebagai admin
                            </a>
                            untuk mengelola data.
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="stat-card">
                <div class="icon">👨‍👩‍👧‍👦</div>
                <div class="number">{{ $totalAnggota }}</div>
                <div class="label">Total Anggota</div>
            </div>
            <div class="stat-card">
                <div class="icon">👨</div>
                <div class="number">{{ $totalLaki }}</div>
                <div class="label">Laki-laki</div>
            </div>
            <div class="stat-card">
                <div class="icon">👩</div>
                <div class="number">{{ $totalPerempuan }}</div>
                <div class="label">Perempuan</div>
            </div>
            <div class="stat-card">
                <div class="icon">💑</div>
                <div class="number">{{ $totalPernikahan }}</div>
                <div class="label">Pernikahan</div>
            </div>
            <div class="stat-card">
                <div class="icon">🔗</div>
                <div class="number">{{ $totalRelasi }}</div>
                <div class="label">Relasi</div>
            </div>
        </div>

        <!-- Menu -->
        <div class="card p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">
                🚀 Menu Navigasi
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('individuals.index') }}" class="menu-card">
                    <span class="icon">📋</span>
                    <div class="title">Database</div>
                    <div class="desc">Lihat semua anggota</div>
                </a>
                <a href="{{ route('silsilah.index') }}" class="menu-card">
                    <span class="icon">📖</span>
                    <div class="title">Daftar Silsilah</div>
                    <div class="desc">Garis keturunan</div>
                </a>
                <a href="{{ route('family-tree.index') }}" class="menu-card">
                    <span class="icon">🌳</span>
                    <div class="title">Pohon Keluarga</div>
                    <div class="desc">Visualisasi</div>
                </a>
                <a href="{{ route('silsilah.cari-hubungan') }}" class="menu-card">
                    <span class="icon">🔍</span>
                    <div class="title">Cari Hubungan</div>
                    <div class="desc">Cek relasi</div>
                </a>
            </div>

            @if(Auth::guard('admin')->check())
                <h2 class="text-lg font-bold text-gray-700 mb-4 mt-8">
                    ⚙️ Menu Admin (CRUD)
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('admin.individuals.index') }}" class="menu-card">
                        <span class="icon">✏️</span>
                        <div class="title">Kelola Individu</div>
                        <div class="desc">Tambah, Edit, Hapus</div>
                    </a>
                    <a href="{{ route('admin.individuals.create') }}" class="menu-card">
                        <span class="icon">➕</span>
                        <div class="title">Tambah Anggota</div>
                        <div class="desc">Input data baru</div>
                    </a>
                    <a href="{{ route('admin.individuals.index') }}" class="menu-card">
                        <span class="icon">💑</span>
                        <div class="title">Kelola Pernikahan</div>
                        <div class="desc">Catat pernikahan</div>
                    </a>
                </div>
            @else
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">🔒</span>
                        <div>
                            <div class="font-semibold text-blue-800 text-sm">Login untuk Kelola Data</div>
                            <div class="text-blue-700 text-sm mt-1">
                                Untuk menambah, edit, atau hapus data, silakan login sebagai admin.
                            </div>
                            <a href="{{ route('admin.login') }}" class="inline-block mt-2 text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                🔒 Login Admin →
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-400 text-sm mt-8">
            © {{ date('Y') }} Silsilah Keluarga
        </div>
    </div>
</body>
</html>
