<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Pengaturan Harga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f8; color: #1f2937; margin: 0; }
        
        /* SIDEBAR */
        .sidebar { background-color: #ffffff; width: 260px; height: 100vh; position: fixed; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; z-index: 1000; }
        .sidebar-header { padding: 20px 25px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #e5e7eb; }
        .brand-icon { width: 35px; height: 35px; background-color: #218838; border-radius: 8px; display: flex; justify-content: center; align-items: center; color: white; }
        
        .menu-container { padding: 20px 0; overflow-y: auto; flex-grow: 1; }
        .menu-heading { font-size: 0.7rem; font-weight: 700; color: #9ca3af; letter-spacing: 1px; text-transform: uppercase; margin: 15px 25px 10px; }
        
       .menu-item { display: flex; align-items: center; gap: 12px; padding: 10px 25px; color: #4b5563; text-decoration: none; font-size: 0.95rem; font-weight: 500; border-left: 4px solid transparent; }
        .menu-item:hover { color: #218838; background-color: #f8f9fa; }
        .menu-item.active { background-color: #e8f5e9; color: #218838; border-left-color: #218838; font-weight: 600; }

        /* MAIN CONTENT */
        .main-wrapper { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background-color: #ffffff; height: 75px; display: flex; justify-content: space-between; align-items: center; padding: 0 35px; border-bottom: 1px solid #e5e7eb; position: sticky; top: 0; z-index: 999; }
        .topbar h4 { margin: 0; font-size: 1.25rem; font-weight: 700; color: #111827; }
        .content { padding: 35px; }
        .btn-add { background-color: #1b4332; color: white; font-weight: 600; font-size: 0.85rem; padding: 8px 16px; border-radius: 8px; border: none; }
        
        /* ALERT BOX */
        .alert-warning-custom { background-color: #fefce8; border: 1px solid #fef08a; color: #a16207; border-radius: 12px; padding: 16px 20px; font-size: 0.9rem; font-weight: 500; margin-bottom: 25px; }

        /* CARD & TABLES */
        .data-card { background: #ffffff; border-radius: 16px; border: 1px solid #e5e7eb; padding: 25px; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .card-title { font-size: 1.1rem; font-weight: 700; color: #111827; margin-bottom: 20px; }
        
        .table > :not(caption) > * > * { padding: 15px 10px; border-bottom-color: #f3f4f6; vertical-align: middle; }
        .table th { font-size: 0.75rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e5e7eb; }
        
        /* BADGES CATEGORY */
        .badge-kategori { padding: 6px 16px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .bg-plastik { background-color: #eff6ff; color: #2563eb; }
        .bg-kertas { background-color: #fefce8; color: #ca8a04; }
        .bg-logam { background-color: #f3f4f6; color: #4b5563; }
        .bg-kaca { background-color: #f3f4f6; color: #6b7280; }
        .bg-organik { background-color: #dcfce7; color: #166534; }
        
        /* BADGES STATUS */
        .status-aktif { background-color: #dcfce7; color: #166534; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .status-nonaktif { background-color: #fee2e2; color: #991b1b; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }

        /* INPUT & BUTTONS */
        .input-harga { width: 100px; border: 1px solid #d1d5db; border-radius: 8px; padding: 6px 12px; font-weight: 600; color: #1f2937; text-align: right; }
        .input-harga:focus { border-color: #1b4332; outline: none; box-shadow: 0 0 0 3px rgba(27, 67, 50, 0.1); }
        .btn-save { background-color: #1b4332; color: white; border: none; width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; transition: 0.2s; }
        .btn-save:hover { background-color: #123024; color: white; }
        .btn-save:disabled { background-color: #f3f4f6; color: #d1d5db; cursor: not-allowed; }
        
        /* LOG STYLING */
        .strike-price { text-decoration: line-through; color: #ef4444; font-weight: 500; }
        .new-price { color: #166534; font-weight: 700; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <div class="brand-icon">
                <i class="bi bi-circle-fill" style="font-size: 0.8rem;"></i>
            </div>
            <div style="line-height: 1.2;">
                <div style="font-weight: 700; color: #218838; font-size: 1.1rem;">SIMABAS</div>
                <div style="font-size: 0.75rem; color: #9ca3af;">Admin Panel</div>
            </div>
        </div>

        <div class="menu-container">
            <a href="{{ url('/admin/dashboard') }}" class="menu-item ">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('nasabah.index') }}" class="menu-item">
                <i class="bi bi-people"></i> Data Nasabah
            </a>
            <a href="{{ route('admin.harga.index') }}" class="menu-item active">
                <i class="bi bi-tags"></i> Harga Sampah
            </a>

            <a href="{{ route('admin.riwayat.index') }}" class="menu-item">
                <i class="bi bi-clock-history"></i> Riwayat Transaksi
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="menu-item">
                <i class="bi bi-file-earmark-pdf"></i> Laporan PDF
            </a>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="topbar">
            <h4>Pengaturan Harga Sampah</h4>
            
            <div class="d-flex align-items-center gap-2 dropdown" style="cursor: pointer;" data-bs-toggle="dropdown">
                <span style="font-size: 0.95rem; color: #1f2937;">
                    Halo, <span style="font-weight: 600; text-transform: uppercase;">{{ auth()->user()->username ?? 'ADMIN' }}</span>
                </span>
                <i class="bi bi-chevron-down text-secondary" style="font-size: 0.75rem;"></i>
            </div>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 py-2 px-3 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

    <div class="content">
        <div class="alert-warning-custom">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Perubahan harga tidak berlaku retroaktif pada transaksi yang sudah tersimpan.
        </div>

        <div class="data-card">
            <div class="table-responsive">
                <table class="table table-borderless mb-0">
                    <thead>
                        <tr>
                            <th width="20%">KATEGORI</th>
                            <th width="30%">HARGA/KG</th>
                            <th width="15%">STATUS</th>
                            <th width="10%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($harga_sampah as $item)
                        <tr>
                            <td>{{ $item->kategori }}</td>

                            <td>
                                <form id="form-{{ $item->id_jenis }}"
                                    action="{{ route('admin.harga.update', $item->id_jenis) }}"
                                    method="POST">
                                    @csrf

                                    <input type="number"
                                        name="harga_per_kg"
                                        value="{{ $item->harga_per_kg }}"
                                        class="input-harga">
                                </form>
                            </td>

                            <td>
                                @if($item->status_aktif == 1)
                                    <span class="status-aktif">Aktif</span>
                                @else
                                    <span class="status-nonaktif">Nonaktif</span>
                                @endif
                            </td>

                            <td>
                                <button type="submit"
                                        form="form-{{ $item->id_jenis }}"
                                        class="btn-save">
                                    <i class="bi bi-floppy-fill"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>