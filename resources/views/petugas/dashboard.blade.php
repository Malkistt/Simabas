<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Dashboard Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f8; color: #1f2937; margin: 0; padding: 0; }
        
        /* SIDEBAR */
        .sidebar { background-color: #ffffff; width: 250px; height: 100vh; position: fixed; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; z-index: 1000; }
        .sidebar-header { padding: 20px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #e5e7eb; }
        .brand-icon { width: 35px; height: 35px; background-color: #218838; border-radius: 8px; display: flex; justify-content: center; align-items: center; color: white; }
        
        .menu-container { padding: 15px 0; flex-grow: 1; }
        .menu-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #6c757d; text-decoration: none; font-size: 0.95rem; font-weight: 500; border-left: 4px solid transparent; }
        .menu-item:hover { color: #218838; background-color: #f8f9fa; }
        .menu-item.active { background-color: #e8f5e9; color: #218838; border-left-color: #218838; font-weight: 600; }
        
        .sidebar-footer { padding: 20px; border-top: 1px solid #e5e7eb; display: flex; align-items: center; gap: 10px; }

        /* MAIN CONTENT */
        .main-wrapper { margin-left: 250px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background-color: #ffffff; height: 75px; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; border-bottom: 1px solid #e5e7eb; position: sticky; top: 0; z-index: 999; }
        .badge-role { background-color: #fef08a; color: #854d0e; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .content { padding: 30px; }

        /* AVATAR */
        .avatar-circle { width: 35px; height: 35px; background-color: #ffeeba; color: #856404; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; }

        /* STAT CARDS */
        .stat-card { background: #ffffff; border-radius: 12px; padding: 20px; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.02); height: 100%; }
        .stat-title { font-size: 0.7rem; font-weight: 700; color: #9ca3af; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 8px; }
        .stat-value { font-size: 1.8rem; font-weight: 700; color: #111827; margin-bottom: 5px; line-height: 1.2; }
        .stat-desc { font-size: 0.75rem; color: #6b7280; }
        .text-green { color: #28a745 !important; }

        /* TRANSACTION LIST */
        .trx-card { background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .trx-title { font-size: 1.1rem; font-weight: 700; color: #111827; margin-bottom: 20px; }
        
        .trx-item { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #f3f4f6; }
        .trx-item:last-child { border-bottom: none; padding-bottom: 0; }
        .trx-left { display: flex; align-items: center; gap: 15px; }
        
        .icon-box { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
        .icon-setor { background-color: #e8f5e9; color: #28a745; }
        .icon-tarik { background-color: #fdf2e9; color: #fd7e14; }
        
        .trx-name { font-weight: 600; color: #1f2937; font-size: 0.95rem; margin-bottom: 2px; }
        .trx-time { font-size: 0.75rem; color: #9ca3af; }
        
        .val-setor { color: #28a745; font-weight: 700; font-size: 1rem; }
        .val-tarik { color: #dc3545; font-weight: 700; font-size: 1rem; }
        
        .trx-item.highlighted { background-color: #f4fdf6; margin: 0 -25px; padding: 15px 25px; border-radius: 8px; border-bottom: none; }
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
                <div style="font-size: 0.75rem; color: #6c757d;">Bank Sampah</div>
            </div>
        </div>

        <div class="menu-container">
            <a href="#" class="menu-item active">
                <i class="bi bi-bar-chart-fill"></i> Dashboard
            </a>
            <a href="{{ route('nasabah.index') }}" class="menu-item">
                <i class="bi bi-people"></i> Data Nasabah
            </a>
            <a href="{{ route('transaksi.create') }}" class="menu-item">
                <i class="bi bi-recycle"></i> Setor Sampah
            </a>
        </div>
    </div>

    <div class="main-wrapper">
        
       <div class="topbar">
            <h4 class="m-0" style="font-size: 1.1rem; color: #4b5563;">Dashboard Petugas</h4>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown" style="cursor: pointer;" data-bs-toggle="dropdown">
                    <span style="font-size: 1.05rem; color: #003366;">
                        Halo, <span style="font-weight: 600; text-transform: uppercase;">{{ auth()->user()->username ?? 'ASA MITAKA' }}</span>
                    </span>
                    <i class="bi bi-chevron-down" style="font-size: 0.8rem; color: #007bff;"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button></form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="content">
            
            <div class="row g-3 mb-4"> 
                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-title">TOTAL SETORAN UANG</div>
                        <div class="stat-value text-green">Rp {{ number_format($total_setoran ?? 0, 0, ',', '.') }}</div>
                        <div class="stat-desc text-muted">Total uang sampah terkumpul</div>
                     </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-title">TOTAL NASABAH</div>
                        <div class="stat-value">{{ number_format($total_nasabah ?? 0, 0, ',', '.') }}</div>
                        <div class="stat-desc text-muted">Nasabah terdaftar di sistem</div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-title">TOTAL TRANSAKSI</div>
                        <div class="stat-value">{{ number_format($total_transaksi ?? 0, 0, ',', '.') }}</div>
                        <div class="stat-desc text-muted">Setoran & penarikan tercatat</div>
                    </div>
                </div>
            </div>

            <div class="trx-card">
                <div class="trx-title">Transaksi Terakhir</div>

                <div class="trx-list">
                    <div class="trx-list">
                    @forelse($transaksi_terakhir as $trx)
                    <div class="trx-item">
                        <div class="trx-left">
                            
                            @if($trx->tipe_transaksi == 'setoran')
                                <div class="icon-box icon-setor">
                                    <i class="bi bi-recycle"></i>
                                </div>
                            @else
                                <div class="icon-box icon-tarik">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                            @endif

                            <div>
                                <div class="trx-name">{{ $trx->nama_nasabah }} – {{ ucfirst($trx->tipe_transaksi) }}</div>
                                
                                <div class="trx-time windows-time-converter" data-db-time="{{ $trx->tgl_transaksi }}">
                                </div>
                            </div>
                        </div>

                        @if($trx->tipe_transaksi == 'setoran')
                            <div class="val-setor">+{{ number_format($trx->total_nilai, 0, ',', '.') }}</div>
                        @else
                            <div class="val-tarik">-{{ number_format($trx->total_nilai, 0, ',', '.') }}</div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center text-muted py-3" style="font-size: 0.9rem;">
                        Belum ada data transaksi hari ini.
                    </div>
                    @endforelse
                </div>
                </div>
            </div>

        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>