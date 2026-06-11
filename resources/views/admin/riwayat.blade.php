<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Riwayat Transaksi</title>
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

        /* TABS (Semua, Setoran, Penarikan) */
        .tab-group { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 20px; display: flex; overflow: hidden; }
        .tab-btn { padding: 6px 16px; font-size: 0.8rem; font-weight: 600; color: #6b7280; text-decoration: none; border-right: 1px solid #e5e7eb; transition: 0.2s; }
        .tab-btn:last-child { border-right: none; }
        .tab-btn.active { background-color: #1b4332; color: white; }
        .tab-btn:hover:not(.active) { background-color: #f3f4f6; }

        /* FILTER BOX */
        .filter-box { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; }
        .form-control-custom { border: 1px solid #d1d5db; border-radius: 8px; padding: 8px 12px; font-size: 0.85rem; }
        .form-control-custom:focus { border-color: #1b4332; box-shadow: 0 0 0 3px rgba(27, 67, 50, 0.1); outline: none; }
        .btn-filter { background-color: #1b4332; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; }
        .btn-export { background-color: #ffffff; color: #1b4332; border: 1px solid #d1d5db; padding: 8px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 6px; }

        /* TABLE STYLING */
        .data-card { background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .table > :not(caption) > * > * { padding: 15px 10px; border-bottom-color: #f3f4f6; vertical-align: middle; }
        .table th { font-size: 0.75rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e5e7eb; }
        .table td { font-size: 0.85rem; font-weight: 500; color: #374151; }
        
        /* BADGES JENIS */
        .badge-setor { background-color: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; border: 1px solid #bbf7d0; }
        .badge-tarik { background-color: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; border: 1px solid #fecaca; }

        .text-setor { color: #166534; }
        .text-tarik { color: #dc2626; }
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
            <a href="{{ url('/admin/dashboard') }}" class="menu-item">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('nasabah.index') }}" class="menu-item">
                <i class="bi bi-people"></i> Data Nasabah
            </a>
            <a href="{{ route('admin.harga.index') }}" class="menu-item">
                <i class="bi bi-tags"></i> Harga Sampah
            </a>

            <a href="{{ route('admin.riwayat.index') }}" class="menu-item active">
                <i class="bi bi-clock-history"></i> Riwayat Transaksi
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="menu-item">
                <i class="bi bi-file-earmark-pdf"></i> Laporan PDF
            </a>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="topbar">
            <h4>Riwayat Transaksi</h4>
            
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

        <div class="content">
           <form action="{{ route('admin.riwayat.index') }}" method="GET" class="mb-4">
                <input type="hidden" name="jenis" value="{{ request('jenis', 'Semua') }}">
                
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        
                        <div class="d-flex align-items-center gap-2">
                            <input type="date" name="tgl_mulai" class="form-control-custom" value="{{ request('tgl_mulai') }}">
                            <span class="text-muted small fw-medium">s/d</span>
                            <input type="date" name="tgl_akhir" class="form-control-custom" value="{{ request('tgl_akhir') }}">
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <input type="text" name="cari" class="form-control-custom" placeholder="Cari nasabah..." value="{{ request('cari') }}" style="min-width: 180px;">
                            <button type="submit" class="btn-filter px-3">
                                <i class="bi bi-funnel-fill me-1"></i> Filter
                            </button>
                        </div>
                        
                    </div>

                    <div class="tab-group d-flex">
                        <a href="{{ request()->fullUrlWithQuery(['jenis' => 'Semua']) }}" class="tab-btn {{ request('jenis', 'Semua') == 'Semua' ? 'active' : '' }}">Semua</a>
                        <a href="{{ request()->fullUrlWithQuery(['jenis' => 'Setoran']) }}" class="tab-btn {{ request('jenis') == 'Setoran' ? 'active' : '' }}">Setoran</a>
                        <a href="{{ request()->fullUrlWithQuery(['jenis' => 'Penarikan']) }}" class="tab-btn {{ request('jenis') == 'Penarikan' ? 'active' : '' }}">Penarikan</a>
                    </div>

                </div>
            </form>

            <div class="data-card">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>TANGGAL</th>
                                <th>JENIS</th>
                                <th>NASABAH</th>
                                <th>KETERANGAN</th>
                                <th>NOMINAL</th>
                                <th>METODE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $index => $trx)
                            <tr>
                                <td class="text-muted">#{{ str_pad($trx->id_transaksi, 3, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ \Carbon\Carbon::parse($trx->tgl_transaksi)->format('d/m/y H:i') }}</td>
                                
                                <td>
                                    @if($trx->tipe_transaksi == 'setoran')
                                        <span class="badge-setor">Setor</span>
                                    @else
                                        <span class="badge-tarik">Tarik</span>
                                    @endif
                                </td>
                                
                                <td class="fw-bold text-dark">{{ $trx->nama_nasabah }}</td>
                                <td class="text-muted">{{ $trx->keterangan ?? '-' }}</td>
                                
                                <td class="fw-bold {{ $trx->tipe_transaksi == 'setoran' ? 'text-setor' : 'text-tarik' }}">
                                    {{ $trx->tipe_transaksi == 'setoran' ? '+' : '-' }}{{ number_format($trx->total_nilai, 0, ',', '.') }}
                                </td>
                                
                                <td class="text-muted">{{ $trx->tipe_transaksi == 'setoran' ? 'Bank Sampah' : 'Tunai' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">Belum ada data transaksi yang ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div style="font-size: 0.8rem; color: #9ca3af;">
                        Menampilkan {{ $riwayat->firstItem() ?? 0 }}-{{ $riwayat->lastItem() ?? 0 }} dari {{ $riwayat->total() }} data
                    </div>
                    <div>
                        {{ $riwayat->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>