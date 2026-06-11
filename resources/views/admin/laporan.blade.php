<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Generate Laporan</title>
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

        /* PARAMETER CARD */
        .param-card { background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 25px; margin-bottom: 25px; }
        .param-title { font-size: 1rem; font-weight: 700; color: #166534; margin-bottom: 15px; }
        .form-label { font-size: 0.85rem; font-weight: 600; color: #374151; }
        .btn-generate { background-color: #1b4332; color: white; font-weight: 600; padding: 10px; border-radius: 8px; width: 100%; border: none; }
        
        /* SUMMARY CARDS */
        .summary-card { background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 20px; text-align: left; }
        .summary-title { font-size: 0.75rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; margin-bottom: 10px; }
        .summary-value { font-size: 1.5rem; font-weight: 700; color: #111827; }

        /* TABLE */
        .table-card { background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 20px; margin-top: 25px; }
        .table > :not(caption) > * > * { padding: 15px 10px; border-bottom-color: #f3f4f6; }
        .table th { font-size: 0.75rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; }
        
        .btn-download { background-color: #ea4335; color: white; font-weight: 600; padding: 12px; border-radius: 8px; width: 100%; border: none; margin-top: 25px; display: block; text-align: center; text-decoration: none; }
        .btn-download:hover { background-color: #c5221f; color: white; }
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
            <a href="#" class="menu-item">
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
            <a href="{{ route('admin.laporan.index') }}" class="menu-item active">
                <i class="bi bi-file-earmark-pdf"></i> Laporan PDF
            </a>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="topbar">
            <h4>Laporan PDF</h4>
            
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
            <div class="param-card">
                <div class="param-title">Parameter Laporan</div>
                <form action="{{ route('admin.laporan.index') }}" method="GET">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Jenis Laporan</label>
                            <input type="text" class="form-control" value="Laporan Transaksi" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Periode</label>
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($dari_tanggal)->translatedFormat('F Y') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="dari_tanggal" class="form-control" value="{{ $dari_tanggal }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="sampai_tanggal" class="form-control" value="{{ $sampai_tanggal }}">
                        </div>
                    </div>
                    <button type="submit" class="btn-generate"><i class="bi bi-file-earmark-bar-graph me-2"></i> Generate Laporan</button>
                </form>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="summary-card">
                        <div class="summary-title">TOTAL SETORAN</div>
                        <div class="summary-value">Rp {{ number_format($ringkasan->total_setoran ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <div class="summary-title">TOTAL PENARIKAN</div>
                        <div class="summary-value">Rp {{ number_format($ringkasan->total_penarikan ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <div class="summary-title">JML TRANSAKSI</div>
                        <div class="summary-value">{{ number_format($ringkasan->jml_transaksi ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>TANGGAL</th>
                                <th>SETORAN</th>
                                <th>PENARIKAN</th>
                                <th>SALDO AKHIR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporan_harian as $row)
                            <tr>
                                <td class="fw-medium text-dark">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                                <td class="fw-bold text-success">Rp {{ number_format($row->setoran, 0, ',', '.') }}</td>
                                <td class="fw-bold text-danger">Rp {{ number_format($row->penarikan, 0, ',', '.') }}</td>
                                <td class="fw-bold text-dark">Rp {{ number_format($row->saldo_akhir, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Tidak ada data transaksi pada periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        

            <a href="{{ route('admin.laporan.pdf', ['dari_tanggal' => $dari_tanggal, 'sampai_tanggal' => $sampai_tanggal]) }}" class="btn-download">
                <i class="bi bi-filetype-pdf me-2"></i> Download PDF
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>