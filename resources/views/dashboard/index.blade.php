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
            -webkit-backdrop-filter: blur(20px);
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
            padding: 32px 40px;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            padding: 20px 24px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .stat-card .icon {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .stat-card .number {
            font-size: 28px;
            font-weight: 700;
            color: #2d3748;
        }

        .stat-card .label {
            font-size: 13px;
            color: #a0aec0;
            font-weight: 500;
            margin-top: 4px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.25);
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .btn-green {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }

        .btn-green:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(17, 153, 142, 0.4);
        }

        .btn-pink {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }

        .btn-pink:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 87, 108, 0.4);
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
        }

        .menu-item {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 16px 20px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #2d3748;
            font-weight: 500;
        }

        .menu-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            background: white;
        }

        .menu-item .icon {
            font-size: 28px;
            display: block;
            margin-bottom: 6px;
        }

        .list-item {
            padding: 10px 14px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .list-item:hover {
            background: rgba(102, 126, 234, 0.05);
            border-radius: 8px;
        }

        .list-item .name {
            font-weight: 500;
            color: #2d3748;
        }

        .list-item .info {
            font-size: 13px;
            color: #a0aec0;
        }

        .badge-male {
            background: #ebf5ff;
            color: #3182ce;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-female {
            background: #fdf2f8;
            color: #d53f8c;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .header-gradient {
                padding: 20px 24px;
            }

            .stat-card .number {
                font-size: 22px;
            }

            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="header-gradient mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white drop-shadow-lg">
                        🌳 Silsilah Keluarga
                    </h1>
                    <p class="text-white/80 text-sm mt-1">Kelola silsilah keluarga besar dengan mudah</p>
                </div>
                <div>
                    <a href="{{ route('individuals.create') }}" class="btn-primary">
                        ➕ Tambah Anggota
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
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
                <div class="icon">📊</div>
                <div class="number">{{ $generasi }}</div>
                <div class="label">Generasi</div>
            </div>
        </div>

        <!-- Menu Cepat -->
        <div class="card p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">🚀 Fitur Cepat</h2>
            <div class="menu-grid">
                <a href="{{ route('individuals.index') }}" class="menu-item">
                    <span class="icon">📋</span>
                    Database
                </a>
                <a href="{{ route('family-tree.index') }}" class="menu-item">
                    <span class="icon">🌳</span>
                    Pohon Keluarga
                </a>
                <a href="{{ route('silsilah.index') }}" class="menu-item">
                    <span class="icon">📖</span>
                    Daftar Silsilah
                </a>
                <a href="{{ route('silsilah.cari-hubungan') }}" class="menu-item">
                    <span class="icon">🔍</span>
                    Cari Hubungan
                </a>
                <a href="{{ route('individuals.create') }}" class="menu-item">
                    <span class="icon">➕</span>
                    Tambah Anggota
                </a>
                <a href="{{ route('marriages.create', $root->id ?? 1) }}" class="menu-item">
                    <span class="icon">💑</span>
                    Tambah Pernikahan
                </a>
            </div>
        </div>

        <!-- Anggota Terbaru & Tertua -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Terbaru -->
            <div class="card p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">🆕 Anggota Terbaru</h2>
                @if($anggotaTerbaru->count() > 0)
                    @foreach($anggotaTerbaru as $ind)
                        <div class="list-item" onclick="window.location.href='/individuals/{{ $ind->id }}'">
                            <span class="name">{{ $ind->full_name }}</span>
                            <span class="badge-{{ $ind->gender == 'male' ? 'male' : 'female' }}">
                                {{ $ind->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                            @if($ind->birth_date)
                                <span class="info">• {{ \Carbon\Carbon::parse($ind->birth_date)->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-400 text-sm">Belum ada anggota</p>
                @endif
            </div>

            <!-- Tertua -->
            <div class="card p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">👴 Anggota Tertua</h2>
                @if($anggotaTertua->count() > 0)
                    @foreach($anggotaTertua as $ind)
                        <div class="list-item" onclick="window.location.href='/individuals/{{ $ind->id }}'">
                            <span class="name">{{ $ind->full_name }}</span>
                            <span class="badge-{{ $ind->gender == 'male' ? 'male' : 'female' }}">
                                {{ $ind->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                            @if($ind->birth_date)
                                <span class="info">• {{ \Carbon\Carbon::parse($ind->birth_date)->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-400 text-sm">Belum ada data tanggal lahir</p>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-400 text-sm mt-8">
            © {{ date('Y') }} Silsilah Keluarga • Dibuat dengan ❤️
        </div>
    </div>
</body>
</html>
