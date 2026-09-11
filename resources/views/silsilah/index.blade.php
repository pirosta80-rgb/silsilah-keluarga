<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silsilah Keluarga - Daftar</title>
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

        .btn-secondary {
            background: rgba(102, 126, 234, 0.1);
            color: #4a5568;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid rgba(102, 126, 234, 0.2);
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
        }

        select {
            background: white;
            border: 1px solid #e2e8f0;
            color: #2d3748;
            padding: 10px 16px;
            border-radius: 12px;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 14px;
        }

        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        select option {
            background: white;
            color: #2d3748;
        }

        .tree-list {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .tree-item {
            padding: 4px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .tree-item:hover {
            background: rgba(102, 126, 234, 0.03);
            border-radius: 8px;
        }

        .tree-item .person {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .tree-item .person:hover {
            background: rgba(102, 126, 234, 0.08);
        }

        .tree-item .person .gender-icon {
            font-size: 18px;
            width: 28px;
            text-align: center;
        }

        .tree-item .person .name {
            font-weight: 500;
            color: #2d3748;
            font-size: 15px;
        }

        .tree-item .person .name:hover {
            color: #667eea;
        }

        .tree-item .person .badge-date {
            font-size: 12px;
            color: #a0aec0;
            margin-left: 4px;
        }

        .tree-item .person .badge-gender {
            font-size: 11px;
            padding: 2px 10px;
            border-radius: 12px;
            font-weight: 500;
            margin-left: 8px;
        }

        .badge-male {
            background: #ebf5ff;
            color: #3182ce;
        }

        .badge-female {
            background: #fdf2f8;
            color: #d53f8c;
        }

        .tree-item .person .spouse-label {
            font-size: 12px;
            color: #a0aec0;
            margin-left: 4px;
        }

        .tree-item .person .spouse-name {
            font-weight: 500;
            color: #4a5568;
        }

        .children-container {
            padding-left: 36px;
            border-left: 2px solid rgba(102, 126, 234, 0.15);
            margin-left: 12px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state .icon {
            font-size: 64px;
            margin-bottom: 16px;
        }

        .empty-state h3 {
            font-size: 20px;
            color: #4a5568;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #a0aec0;
            font-size: 14px;
        }

        .selected-label {
            font-size: 14px;
            color: #4a5568;
            font-weight: 600;
            padding: 8px 16px;
            background: rgba(102, 126, 234, 0.08);
            border-radius: 8px;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .header-gradient {
                padding: 16px 20px;
            }

            .tree-item .person .badge-gender {
                font-size: 10px;
                padding: 1px 8px;
            }

            .children-container {
                padding-left: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="max-w-5xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="header-gradient mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white drop-shadow-lg">
                        📋 Silsilah Keluarga
                    </h1>
                    <p class="text-white/80 text-sm mt-1">Tampilkan keluarga inti (suami, istri, dan anak)</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    @if(Auth::guard('admin')->check())
                        <span class="bg-green-500/30 text-green-100 px-3 py-1 rounded-full text-xs font-semibold">
                            🔐 {{ Auth::guard('admin')->user()->name }}
                        </span>
                    @else
                        <span class="bg-amber-500/30 text-amber-100 px-3 py-1 rounded-full text-xs font-semibold">
                            👤 Tamu
                        </span>
                    @endif
                    <a href="{{ route('dashboard') }}" class="btn-outline">
                        🏠 Dashboard
                    </a>
                    <a href="{{ route('silsilah.cari-hubungan') }}" class="btn-outline">
                        🔍 Cari Hubungan
                    </a>
                    <a href="{{ route('family-tree.index') }}" class="btn-outline">
                        🌳 Pohon Keluarga
                    </a>
                    <a href="{{ route('individuals.index') }}" class="btn-outline">
                        📊 Database
                    </a>
                    @if(Auth::guard('admin')->check())
                        <a href="{{ route('admin.individuals.create') }}" class="btn-primary">
                            ➕ Tambah
                        </a>
                    @else
                        <a href="{{ route('admin.login') }}" class="btn-primary">
                            🔒 Login
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Info Tamu -->
        @if(!Auth::guard('admin')->check())
            <div class="card p-4 mb-6 border-l-4 border-amber-400">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">ℹ️</span>
                    <div>
                        <div class="font-semibold text-gray-700 text-sm">Mode Tamu</div>
                        <div class="text-gray-500 text-sm mt-1">
                            Anda hanya bisa melihat data.
                            <a href="{{ route('admin.login') }}" class="text-blue-600 hover:text-blue-800 font-semibold underline">
                                Login sebagai admin
                            </a>
                            untuk mengelola data.
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Dropdown Pilih Nama -->
        <div class="card p-4 mb-6">
            <div class="flex flex-col md:flex-row items-center gap-4">
                <div class="flex-1 w-full">
                    <label class="text-gray-600 text-sm font-medium block mb-1.5">
                        🎯 Pilih Anggota Keluarga
                    </label>
                    <div class="flex gap-3">
                        <select id="select-individual" class="flex-1 px-4 py-3 rounded-xl border border-gray-300 bg-white text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                            @foreach($allIndividuals as $ind)
                                <option value="{{ $ind->id }}" {{ request('id') == $ind->id ? 'selected' : '' }}>
                                    {{ $ind->full_name }}
                                </option>
                            @endforeach
                        </select>
                        <button onclick="goToSelected()" class="btn-primary px-6 py-3 rounded-xl whitespace-nowrap">
                            🔍 Tampilkan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selected Info -->
        <div class="mb-4 text-center">
            <span class="selected-label">
                👤 Menampilkan keluarga dari:
                <span class="text-blue-600">
                    {{ $allIndividuals->firstWhere('id', request('id'))?->full_name ?? ($allIndividuals->first()->full_name ?? 'Pilih anggota') }}
                </span>
            </span>
        </div>

        <!-- Tree Display -->
        <div class="card p-4 md:p-6">
            @if(!empty($trees) && count($trees) > 0)
                <div class="tree-list">
                    @foreach($trees as $index => $tree)
                        @if($index > 0)
                            <hr class="my-8 border-t-2 border-gray-300 border-dashed">
                            <div class="text-center text-gray-400 text-sm mb-4">--- Cabang Keluarga Lain ---</div>
                        @endif
                        {!! renderTree($tree) !!}
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="icon">🌱</div>
                    <h3>Belum Ada Data</h3>
                    <p>Pilih anggota keluarga atau tambahkan data terlebih dahulu</p>
                    @if(Auth::guard('admin')->check())
                        <a href="{{ route('admin.individuals.create') }}" class="btn-primary inline-block mt-4">
                            ➕ Tambah Anggota Keluarga
                        </a>
                    @else
                        <a href="{{ route('admin.login') }}" class="btn-primary inline-block mt-4">
                            🔒 Login untuk Tambah
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Info -->
        <div class="mt-6 text-center text-gray-400 text-sm">
            💡 Klik nama anggota untuk melihat detail lengkap
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center text-gray-400 text-xs">
            © {{ date('Y') }} Silsilah Keluarga
            @if(!Auth::guard('admin')->check())
                • <a href="{{ route('admin.login') }}" class="hover:text-gray-600 transition-colors">🔒 Login Admin</a>
            @endif
        </div>
    </div>

    <script>
        function goToSelected() {
            const select = document.getElementById('select-individual');
            const id = select.value;
            if (id) {
                window.location.href = `/silsilah?id=${id}`;
            }
        }

        document.getElementById('select-individual').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                goToSelected();
            }
        });
    </script>

    <!-- Helper untuk render tree -->
    @php
        function renderTree($node, $level = 0) {
            if (!$node) return '';

            $output = '';
            $genderIcon = $node['gender'] == 'male' ? '👨' : '👩';
            $badgeClass = $node['gender'] == 'male' ? 'badge-male' : 'badge-female';
            $genderText = $node['gender'] == 'male' ? 'Laki-laki' : 'Perempuan';

            // Main person
            $output .= '<div class="tree-item">';
            $output .= '<div class="person" onclick="window.location.href=\'/individuals/'.$node['id'].'\'">';
            $output .= '<span class="gender-icon">'.$genderIcon.'</span>';
            $output .= '<span class="name">'.$node['name'].'</span>';
            if (isset($node['birth_date']) && $node['birth_date']) {
                $output .= '<span class="badge-date">('.\Carbon\Carbon::parse($node['birth_date'])->format('d/m/Y').')</span>';
            }
            if (isset($node['death_date']) && $node['death_date']) {
                $output .= '<span class="badge-date">🕊️ '.\Carbon\Carbon::parse($node['death_date'])->format('d/m/Y').'</span>';
            }
            $output .= '<span class="badge-gender '.$badgeClass.'">'.$genderText.'</span>';
            $output .= '</div>';

            // Spouse
            if (isset($node['spouse']) && $node['spouse']) {
                $spouseIcon = $node['spouse']['gender'] == 'male' ? '👨' : '👩';
                $spouseBadge = $node['spouse']['gender'] == 'male' ? 'badge-male' : 'badge-female';
                $spouseGender = $node['spouse']['gender'] == 'male' ? 'Laki-laki' : 'Perempuan';
                $output .= '<div class="person" onclick="window.location.href=\'/individuals/'.$node['spouse']['id'].'\'" style="padding-left: 28px; opacity: 0.85;">';
                $output .= '<span class="gender-icon">💑</span>';
                $output .= '<span class="spouse-label">Pasangan:</span>';
                $output .= '<span class="spouse-name">'.$node['spouse']['name'].'</span>';
                if (isset($node['spouse']['birth_date']) && $node['spouse']['birth_date']) {
                    $output .= '<span class="badge-date">('.\Carbon\Carbon::parse($node['spouse']['birth_date'])->format('d/m/Y').')</span>';
                }
                if (isset($node['spouse']['death_date']) && $node['spouse']['death_date']) {
                    $output .= '<span class="badge-date">🕊️ '.\Carbon\Carbon::parse($node['spouse']['death_date'])->format('d/m/Y').'</span>';
                }
                $output .= '<span class="badge-gender '.$spouseBadge.'">'.$spouseGender.'</span>';
                $output .= '</div>';
            }

            // Children
            if (!empty($node['children']) && count($node['children']) > 0) {
                $output .= '<div class="children-container">';
                foreach ($node['children'] as $child) {
                    $output .= renderTree($child, $level + 1);
                }
                $output .= '</div>';
            }

            $output .= '</div>';
            return $output;
        }
    @endphp
</body>
</html>
