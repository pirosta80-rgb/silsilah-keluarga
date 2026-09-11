<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silsilah - {{ $individual->full_name }}</title>
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
        .parents-container {
            margin-bottom: 16px;
            border-bottom: 2px solid rgba(102, 126, 234, 0.2);
            padding-bottom: 12px;
        }
        .root-label {
            font-size: 12px;
            color: #a0aec0;
            font-weight: 500;
            margin-bottom: 4px;
        }
        .highlight-node {
            background: rgba(102, 126, 234, 0.12);
            border-radius: 8px;
            padding: 2px 0;
            border-left: 3px solid #667eea;
            padding-left: 8px;
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
        @media (max-width: 768px) {
            .header-gradient { padding: 16px 20px; }
            .children-container { padding-left: 20px; }
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
                        📋 Silsilah: <span class="text-yellow-200">{{ $individual->full_name }}</span>
                    </h1>
                    <p class="text-white/80 text-sm mt-1">Silsilah lengkap ke atas (orang tua) dan ke bawah (anak)</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('silsilah.cari-hubungan') }}" class="btn-outline">🔍 Cari Hubungan</a>
                    <a href="{{ route('family-tree.index') }}" class="btn-outline">🌳 Pohon</a>
                    <a href="{{ route('individuals.index') }}" class="btn-outline">📊 Database</a>
                    <a href="{{ route('silsilah.index') }}" class="btn-primary">⬅ Kembali</a>
                </div>
            </div>
        </div>

        <!-- Dropdown -->
        <div class="card p-4 mb-6">
            <div class="flex flex-col md:flex-row items-center gap-4">
                <div class="flex-1 w-full">
                    <label class="text-gray-600 text-sm font-medium block mb-1.5">🎯 Pilih Anggota Keluarga</label>
                    <div class="flex gap-3">
                        <select id="select-individual" class="flex-1 px-4 py-3 rounded-xl border border-gray-300 bg-white text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($allIndividuals as $ind)
                                <option value="{{ $ind->id }}" {{ $ind->id == $individual->id ? 'selected' : '' }}>
                                    {{ $ind->full_name }}
                                </option>
                            @endforeach
                        </select>
                        <button onclick="goToSelected()" class="btn-primary px-6 py-3 rounded-xl whitespace-nowrap">🔍 Tampilkan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tree Display -->
        <div class="card p-4 md:p-6">
            @if($tree)
                <div class="tree-list">
                    {!! renderTreeWithParents($tree) !!}
                </div>
            @else
                <div class="empty-state">
                    <div class="icon">🌱</div>
                    <h3>Tidak Ada Silsilah</h3>
                    <p>Data tidak ditemukan untuk {{ $individual->full_name }}</p>
                </div>
            @endif
        </div>

        <div class="mt-6 text-center text-gray-400 text-sm">
            💡 Klik nama anggota untuk melihat detail lengkap
        </div>
    </div>

    <script>
        function goToSelected() {
            const select = document.getElementById('select-individual');
            const id = select.value;
            if (id) {
                window.location.href = `/silsilah/${id}`;
            } else {
                window.location.href = `/silsilah`;
            }
        }
        document.getElementById('select-individual').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                goToSelected();
            }
        });
    </script>

    @php
        function renderTreeWithParents($node, $level = 0) {
            if (!$node) return '';

            $output = '';
            $genderIcon = $node['gender'] == 'male' ? '👨' : '👩';
            $badgeClass = $node['gender'] == 'male' ? 'badge-male' : 'badge-female';
            $genderText = $node['gender'] == 'male' ? 'Laki-laki' : 'Perempuan';

            // ============ PARENTS (KE ATAS) ============
            if (isset($node['parents'])) {
                $output .= '<div class="parents-container">';
                $output .= '<div class="root-label">⬆️ Orang Tua</div>';

                if ($node['parents']['father']) {
                    $output .= renderTreeWithParents($node['parents']['father'], $level);
                }
                if ($node['parents']['mother']) {
                    $output .= renderTreeWithParents($node['parents']['mother'], $level);
                }
                $output .= '</div>';
            }

            // ============ CURRENT PERSON (HIGHLIGHT) ============
            $output .= '<div class="tree-item highlight-node">';
            $output .= '<div class="person" onclick="window.location.href=\'/individuals/'.$node['id'].'\'">';
            $output .= '<span class="gender-icon">'.$genderIcon.'</span>';
            $output .= '<span class="name" style="font-weight:700;color:#667eea;">⭐ '.$node['name'].'</span>';
            if ($node['birth_date']) {
                $output .= '<span class="badge-date">('.\Carbon\Carbon::parse($node['birth_date'])->format('d/m/Y').')</span>';
            }
            if ($node['death_date']) {
                $output .= '<span class="badge-date">🕊️ '.\Carbon\Carbon::parse($node['death_date'])->format('d/m/Y').'</span>';
            }
            $output .= '<span class="badge-gender '.$badgeClass.'">'.$genderText.'</span>';
            $output .= '</div>';

            // ============ SPOUSE ============
            if ($node['spouse']) {
                $spouseIcon = $node['spouse']['gender'] == 'male' ? '👨' : '👩';
                $spouseBadge = $node['spouse']['gender'] == 'male' ? 'badge-male' : 'badge-female';
                $spouseGender = $node['spouse']['gender'] == 'male' ? 'Laki-laki' : 'Perempuan';
                $output .= '<div class="person" onclick="window.location.href=\'/individuals/'.$node['spouse']['id'].'\'" style="padding-left: 28px; opacity: 0.85;">';
                $output .= '<span class="gender-icon">💑</span>';
                $output .= '<span class="spouse-label">Pasangan:</span>';
                $output .= '<span class="spouse-name">'.$node['spouse']['name'].'</span>';
                if ($node['spouse']['birth_date']) {
                    $output .= '<span class="badge-date">('.\Carbon\Carbon::parse($node['spouse']['birth_date'])->format('d/m/Y').')</span>';
                }
                if ($node['spouse']['death_date']) {
                    $output .= '<span class="badge-date">🕊️ '.\Carbon\Carbon::parse($node['spouse']['death_date'])->format('d/m/Y').'</span>';
                }
                $output .= '<span class="badge-gender '.$spouseBadge.'">'.$spouseGender.'</span>';
                $output .= '</div>';
            }

            // ============ CHILDREN (KE BAWAH) ============
            if (!empty($node['children']) && count($node['children']) > 0) {
                $output .= '<div class="children-container">';
                $output .= '<div class="root-label" style="margin-top:8px;">⬇️ Anak-anak</div>';
                foreach ($node['children'] as $child) {
                    $output .= renderTreeWithParents($child, $level + 1);
                }
                $output .= '</div>';
            }

            $output .= '</div>';
            return $output;
        }
    @endphp
</body>
</html>
