<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota Keluarga</title>
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
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.05);
            outline: none;
        }
        .input-glass::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
        .input-glass option {
            background: #1a1a2e;
            color: white;
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
        label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="p-8 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-3xl mx-auto">
        <div class="glass rounded-3xl p-8 card-hover">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-white">➕ Tambah Anggota</h1>
                    <p class="text-white/60 text-sm mt-1">Masukkan data anggota keluarga baru</p>
                </div>
                <a href="{{ route('individuals.index') }}"
                   class="text-white/60 hover:text-white transition-colors px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20">
                    ⬅ Kembali
                </a>
            </div>

            <form action="{{ route('individuals.store') }}" method="POST">
                @csrf

                <!-- Data Diri -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5">Nama Depan *</label>
                        <input type="text" name="first_name" required
                               class="input-glass w-full px-4 py-3 rounded-xl"
                               placeholder="Masukkan nama depan">
                    </div>
                    <div>
                        <label class="block mb-1.5">Nama Belakang</label>
                        <input type="text" name="last_name"
                               class="input-glass w-full px-4 py-3 rounded-xl"
                               placeholder="Masukkan nama belakang">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block mb-1.5">Jenis Kelamin *</label>
                    <select name="gender" required class="input-glass w-full px-4 py-3 rounded-xl">
                        <option value="">Pilih jenis kelamin</option>
                        <option value="male">👨 Laki-laki</option>
                        <option value="female">👩 Perempuan</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block mb-1.5">Tanggal Lahir</label>
                        <input type="date" name="birth_date"
                               class="input-glass w-full px-4 py-3 rounded-xl">
                    </div>
                    <div>
                        <label class="block mb-1.5">Tempat Lahir</label>
                        <input type="text" name="birth_place"
                               class="input-glass w-full px-4 py-3 rounded-xl"
                               placeholder="Kota/Kabupaten">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block mb-1.5">Tanggal Meninggal</label>
                        <input type="date" name="death_date"
                               class="input-glass w-full px-4 py-3 rounded-xl">
                    </div>
                    <div>
                        <label class="block mb-1.5">Tempat Meninggal</label>
                        <input type="text" name="death_place"
                               class="input-glass w-full px-4 py-3 rounded-xl"
                               placeholder="Kota/Kabupaten">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block mb-1.5">Bio / Catatan</label>
                    <textarea name="bio" rows="3"
                              class="input-glass w-full px-4 py-3 rounded-xl resize-none"
                              placeholder="Tuliskan catatan tentang anggota ini..."></textarea>
                </div>

                <!-- Hubungan Keluarga -->
                <div class="mt-6 pt-6 border-t border-white/10">
                    <h3 class="text-white font-semibold mb-4 text-lg">👨‍👩‍👧‍👦 Hubungan Keluarga</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1.5">Ayah</label>
                            <select name="father_id" class="input-glass w-full px-4 py-3 rounded-xl">
                                <option value="">- Pilih Ayah -</option>
                                @foreach($individuals as $ind)
                                    @if($ind->gender == 'male')
                                        <option value="{{ $ind->id }}">{{ $ind->full_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1.5">Ibu</label>
                            <select name="mother_id" class="input-glass w-full px-4 py-3 rounded-xl">
                                <option value="">- Pilih Ibu -</option>
                                @foreach($individuals as $ind)
                                    @if($ind->gender == 'female')
                                        <option value="{{ $ind->id }}">{{ $ind->full_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('individuals.index') }}"
                       class="px-6 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white transition-all duration-300">
                        Batal
                    </a>
                    <button type="submit"
                            class="btn-primary px-8 py-3 rounded-xl text-white font-semibold transition-all duration-300 shadow-lg">
                        💾 Simpan Anggota
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
