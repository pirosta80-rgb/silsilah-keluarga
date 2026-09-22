<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail {{ $individual->full_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .glass {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
        }
        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        .relation-card {
            background: rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            padding: 16px;
            transition: all 0.3s ease;
        }
        .relation-card:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: scale(1.02);
        }
        .btn-glass {
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        .btn-admin {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transition: all 0.3s ease;
        }
        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        .btn-login {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }
        .badge-male {
            background: rgba(59, 130, 246, 0.3);
            color: #93c5fd;
        }
        .badge-female {
            background: rgba(236, 72, 153, 0.3);
            color: #f9a8d4;
        }
        .badge-admin {
            background: rgba(34, 197, 94, 0.3);
            color: #bbf7d0;
        }
        .badge-guest {
            background: rgba(251, 191, 36, 0.3);
            color: #fef08a;
        }
    </style>
</head>
<body class="p-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="glass rounded-2xl p-6 card-hover mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center gap-4">
                    <div class="avatar">
                        {{ $individual->gender == 'male' ? '👨' : '👩' }}
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">{{ $individual->full_name }}</h1>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold
                                {{ $individual->gender == 'male' ? 'badge-male' : 'badge-female' }}">
                                {{ $individual->gender == 'male' ? '👨 Laki-laki' : '👩 Perempuan' }}
                            </span>
                            @if(Auth::guard('admin')->check())
                                <span class="badge-admin px-3 py-1 rounded-full text-xs font-semibold">
                                    🔐 {{ Auth::guard('admin')->user()->name }}
                                </span>
                            @else
                                <span class="badge-guest px-3 py-1 rounded-full text-xs font-semibold">
                                    👤 Tamu
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if(Auth::guard('admin')->check())
                        {{-- Admin: tombol CRUD --}}
                        <a href="{{ route('admin.marriages.create', $individual->id) }}"
                           class="btn-admin text-white px-5 py-2.5 rounded-xl font-medium">
                            💑 Tambah Pernikahan
                        </a>
                        <a href="{{ route('admin.individuals.edit', $individual) }}"
                           class="btn-admin text-white px-5 py-2.5 rounded-xl font-medium">
                            ✏️ Edit
                        </a>
                    @else
                        {{-- Tamu: tombol login --}}
                        <a href="{{ route('admin.login') }}"
                           class="btn-login text-white px-5 py-2.5 rounded-xl font-medium">
                            🔒 Login untuk Kelola
                        </a>
                    @endif
                    <a href="{{ route('family-tree.index') }}"
                       class="btn-glass text-white px-5 py-2.5 rounded-xl font-medium">
                        🌿 Pohon
                    </a>
                    <a href="{{ route('individuals.index') }}"
                       class="btn-glass text-white px-5 py-2.5 rounded-xl font-medium">
                        ⬅ Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert -->
        @if(session('success'))
            <div class="glass rounded-2xl p-4 mb-6 border-green-400/30 card-hover">
                <div class="flex items-center gap-3 text-white">
                    <span class="text-2xl">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Info Tamu -->
        @if(!Auth::guard('admin')->check())
            <div class="glass rounded-2xl p-4 mb-6 border-l-4 border-amber-400">
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

        <!-- Informasi -->
        <div class="glass rounded-2xl p-6 card-hover mb-6">
            <h3 class="text-white font-semibold text-lg mb-4">📋 Informasi Pribadi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($individual->birth_date)
                <div class="flex items-center gap-3 text-white/80">
                    <span class="text-2xl">🎂</span>
                    <div>
                        <div class="text-sm text-white/50">Tanggal Lahir</div>
                        <div class="font-medium">{{ date('d F Y', strtotime($individual->birth_date)) }}</div>
                    </div>
                </div>
                @endif
                @if($individual->birth_place)
                <div class="flex items-center gap-3 text-white/80">
                    <span class="text-2xl">📍</span>
                    <div>
                        <div class="text-sm text-white/50">Tempat Lahir</div>
                        <div class="font-medium">{{ $individual->birth_place }}</div>
                    </div>
                </div>
                @endif
                @if($individual->death_date)
                <div class="flex items-center gap-3 text-white/80">
                    <span class="text-2xl">🕊️</span>
                    <div>
                        <div class="text-sm text-white/50">Tanggal Meninggal</div>
                        <div class="font-medium">{{ date('d F Y', strtotime($individual->death_date)) }}</div>
                    </div>
                </div>
                @endif
                @if($individual->death_place)
                <div class="flex items-center gap-3 text-white/80">
                    <span class="text-2xl">📍</span>
                    <div>
                        <div class="text-sm text-white/50">Tempat Meninggal</div>
                        <div class="font-medium">{{ $individual->death_place }}</div>
                    </div>
                </div>
                @endif
                @if($individual->bio)
                <div class="col-span-full flex items-start gap-3 text-white/80 pt-2 border-t border-white/10">
                    <span class="text-2xl">📝</span>
                    <div>
                        <div class="text-sm text-white/50">Catatan</div>
                        <div class="font-medium">{{ $individual->bio }}</div>
                    </div>
                </div>
                @endif
                @if(!$individual->birth_date && !$individual->birth_place && !$individual->death_date && !$individual->death_place && !$individual->bio)
                <div class="col-span-full text-center py-6 text-white/40">
                    <div class="text-4xl mb-2">📭</div>
                    <div class="text-sm">Belum ada informasi detail</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Orang Tua -->
        @if($parents && ($parents->father || $parents->mother))
        <div class="glass rounded-2xl p-6 card-hover mb-6">
            <h3 class="text-white font-semibold text-lg mb-4">👨‍👩‍👦 Orang Tua</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($parents->father)
                <a href="{{ route('individuals.show', $parents->father) }}" class="relation-card">
                    <div class="text-white/50 text-sm">Ayah</div>
                    <div class="text-white font-medium text-lg">{{ $parents->father->full_name }}</div>
                    @if($parents->father->birth_date)
                        <div class="text-white/40 text-xs mt-1">
                            {{ date('d/m/Y', strtotime($parents->father->birth_date)) }}
                        </div>
                    @endif
                </a>
                @endif
                @if($parents->mother)
                <a href="{{ route('individuals.show', $parents->mother) }}" class="relation-card">
                    <div class="text-white/50 text-sm">Ibu</div>
                    <div class="text-white font-medium text-lg">{{ $parents->mother->full_name }}</div>
                    @if($parents->mother->birth_date)
                        <div class="text-white/40 text-xs mt-1">
                            {{ date('d/m/Y', strtotime($parents->mother->birth_date)) }}
                        </div>
                    @endif
                </a>
                @endif
            </div>
        </div>
        @endif

        <!-- Pernikahan -->
        @if($individual->marriagesAsHusband->count() > 0 || $individual->marriagesAsWife->count() > 0)
        <div class="glass rounded-2xl p-6 card-hover mb-6">
            <h3 class="text-white font-semibold text-lg mb-4">💑 Riwayat Pernikahan</h3>

            {{-- Sebagai Suami --}}
            @foreach($individual->marriagesAsHusband as $marriage)
            <div class="relation-card mb-3 last:mb-0">
                <div class="flex justify-between items-start flex-wrap gap-3">
                    <div class="flex-1">
                        <div class="text-white/50 text-sm">Istri</div>
                        <a href="{{ route('individuals.show', $marriage->wife) }}"
                           class="text-white font-medium text-lg hover:text-white/80 transition-colors">
                            {{ $marriage->wife->full_name }}
                        </a>
                        @if($marriage->marriage_date)
                        <div class="text-white/50 text-sm mt-1">
                            📅 Nikah: {{ date('d F Y', strtotime($marriage->marriage_date)) }}
                        </div>
                        @endif
                        @if($marriage->marriage_place)
                        <div class="text-white/40 text-xs">
                            📍 {{ $marriage->marriage_place }}
                        </div>
                        @endif
                        @if($marriage->status == 'divorced' && $marriage->divorce_date)
                        <div class="text-red-300 text-sm mt-1">
                            💔 Cerai: {{ date('d F Y', strtotime($marriage->divorce_date)) }}
                        </div>
                        @endif
                        @if($marriage->notes)
                        <div class="text-white/40 text-xs mt-1 italic">
                            "{{ $marriage->notes }}"
                        </div>
                        @endif
                    </div>
                    <div class="flex flex-col gap-2 items-end">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $marriage->status == 'married' ? 'bg-emerald-500/30 text-emerald-200' : '' }}
                            {{ $marriage->status == 'divorced' ? 'bg-red-500/30 text-red-200' : '' }}
                            {{ $marriage->status == 'widowed' ? 'bg-gray-500/30 text-gray-200' : '' }}">
                            {{ $marriage->status == 'married' ? '💕 Menikah' : '' }}
                            {{ $marriage->status == 'divorced' ? '💔 Cerai' : '' }}
                            {{ $marriage->status == 'widowed' ? '🕊️ Janda/Duda' : '' }}
                        </span>
                        @if(Auth::guard('admin')->check())
                            <div class="flex gap-1">
                                <a href="{{ route('admin.marriages.edit', $marriage) }}"
                                   class="text-white/60 hover:text-yellow-400 transition-colors p-1 rounded"
                                   title="Edit">
                                    ✏️
                                </a>
                                <form action="{{ route('admin.marriages.destroy', $marriage) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin hapus pernikahan ini?')"
                                            class="text-white/60 hover:text-red-400 transition-colors p-1 rounded"
                                            title="Hapus">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Sebagai Istri --}}
            @foreach($individual->marriagesAsWife as $marriage)
            <div class="relation-card mb-3 last:mb-0">
                <div class="flex justify-between items-start flex-wrap gap-3">
                    <div class="flex-1">
                        <div class="text-white/50 text-sm">Suami</div>
                        <a href="{{ route('admin.individuals.show', $marriage->husband) }}"
                           class="text-white font-medium text-lg hover:text-white/80 transition-colors">
                            {{ $marriage->husband->full_name }}
                        </a>
                        @if($marriage->marriage_date)
                        <div class="text-white/50 text-sm mt-1">
                            📅 Nikah: {{ date('d F Y', strtotime($marriage->marriage_date)) }}
                        </div>
                        @endif
                        @if($marriage->marriage_place)
                        <div class="text-white/40 text-xs">
                            📍 {{ $marriage->marriage_place }}
                        </div>
                        @endif
                        @if($marriage->status == 'divorced' && $marriage->divorce_date)
                        <div class="text-red-300 text-sm mt-1">
                            💔 Cerai: {{ date('d F Y', strtotime($marriage->divorce_date)) }}
                        </div>
                        @endif
                        @if($marriage->notes)
                        <div class="text-white/40 text-xs mt-1 italic">
                            "{{ $marriage->notes }}"
                        </div>
                        @endif
                    </div>
                    <div class="flex flex-col gap-2 items-end">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $marriage->status == 'married' ? 'bg-emerald-500/30 text-emerald-200' : '' }}
                            {{ $marriage->status == 'divorced' ? 'bg-red-500/30 text-red-200' : '' }}
                            {{ $marriage->status == 'widowed' ? 'bg-gray-500/30 text-gray-200' : '' }}">
                            {{ $marriage->status == 'married' ? '💕 Menikah' : '' }}
                            {{ $marriage->status == 'divorced' ? '💔 Cerai' : '' }}
                            {{ $marriage->status == 'widowed' ? '🕊️ Janda/Duda' : '' }}
                        </span>
                        @if(Auth::guard('admin')->check())
                            <div class="flex gap-1">
                                <a href="{{ route('admin.marriages.edit', $marriage) }}"
                                   class="text-white/60 hover:text-yellow-400 transition-colors p-1 rounded"
                                   title="Edit">
                                    ✏️
                                </a>
                                <form action="{{ route('admin.marriages.destroy', $marriage) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin hapus pernikahan ini?')"
                                            class="text-white/60 hover:text-red-400 transition-colors p-1 rounded"
                                            title="Hapus">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Anak-anak -->
        @if($children->count() > 0)
        <div class="glass rounded-2xl p-6 card-hover mb-6">
            <h3 class="text-white font-semibold text-lg mb-4">
                👨‍👧‍👦 Anak-anak ({{ $children->count() }})
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($children as $child)
                <a href="{{ route('admin.individuals.show', $child) }}"
                   class="relation-card text-center hover:scale-105 transition-all duration-300">
                    <div class="text-4xl mb-2">{{ $child->gender == 'male' ? '👦' : '👧' }}</div>
                    <div class="text-white font-medium">{{ $child->full_name }}</div>
                    @if($child->birth_date)
                    <div class="text-white/40 text-sm">{{ date('d/m/Y', strtotime($child->birth_date)) }}</div>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="mt-6 text-center text-white/40 text-xs">
            © {{ date('Y') }} Silsilah Keluarga
            @if(!Auth::guard('admin')->check())
                • <a href="{{ route('admin.login') }}" class="hover:text-white/70 transition-colors">🔒 Login Admin</a>
            @endif
        </div>
    </div>
</body>
</html>
