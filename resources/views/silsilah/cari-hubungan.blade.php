<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Hubungan Keluarga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            padding: 12px 32px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
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

        select {
            background: white;
            border: 1px solid #e2e8f0;
            color: #2d3748;
            padding: 12px 16px;
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

        .result-box {
            background: linear-gradient(135deg, #ebf4ff 0%, #f3e8ff 100%);
            border-radius: 12px;
            padding: 20px 24px;
            border: 2px solid rgba(102, 126, 234, 0.2);
            min-height: 80px;
            display: flex;
            align-items: center;
        }

        .result-box .icon {
            font-size: 40px;
            margin-right: 16px;
        }

        .result-box .text {
            font-size: 16px;
            color: #2d3748;
            line-height: 1.6;
        }

        .result-box .text .highlight {
            font-weight: 700;
            color: #667eea;
        }

        .result-box .text .highlight-red {
            font-weight: 700;
            color: #e53e3e;
        }

        .result-box .text .highlight-green {
            font-weight: 700;
            color: #38a169;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .loading .spinner {
            font-size: 32px;
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            100% { transform: rotate(360deg); }
        }

        .error-box {
            background: #fff5f5;
            border: 1px solid #feb2b2;
            border-radius: 12px;
            padding: 16px 20px;
            color: #c53030;
            display: none;
        }

        @media (max-width: 768px) {
            .header-gradient {
                padding: 16px 20px;
            }

            .result-box {
                flex-direction: column;
                text-align: center;
            }

            .result-box .icon {
                margin-right: 0;
                margin-bottom: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="header-gradient mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white drop-shadow-lg">
                        🔍 Cari Hubungan Keluarga
                    </h1>
                    <p class="text-white/80 text-sm mt-1">Cari tahu hubungan antara dua anggota keluarga</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('silsilah.index') }}" class="btn-outline">
                        📋 Daftar Silsilah
                    </a>
                    <a href="{{ route('family-tree.index') }}" class="btn-outline">
                        🌳 Pohon Keluarga
                    </a>
                    <a href="{{ route('individuals.index') }}" class="btn-outline">
                        📊 Database
                    </a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card p-6 mb-6">
            <form id="searchForm" onsubmit="searchRelationship(event)">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            👤 Orang Pertama
                        </label>
                        <select id="person1" required>
                            <option value="">- Pilih Anggota -</option>
                            @foreach($individuals as $individual)
                                <option value="{{ $individual->id }}">{{ $individual->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            👤 Orang Kedua
                        </label>
                        <select id="person2" required>
                            <option value="">- Pilih Anggota -</option>
                            @foreach($individuals as $individual)
                                <option value="{{ $individual->id }}">{{ $individual->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-center mt-6">
                    <button type="submit" class="btn-primary" id="searchBtn">
                        🔍 Cari Hubungan
                    </button>
                </div>
            </form>
        </div>

        <!-- Loading -->
        <div id="loadingContainer" class="loading">
            <div class="spinner">🔍</div>
            <p class="text-gray-500 mt-2">Mencari hubungan...</p>
        </div>

        <!-- Result -->
        <div id="resultContainer" style="display: none;">
            <div class="card p-6">
                <div id="resultContent" class="result-box">
                    <div class="icon" id="resultIcon">🔗</div>
                    <div class="text" id="resultText"></div>
                </div>
            </div>
        </div>

        <!-- Error -->
        <div id="errorContainer" class="error-box mt-4">
            <span id="errorText">Terjadi kesalahan. Silakan coba lagi.</span>
        </div>
    </div>

    <script>
        function searchRelationship(event) {
            event.preventDefault();

            const person1Id = document.getElementById('person1').value;
            const person2Id = document.getElementById('person2').value;

            // Reset error
            document.getElementById('errorContainer').style.display = 'none';

            if (!person1Id || !person2Id) {
                alert('Silakan pilih kedua anggota keluarga!');
                return;
            }

            if (person1Id === person2Id) {
                alert('Pilih dua orang yang berbeda!');
                return;
            }

            // Show loading
            document.getElementById('loadingContainer').style.display = 'block';
            document.getElementById('resultContainer').style.display = 'none';
            document.getElementById('searchBtn').disabled = true;
            document.getElementById('searchBtn').textContent = '⏳ Mencari...';

            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').content;

            fetch('{{ route("silsilah.find-relationship") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    person1_id: person1Id,
                    person2_id: person2Id
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('loadingContainer').style.display = 'none';
                document.getElementById('searchBtn').disabled = false;
                document.getElementById('searchBtn').textContent = '🔍 Cari Hubungan';

                const resultContainer = document.getElementById('resultContainer');
                const resultText = document.getElementById('resultText');
                const resultIcon = document.getElementById('resultIcon');

                resultContainer.style.display = 'block';

                if (data.found) {
                    resultIcon.textContent = '🔗';
                    resultText.innerHTML = `<span class="highlight">${data.person1}</span> dan <span class="highlight">${data.person2}</span> memiliki hubungan: <br><span class="highlight-green">${data.relationship}</span>`;
                } else {
                    resultIcon.textContent = '😕';
                    resultText.innerHTML = `<span class="highlight-red">${data.message}</span>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loadingContainer').style.display = 'none';
                document.getElementById('searchBtn').disabled = false;
                document.getElementById('searchBtn').textContent = '🔍 Cari Hubungan';

                document.getElementById('errorContainer').style.display = 'block';
                document.getElementById('errorText').textContent = 'Terjadi kesalahan: ' + error.message;

                // Show error in result as well
                document.getElementById('resultContainer').style.display = 'block';
                document.getElementById('resultIcon').textContent = '⚠️';
                document.getElementById('resultText').innerHTML = '<span class="highlight-red">Terjadi kesalahan. Silakan coba lagi.</span>';
            });
        }

        // Auto-submit on enter
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const form = document.getElementById('searchForm');
                if (form && document.activeElement && (document.activeElement.tagName === 'SELECT')) {
                    e.preventDefault();
                    searchRelationship(e);
                }
            }
        });
    </script>
</body>
</html>
