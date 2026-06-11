<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Petugas Data Nasabah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f8; color: #1f2937; margin: 0; padding: 0; }
        .sidebar { background-color: #ffffff; width: 250px; height: 100vh; position: fixed; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; z-index: 1000; }
        .sidebar-header { padding: 20px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #e5e7eb; }
        .brand-icon { width: 35px; height: 35px; background-color: #218838; border-radius: 8px; display: flex; justify-content: center; align-items: center; color: white; }
        .menu-container { padding: 15px 0; flex-grow: 1; }
        .menu-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #6c757d; text-decoration: none; font-size: 0.95rem; font-weight: 500; border-left: 4px solid transparent; }
        .menu-item:hover { color: #218838; background-color: #f8f9fa; }
        .menu-item.active { background-color: #e8f5e9; color: #218838; border-left-color: #218838; font-weight: 600; }
        .main-wrapper { margin-left: 250px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background-color: #ffffff; height: 75px; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; border-bottom: 1px solid #e5e7eb; position: sticky; top: 0; z-index: 999; }
        .badge-role { background-color: #fef08a; color: #854d0e; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .content { padding: 30px; }
        .table-card { background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 25px; }
        .table > :not(caption) > * > * { padding: 16px 10px; border-bottom-color: #f3f4f6; vertical-align: middle; }
        .table th { font-size: 0.75rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e5e7eb; }
        .badge-aktif { background-color: #dcfce7; color: #166534; padding: 6px 16px; font-weight: 600; font-size: 0.75rem; border-radius: 20px; }
        .badge-nonaktif { background-color: #fee2e2; color: #991b1b; padding: 6px 16px; font-weight: 600; font-size: 0.75rem; border-radius: 20px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <div class="brand-icon"><i class="bi bi-circle-fill" style="font-size: 0.8rem;"></i></div>
            <div style="line-height: 1.2;">
                <div style="font-weight: 700; color: #218838; font-size: 1.1rem;">SIMABAS</div>
                <div style="font-size: 0.75rem; color: #6c757d;">Bank Sampah</div>
            </div>
        </div>
        <div class="menu-container">
            <a href="{{ url('/petugas/dashboard') }}" class="menu-item"><i class="bi bi-bar-chart-fill"></i> Dashboard</a>
            <a href="{{ route('nasabah.index') }}" class="menu-item active"><i class="bi bi-people"></i> Data Nasabah</a>
            <a href="{{ route('transaksi.create') }}" class="menu-item"><i class="bi bi-recycle"></i> Setor Sampah</a>
        </div>
    </div>

    <div class="main-wrapper">
         <div class="topbar">
            <h4 class="m-0" style="font-size: 1.1rem; color: #4b5563;">Data Nasabah</h4>
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
            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA</th>
                                <th>NO. HP</th>
                                <th>ALAMAT</th>
                                <th>TGL DAFTAR</th>
                                <th>SALDO</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftar_nasabah as $index => $nsb)
                            <tr>
                                <td class="text-muted">{{ $daftar_nasabah->firstItem() + $index }}</td>
                                <td class="fw-semibold">{{ $nsb->nama }}</td>
                                <td class="text-muted">{{ $nsb->no_hp }}</td>
                                <td class="text-muted">{{ $nsb->alamat }}</td>
                                <td class="text-muted">{{ \Carbon\Carbon::parse($nsb->tgl_daftar)->format('d/m/y') }}</td>
                                <td style="color: #218838; font-weight: 700;">Rp {{ number_format($nsb->saldo_tersedia ?? 0, 0, ',', '.') }}</td>
                                <td><span class="{{ $nsb->status_aktif == 1 ? 'badge-aktif' : 'badge-nonaktif' }}">{{ $nsb->status_aktif == 1 ? 'Aktif' : 'Nonaktif' }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div style="font-size: 0.85rem; color: #9ca3af;">Menampilkan {{ $daftar_nasabah->firstItem() }}-{{ $daftar_nasabah->lastItem() }} dari {{ $daftar_nasabah->total() }} data</div>
                    <div>{{ $daftar_nasabah->links('pagination::bootstrap-5') }}</div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>