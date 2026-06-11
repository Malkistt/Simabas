<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #1f2937; margin: 0; padding: 0; }
        
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

        /* STAT CARDS */
        .stat-card { background: #ffffff; border-radius: 12px; padding: 25px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.02); height: 100%; }
        .stat-title { font-size: 0.75rem; font-weight: 700; color: #6b7280; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 12px; }
        .stat-value { font-size: 2rem; font-weight: 700; color: #111827; margin-bottom: 8px; line-height: 1; }
        .stat-desc { font-size: 0.8rem; color: #28a745; display: flex; align-items: center; gap: 4px;}

        /* TABLE CARD */
        .table-card { background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .table-title { font-size: 1.1rem; font-weight: 700; color: #111827; margin: 0; }
        .btn-lihat { border: 1px solid #28a745; color: #28a745; background: transparent; padding: 6px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: 0.2s; }
        .btn-lihat:hover { background: #28a745; color: white; }

        /* TABLE STYLING */
        .table > :not(caption) > * > * { padding: 16px 10px; border-bottom-color: #f3f4f6; }
        .table th { font-size: 0.75rem; font-weight: 700; color: #111827; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e5e7eb; }
        .table td { font-size: 0.95rem; font-weight: 500; color: #1f2937; vertical-align: middle; }
        
        .badge-setor { background-color: #d1fae5; color: #065f46; padding: 6px 16px; font-weight: 600; font-size: 0.8rem; border-radius: 20px; }
        .badge-tarik { background-color: #fee2e2; color: #991b1b; padding: 6px 16px; font-weight: 600; font-size: 0.8rem; border-radius: 20px; }
        
        .text-green { color: #10b981 !important; font-weight: 700; }
        .text-red { color: #ef4444 !important; font-weight: 700; }
        
        /* Zebra stripe for table (like image) */
        .table-striped > tbody > tr:nth-of-type(odd) > * { background-color: transparent; }
        .table-striped > tbody > tr:nth-of-type(even) > * { background-color: #f9fafb; border-radius: 8px; }
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
            <a href="#" class="menu-item active">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('nasabah.index') }}" class="menu-item">
                <i class="bi bi-people"></i> Data Nasabah
            </a>
            <a href="{{ route('admin.harga.index') }}" class="menu-item">
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
            <h4>Dashboard Statistik</h4>
            
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
            
            <div class="row g-4 mb-4">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-title">TOTAL NASABAH</div>
                        <div class="stat-value">{{ $total_nasabah }}</div>
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-title">TOTAL PETUGAS</div>
                        <div class="stat-value">{{ $total_petugas }}</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-title">TOTAL TRANSAKSI</div>
                        <div class="stat-value">{{ number_format($total_transaksi, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-title">TOTAL SALDO</div>
                        <div class="stat-value">{{ $format_saldo }}</div>
                    </div>
                </div>
            </div>

            <div class="table-card">
                <div class="table-header">
                    <h5 class="table-title">Transaksi Terbaru</h5>
                    <a href="{{ route('admin.riwayat.index') }}" class="btn-lihat">Lihat Semua</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-striped mb-0">
                        <thead>
                            <tr>
                                <th>TANGGAL</th>
                                <th>JENIS</th>
                                <th>NASABAH</th>
                                <th class="text-end">NOMINAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksi_terbaru as $trx)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($trx->tgl_transaksi)->locale('id')->isoFormat('D MMMM Y') }}</td>
                                
                                <td>
                                    @if($trx->tipe_transaksi == 'setoran')
                                        <span class="badge-setor">Setor</span>
                                    @else
                                        <span class="badge-tarik">Tarik</span>
                                    @endif
                                </td>

                                <td>{{ $trx->nama_nasabah }}</td>
                                
                                <td class="text-end">
                                    @if($trx->tipe_transaksi == 'setoran')
                                        <span class="text-green">+ Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-red">- Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada transaksi tercatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>