<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pohon Keluarga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vis-network/9.1.0/dist/dist/vis-network.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vis-network/9.1.0/dist/vis-network.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #f8fafc;
        }

        .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            color: #e2e8f0;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            transition: all 0.3s ease;
            color: white;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.5);
        }

        select {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #f8fafc;
            padding: 10px 16px;
            border-radius: 12px;
            transition: all 0.3s ease;
            width: 100%;
        }

        select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
        }

        select option {
            background: #0f172a;
            color: #f8fafc;
        }

        #network {
            width: 100%;
            height: 600px;
            border-radius: 16px;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .vis-network {
            border-radius: 16px;
        }

        .vis-tooltip {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            color: #f8fafc !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
        }

        .empty-state {
            color: #94a3b8;
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state .icon {
            font-size: 64px;
            margin-bottom: 16px;
        }

        .empty-state h3 {
            font-size: 20px;
            color: #e2e8f0;
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            color: #94a3b8;
        }

        .loading {
            color: #94a3b8;
            text-align: center;
            padding: 60px 20px;
        }

        .loading .spinner {
            font-size: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 768px) {
            #network {
                height: 400px;
            }
        }
    </style>
</head>

<body class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="glass rounded-2xl p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-slate-100">🌳 Pohon Keluarga</h1>
                    <p class="text-slate-400 text-sm mt-1">Visualisasi silsilah dengan zoom & drag</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('dashboard') }}" class="btn-glass">
                        🔙 Kembali ke Dashboard
                    </a>
                    <a href="{{ route('individuals.index') }}" class="btn-glass">
                        📋 Database
                    </a>
                    @if (Auth::guard('admin')->check())
                        <a href="{{ route('admin.individuals.create') }}" class="btn-primary">
                            ➕ Tambah Anggota
                        </a>
                    @else
                        <a href="{{ route('admin.login') }}" class="btn-primary">
                            🔒 Login
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Controls -->
        <div class="glass rounded-2xl p-6 mb-6">
            <div class="flex flex-col md:flex-row items-center gap-4">
                <div class="flex-1 w-full">
                    <label class="text-slate-300 text-sm block mb-1.5 font-medium">Pilih Root (Pusat Pohon)</label>
                    <select id="root-select">
                        @foreach ($individuals as $individual)
                            <option value="{{ $individual->id }}">{{ $individual->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-3 w-full md:w-auto mt-2 md:mt-5">
                    <button onclick="loadTree()" class="btn-primary flex-1 md:flex-none">
                        🔄 Tampilkan
                    </button>
                    <button onclick="resetView()" class="btn-glass flex-1 md:flex-none">
                        🔍 Reset Zoom
                    </button>
                    <button onclick="expandAll()" class="btn-glass flex-1 md:flex-none">
                        📖 Semua
                    </button>
                </div>
            </div>
        </div>

        <!-- Network -->
        <div class="glass rounded-2xl p-6">
            <div id="network"></div>
        </div>

        <!-- Legend -->
        <div class="mt-6 flex flex-wrap gap-4 justify-center">
            <div class="flex items-center gap-2 text-slate-300 text-sm font-medium">
                <span class="w-4 h-4 rounded bg-blue-500"></span>
                Laki-laki
            </div>
            <div class="flex items-center gap-2 text-slate-300 text-sm font-medium">
                <span class="w-4 h-4 rounded-full bg-pink-500"></span>
                Perempuan
            </div>
            <div class="flex items-center gap-2 text-slate-300 text-sm font-medium">
                <span class="w-8 h-0.5 bg-slate-400"></span>
                Orang Tua → Anak
            </div>
            <div class="flex items-center gap-2 text-slate-300 text-sm font-medium">
                <span class="w-8 h-0.5 border-t-2 border-dashed border-red-400"></span>
                Pernikahan
            </div>
        </div>

        <div class="mt-4 text-slate-400 text-sm text-center">
            💡 Klik nama untuk melihat detail • Drag untuk geser • Scroll untuk zoom
        </div>
    </div>

    <script>
        let network = null;
        let nodes = null;
        let edges = null;
        const container = document.getElementById('network');

        function initNetwork() {
            const options = {
                layout: {
                    hierarchical: {
                        enabled: true,
                        direction: 'UD',
                        sortMethod: 'directed',
                        levelSeparation: 150,
                        nodeSpacing: 120,
                        treeSpacing: 200,
                        blockShifting: true,
                        edgeMinimization: true,
                        parentCentralization: true
                    }
                },
                physics: {
                    enabled: false // Disable physics for stable layout
                },
                interaction: {
                    dragNodes: true,
                    dragView: true,
                    zoomView: true,
                    hover: true,
                    tooltipDelay: 200
                },
                nodes: {
                    margin: 10,
                    widthConstraint: {
                        minimum: 50,
                        maximum: 200
                    },
                    font: {
                        size: 14,
                        color: '#ffffff'
                    },
                    shadow: true,
                    borderWidth: 2
                },
                edges: {
                    smooth: {
                        type: 'straight' // Straight lines, not curved
                    },
                    width: 2
                }
            };

            nodes = new vis.DataSet([]);
            edges = new vis.DataSet([]);
            network = new vis.Network(container, {
                nodes,
                edges
            }, options);

            network.on('click', function(params) {
                if (params.nodes.length > 0) {
                    const nodeId = params.nodes[0];
                    window.location.href = `/individuals/${nodeId}`;
                }
            });
        }

        function loadTree() {
            const rootId = document.getElementById('root-select').value;
            if (!rootId) {
                alert('Silakan pilih anggota keluarga terlebih dahulu!');
                return;
            }

            const container = document.getElementById('network');
            container.innerHTML = `
                <div class="loading">
                    <div class="spinner">🌳</div>
                    <p>Memuat pohon keluarga...</p>
                </div>
            `;

            fetch(`/api/family-tree?root_id=${rootId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.nodes.length === 0) {
                        container.innerHTML = `
                            <div class="empty-state">
                                <div class="icon">🌱</div>
                                <h3>Belum Ada Data</h3>
                                <p>Tambahkan anggota keluarga terlebih dahulu</p>
                            </div>
                        `;
                        return;
                    }

                    // Re-initialize network if needed
                    if (!network) {
                        initNetwork();
                    }

                    nodes.clear();
                    edges.clear();
                    nodes.add(data.nodes);
                    edges.add(data.edges);

                    // Fit network to view
                    network.fit({
                        animation: {
                            duration: 1000,
                            easingFunction: 'easeInOutQuad'
                        }
                    });

                    // Make container show network again
                    container.innerHTML = '';
                    container.appendChild(network.canvas.frame);
                })
                .catch(error => {
                    console.error('Error:', error);
                    container.innerHTML = `
                        <div class="empty-state">
                            <div class="icon">⚠️</div>
                            <h3>Gagal Memuat Data</h3>
                            <p>Terjadi kesalahan saat memuat pohon keluarga</p>
                        </div>
                    `;
                });
        }

        function resetView() {
            if (network) {
                network.fit({
                    animation: {
                        duration: 500,
                        easingFunction: 'easeInOutQuad'
                    }
                });
            }
        }

        function expandAll() {
            // Load all without root filter
            const container = document.getElementById('network');
            container.innerHTML = `
                <div class="loading">
                    <div class="spinner">🌳</div>
                    <p>Memuat semua data...</p>
                </div>
            `;

            fetch('/api/family-tree')
                .then(response => response.json())
                .then(data => {
                    if (data.nodes.length === 0) {
                        container.innerHTML = `
                            <div class="empty-state">
                                <div class="icon">🌱</div>
                                <h3>Belum Ada Data</h3>
                                <p>Tambahkan anggota keluarga terlebih dahulu</p>
                            </div>
                        `;
                        return;
                    }

                    if (!network) {
                        initNetwork();
                    }

                    nodes.clear();
                    edges.clear();
                    nodes.add(data.nodes);
                    edges.add(data.edges);

                    network.fit({
                        animation: {
                            duration: 1000,
                            easingFunction: 'easeInOutQuad'
                        }
                    });

                    container.innerHTML = '';
                    container.appendChild(network.canvas.frame);
                })
                .catch(error => {
                    console.error('Error:', error);
                    container.innerHTML = `
                        <div class="empty-state">
                            <div class="icon">⚠️</div>
                            <h3>Gagal Memuat Data</h3>
                            <p>Terjadi kesalahan saat memuat pohon keluarga</p>
                        </div>
                    `;
                });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initNetwork();
            const select = document.getElementById('root-select');
            if (select.options.length > 0) {
                setTimeout(() => loadTree(), 500);
            } else {
                const container = document.getElementById('network');
                container.innerHTML = `
                    <div class="empty-state">
                        <div class="icon">🌱</div>
                        <h3>Belum Ada Anggota Keluarga</h3>
                        <p>Silakan tambahkan anggota keluarga terlebih dahulu</p>
                    </div>
                `;
            }
        });

        // Reload when select changes
        document.getElementById('root-select').addEventListener('change', loadTree);
    </script>
</body>

</html>
