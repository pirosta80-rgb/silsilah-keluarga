<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pernikahan</title>
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
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 87, 108, 0.4);
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
                    <h1 class="text-3xl font-bold text-white">✏️ Edit Pernikahan</h1>
                    <p class="text-white/60 text-sm mt-1">Perbarui data pernikahan</p>
                </div>
                <a href="{{ route('admin.individuals.show', $marriage->husband_id) }}"
                   class="text-white/60 hover:text-white transition-colors px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20">
                    ⬅ Kembali
                </a>
            </div>

            <div class="bg-white/10 rounded-xl p-4 mb-6 text-center">
                <p class="text-white font-medium">
                    <span class="text-white/90">{{ $marriage->husband->full_name }}</span>
                    <span class="text-white/50 mx-2">💑</span>
                    <span class="text-white/90">{{ $marriage->wife->full_name }}</span>
                </p>
            </div>

            <form action="{{ route('admin.marriages.update', $marriage) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5">Tanggal Nikah</label>
                        <input type="date" name="marriage_date" value="{{ $marriage->marriage_date }}"
                               class="input-glass w-full px-4 py-3 rounded-xl">
                    </div>
                    <div>
                        <label class="block mb-1.5">Tempat Nikah</label>
                        <input type="text" name="marriage_place" value="{{ $marriage->marriage_place }}"
                               class="input-glass w-full px-4 py-3 rounded-xl"
                               placeholder="Kota/Kabupaten">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block mb-1.5">Status Pernikahan *</label>
                    <select name="status" required class="input-glass w-full px-4 py-3 rounded-xl">
                        <option value="married" {{ $marriage->status == 'married' ? 'selected' : '' }}>💕 Menikah</option>
                        <option value="divorced" {{ $marriage->status == 'divorced' ? 'selected' : '' }}>💔 Cerai</option>
                        <option value="widowed" {{ $marriage->status == 'widowed' ? 'selected' : '' }}>🕊️ Janda/Duda</option>
                    </select>
                </div>

                <div class="mt-4">
                    <label class="block mb-1.5">Tanggal Cerai (jika ada)</label>
                    <input type="date" name="divorce_date" value="{{ $marriage->divorce_date }}"
                           class="input-glass w-full px-4 py-3 rounded-xl">
                </div>

                <div class="mt-4">
                    <label class="block mb-1.5">Catatan</label>
                    <input type="text" name="notes" value="{{ $marriage->notes }}"
                           class="input-glass w-full px-4 py-3 rounded-xl"
                           placeholder="Catatan tambahan tentang pernikahan ini">
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('admin.individuals.show', $marriage->husband_id) }}"
                       class="px-6 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white transition-all duration-300">
                        Batal
                    </a>
                    <button type="submit"
                            class="btn-primary px-8 py-3 rounded-xl text-white font-semibold transition-all duration-300 shadow-lg">
                        💾 Update Pernikahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
