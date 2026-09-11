<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit {{ $individual->full_name }}</title>
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
        label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            font-size: 0.875rem;
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
    <div class="w-full max-w-3xl mx-auto">
        <div class="glass rounded-3xl p-8 card-hover">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-white">✏️ Edit Anggota</h1>
                    <p class="text-white/60 text-sm mt-1">Perbarui data {{ $individual->full_name }}</p>
                </div>
                <a href="{{ route('individuals.index') }}"
                   class="text-white/60 hover:text-white transition-colors px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20">
                    ⬅ Kembali
                </a>
            </div>

            <form action="{{ route('individuals.update', $individual) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5">Nama Depan *</label>
                        <input type="text" name="first_name" value="{{ $individual->first_name }}" required
                               class="input-glass w-full px-4 py-3 rounded-xl"
                               placeholder="Masukkan nama depan">
                    </div>
                    <div>
                        <label class="block mb-1.5">Nama Belakang</label>
                        <input type="text" name="last_name" value="{{ $individual->last_name }}"
                               class="input-glass w-full px-4 py-3 rounded-xl"
                               placeholder="Masukkan nama belakang">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block mb-1.5">Jenis Kelamin *</label>
                    <select name="gender" required class="input-glass w-full px-4 py-3 rounded-xl">
                        <option value="male" {{ $individual->gender == 'male' ? 'selected' : '' }}>👨 Laki-laki</option>
                        <option value="female" {{ $individual->gender == 'female' ? 'selected' : '' }}>👩 Perempuan</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block mb-1.5">Tanggal Lahir</label>
                        <input type="date" name="birth_date" value="{{ $individual->birth_date }}"
                               class="input-glass w-full px-4 py-3 rounded-xl">
                    </div>
                    <div>
                        <label class="block mb-1.5">Tempat Lahir</label>
                        <input type="text" name="birth_place" value="{{ $individual->birth_place }}"
                               class="input-glass w-full px-4 py-3 rounded-xl"
                               placeholder="Kota/Kabupaten">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block mb-1.5">Tanggal Meninggal</label>
                        <input type="date" name="death_date" value="{{ $individual->death_date }}"
                               class="input-glass w-full px-4 py-3 rounded-xl">
                    </div>
                    <div>
                        <label class="block mb-1.5">Tempat Meninggal</label>
                        <input type="text" name="death_place" value="{{ $individual->death_place }}"
                               class="input-glass w-full px-4 py-3 rounded-xl"
                               placeholder="Kota/Kabupaten">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block mb-1.5">Bio / Catatan</label>
                    <textarea name="bio" rows="3"
                              class="input-glass w-full px-4 py-3 rounded-xl resize-none"
                              placeholder="Tuliskan catatan tentang anggota ini...">{{ $individual->bio }}</textarea>
                </div>

                <div class="mt-6 pt-6 border-t border-white/10">
                    <h3 class="text-white font-semibold mb-4 text-lg">👨‍👩‍👧‍👦 Hubungan Keluarga</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1.5">Ayah</label>
                            <select name="father_id" class="input-glass w-full px-4 py-3 rounded-xl">
                                <option value="">- Pilih Ayah -</option>
                                @foreach($allIndividuals as $ind)
                                    @if($ind->gender == 'male')
                                        <option value="{{ $ind->id }}"
                                            {{ isset($relationship) && $relationship->father_id == $ind->id ? 'selected' : '' }}>
                                            {{ $ind->full_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1.5">Ibu</label>
                            <select name="mother_id" class="input-glass w-full px-4 py-3 rounded-xl">
                                <option value="">- Pilih Ibu -</option>
                                @foreach($allIndividuals as $ind)
                                    @if($ind->gender == 'female')
                                        <option value="{{ $ind->id }}"
                                            {{ isset($relationship) && $relationship->mother_id == $ind->id ? 'selected' : '' }}>
                                            {{ $ind->full_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('individuals.index') }}"
                       class="px-6 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white transition-all duration-300">
                        Batal
                    </a>
                    <button type="submit"
                            class="btn-primary px-8 py-3 rounded-xl text-white font-semibold transition-all duration-300 shadow-lg">
                        💾 Update Anggota
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
