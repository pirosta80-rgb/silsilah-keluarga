<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Silsilah Keluarga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        .btn-glow:hover {
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
        }
        .table-row {
            transition: all 0.2s ease;
        }
        .table-row:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        .badge-admin {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(34, 197, 94, 0.3);
            color: #bbf7d0;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-guest {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(251, 191, 36, 0.3);
            color: #fef08a;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="glass rounded-2xl p-8 mb-8 card-hover">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-white drop-shadow-lg">
                        📋 Database Silsilah Keluarga
                    </h1>
                    <p class="text-white/80 mt-1 text-sm">
                        @if(Auth::guard('admin')->check())
                            Mode Admin • Anda bisa menambah, edit, dan hapus data
                        @else
                            Mode Tamu • Hanya bisa melihat data
                        @endif
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    @if(Auth::guard('admin')->check())
                        <span class="badge-admin">🔐 {{ Auth::guard('admin')->user()->name }}</span>
                    @else
                        <span class="badge-guest">👤 Tamu</span>
                    @endif

                    <a href="{{ route('dashboard') }}"
                       class="bg-white/20 hover:bg-white/30 text-white font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 backdrop-blur-sm border border-white/20 btn-glow">
                        🔙 Dashboard
                    </a>
                    <a href="{{ route('family-tree.index') }}"
                       class="bg-white/20 hover:bg-white/30 text-white font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 backdrop-blur-sm border border-white/20 btn-glow">
                        🌿 Pohon Keluarga
                    </a>
                    @if(Auth::guard('admin')->check())
                        <a href="{{ route('admin.individuals.create') }}"
                           class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 shadow-lg btn-glow">
                            ➕ Tambah Anggota
                        </a>
                    @else
                        <a href="{{ route('admin.login') }}"
                           class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 shadow-lg btn-glow">
                            🔒 Login untuk Tambah
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Alert Success -->
        @if(session('success'))
            <div class="glass rounded-2xl p-4 mb-6 border-green-400/30 card-hover">
                <div class="flex items-center gap-3 text-white">
                    <span class="text-2xl">✅</span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Info Tamu -->
        @if(!Auth::guard('admin')->check())
            <div class="glass rounded-2xl p-4 mb-6 border-amber-400/30">
                <div class="flex items-start gap-3 text-white">
                    <span class="text-2xl">ℹ️</span>
                    <div>
                        <div class="font-semibold text-sm">Mode Tamu</div>
                        <div class="text-white/70 text-sm mt-1">
                            Anda hanya bisa melihat data.
                            <a href="{{ route('admin.login') }}" class="text-amber-300 hover:text-amber-200 font-semibold underline">
                                Login sebagai admin
                            </a>
                            untuk mengelola data.
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tabel -->
        <div class="glass rounded-2xl p-6 card-hover overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="text-left py-4 px-4 text-white/70 font-semibold text-sm uppercase tracking-wider">Nama</th>
                            <th class="text-left py-4 px-4 text-white/70 font-semibold text-sm uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="text-left py-4 px-4 text-white/70 font-semibold text-sm uppercase tracking-wider">Tanggal Lahir</th>
                            <th class="text-right py-4 px-4 text-white/70 font-semibold text-sm uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($individuals as $individual)
                        <tr class="table-row">
                            <td class="py-4 px-4">
                                <div class="text-white font-medium">{{ $individual->full_name }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $individual->gender == 'male' ? 'bg-blue-500/30 text-blue-200' : 'bg-pink-500/30 text-pink-200' }}">
                                    {{ $individual->gender == 'male' ? '👨 Laki-laki' : '👩 Perempuan' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-white/70 text-sm">
                                {{ $individual->birth_date ? date('d/m/Y', strtotime($individual->birth_date)) : '-' }}
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex justify-end gap-2">
                                    {{-- Tombol Lihat (semua bisa) --}}
                                    <a href="{{ route('individuals.show', $individual) }}"
                                       class="text-white/60 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10"
                                       title="Lihat">
                                        👁️
                                    </a>

                                    {{-- Tombol Edit (admin only) --}}
                                    @if(Auth::guard('admin')->check())
                                        <a href="{{ route('admin.individuals.edit', $individual) }}"
                                           class="text-white/60 hover:text-yellow-400 transition-colors p-1.5 rounded-lg hover:bg-white/10"
                                           title="Edit">
                                            ✏️
                                        </a>
                                    @endif

                                    {{-- Tombol Hapus (admin only) --}}
                                    @if(Auth::guard('admin')->check())
                                        <form action="{{ route('admin.individuals.destroy', $individual) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Yakin hapus {{ $individual->full_name }}?')"
                                                    class="text-white/60 hover:text-red-400 transition-colors p-1.5 rounded-lg hover:bg-white/10"
                                                    title="Hapus">
                                                🗑️
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 text-white/50">
                                <div class="text-6xl mb-4">📭</div>
                                <p class="text-lg">Belum ada anggota keluarga</p>
                                <p class="text-sm mt-1">
                                    @if(Auth::guard('admin')->check())
                                        Klik "Tambah Anggota" untuk memulai
                                    @else
                                        Hubungi admin untuk menambahkan data
                                    @endif
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($individuals->hasPages())
                <div class="mt-6 pt-4 border-t border-white/10">
                    {{ $individuals->links() }}
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center text-white/40 text-sm">
            © {{ date('Y') }} Silsilah Keluarga
            @if(!Auth::guard('admin')->check())
                • <a href="{{ route('admin.login') }}" class="hover:text-white/70 transition-colors">🔒 Login Admin</a>
            @endif
        </div>
    </div>
</body>
</html>
