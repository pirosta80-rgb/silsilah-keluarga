<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pernikahan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
        .input-glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
            transition: all 0.3s ease;
        }
        .input-glass:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            outline: none;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.05);
        }
        .input-glass option {
            background: #1a1a2e;
            color: white;
        }
        label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            font-size: 0.875rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(118, 75, 162, 0.4);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="p-8 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-2xl mx-auto">
        <div class="glass rounded-3xl p-8 card-hover">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-white">💑 Tambah Pernikahan</h1>
                    <p class="text-white/60 text-sm mt-1">Catat pernikahan anggota keluarga</p>
                </div>
                <a href="{{ route('individuals.show', $individual) }}"
                   class="text-white/60 hover:text-white transition-colors px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20">
                    ⬅ Kembali
                </a>
            </div>

            @if(session('error'))
                <div class="bg-red-500/20 border border-red-500/30 rounded-xl p-4 mb-6">
                    <p class="text-red-200">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white/10 rounded-xl p-4 mb-6 text-center">
                <p class="text-white font-medium">
                    Menikahkan: <span class="text-white/90 font-bold">{{ $individual->full_name }}</span>
                    <span class="text-white/50 mx-2">•</span>
                    {{ $individual->gender == 'male' ? '👨 Laki-laki' : '👩 Perempuan' }}
                </p>
            </div>

            <form action="{{ route('admin.marriages.store') }}" method="POST">
                @csrf

                @if($individual->gender == 'male')
                    <input type="hidden" name="husband_id" value="{{ $individual->id }}">
                @else
                    <input type="hidden" name="wife_id" value="{{ $individual->id }}">
                @endif

                <div class="mb-4">
                    <label class="block mb-1.5">Pilih Pasangan *</label>
                    <select name="{{ $individual->gender == 'male' ? 'wife_id' : 'husband_id' }}"
                            required class="input-glass w-full px-4 py-3 rounded-xl">
                        <option value="">- Pilih Pasangan -</option>
                        @foreach($potentialSpouses as $spouse)
                            <option value="{{ $spouse->id }}">
                                {{ $spouse->full_name }}
                                ({{ $spouse->gender == 'male' ? '👨 Laki-laki' : '👩 Perempuan' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5">Tanggal Nikah</label>
                        <input type="date" name="marriage_date"
                               class="input-glass w-full px-4 py-3 rounded-xl">
                    </div>
                    <div>
                        <label class="block mb-1.5">Tempat Nikah</label>
                        <input type="text" name="marriage_place"
                               class="input-glass w-full px-4 py-3 rounded-xl"
                               placeholder="Kota/Kabupaten">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block mb-1.5">Status Pernikahan *</label>
                    <select name="status" required class="input-glass w-full px-4 py-3 rounded-xl">
                        <option value="married">💕 Menikah</option>
                        <option value="divorced">💔 Cerai</option>
                        <option value="widowed">🕊️ Janda/Duda</option>
                    </select>
                </div>

                <div class="mt-4">
                    <label class="block mb-1.5">Tanggal Cerai (jika ada)</label>
                    <input type="date" name="divorce_date"
                           class="input-glass w-full px-4 py-3 rounded-xl">
                </div>

                <div class="mt-4">
                    <label class="block mb-1.5">Catatan</label>
                    <input type="text" name="notes"
                           class="input-glass w-full px-4 py-3 rounded-xl"
                           placeholder="Catatan tambahan tentang pernikahan ini">
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('individuals.show', $individual) }}"
                       class="px-6 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white transition-all duration-300">
                        Batal
                    </a>
                    <button type="submit"
                            class="btn-primary px-8 py-3 rounded-xl text-white font-semibold transition-all duration-300 shadow-lg">
                        💍 Simpan Pernikahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
