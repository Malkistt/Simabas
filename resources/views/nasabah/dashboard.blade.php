<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Dashboard Nasabah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; color: #1f2937; overflow-x: hidden; }
        
        /* SIDEBAR STYLING */
        .menu-label { font-size: 0.7rem; font-weight: 700; color: #9ca3af; letter-spacing: 1px; margin: 20px 20px 8px 20px; text-transform: uppercase; }
        .user-profile-bottom { padding: 15px 20px; border-top: 1px solid #e5e7eb; display: flex; align-items: center; gap: 10px; margin-top: auto; }
        .sidebar { background-color: #ffffff; width: 260px; height: 100vh; position: fixed; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; }
        .sidebar-brand { padding: 20px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #e5e7eb; height: 70px; }
        .brand-icon { width: 32px; height: 32px; background-color: #1b4332; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; }
        .nav-link-custom { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #4b5563; text-decoration: none; font-size: 0.85rem; font-weight: 500; border-left: 4px solid transparent; }
        .nav-link-custom:hover { background-color: #f9fafb; color: #1b4332; }
        .nav-link-custom.active { background-color: #e8f5e9; color: #1b4332; border-left-color: #1b4332; font-weight: 600; }
        
        /* MAIN CONTENT & TOPBAR */
        .main-wrapper { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; transition: all 0.3s ease-in-out; }
        .topbar { height: 70px; background-color: #ffffff; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; padding: 0 30px; position: sticky; top: 0; z-index: 999; }
        .content-area { padding: 30px; flex-grow: 1; }
        .mobile-toggle { display: none; background: none; border: none; font-size: 1.5rem; color: #1f2937; cursor: pointer; }

        /* WALLET CARD CUSTOM */
        .wallet-card { background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 100%); color: white; border-radius: 20px; border: none; }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); box-shadow: 4px 0 10px rgba(0,0,0,0.1); }
            .main-wrapper { margin-left: 0; width: 100%; }
            .mobile-toggle { display: block; }
            .topbar { padding: 0 20px; }
            .content-area { padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-circle-fill" style="font-size: 0.8rem;"></i></div>
            <div>
                <div class="fw-bold" style="color: #1b4332; font-size: 1rem; line-height: 1;">SIMABAS</div>
                <div style="font-size: 0.65rem; color: #9ca3af;">Nasabah Panel</div>
            </div>
            <button class="ms-auto border-0 bg-transparent d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-x-lg text-secondary"></i>
            </button>
        </div>

        <a href="{{ url('/nasabah/dashboard') }}" class="nav-link-custom active">
            <i class="bi bi-house-door text-success"></i> Beranda
        </a>
        <a href="{{ route('riwayat.index') }}" class="nav-link-custom">
            <i class="bi bi-clock-history"></i> Riwayat
        </a>
        <a href="{{ route('penarikan.create') }}" class="nav-link-custom">
            <i class="bi bi-wallet2"></i> Tarik Saldo
        </a>
        <a href="{{ route('nasabah.profil.edit') }}" class="nav-link-custom {{ Request::is('*profil*') ? 'active' : '' }}">
        <i class="bi bi-person-gear"></i> Profil Saya
        </a>

    </div>

    <div class="main-wrapper" id="main-wrapper">
        
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <h4 class="fw-bold m-0" style="font-size: 1.25rem;">Beranda Nasabah</h4>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn border-0 d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                        <span class="fw-medium text-dark" style="font-size: 0.85rem;">Halo, {{ auth()->user()->username ?? 'Nasabah' }}</span>
                        <i class="bi bi-chevron-down text-secondary" style="font-size: 0.6rem;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li><a class="dropdown-item" href="{{ route('nasabah.profil.edit') }}"><i class="bi bi-person me-2"></i> Profil</a></li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="content-area">
            
            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-6">
                    <div class="card wallet-card p-4 shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="fw-semibold opacity-75 small mb-1" style="letter-spacing: 0.5px;">SALDO TABUNGAN ANDA</div>
                            <div class="fw-bold" style="font-size: 2.2rem;">Rp {{ number_format($total_saldo ?? 0, 0, ',', '.') }}</div>
                        </div>
                        <div class="mt-4 d-flex justify-content-between align-items-center opacity-75 small">
                            <span>SIMABAS Mandiri</span>
                            <span><i class="bi bi-shield-check"></i> Terverifikasi</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-lg-6">
                    <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                        <div class="text-muted fw-bold mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">TOTAL TRANSAKSI</div>
                        <div class="fw-bold text-dark" style="font-size: 1.8rem;">{{ $total_transaksi ?? 0 }} <span class="fs-5 text-muted">Kali</span></div>
                        <div class="text-muted mt-2" style="font-size: 0.8rem;"><i class="bi bi-arrow-left-right"></i> Setor & Tarik</div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold m-0 text-dark">Riwayat Transaksi Terakhir</h6>
                    <a href="{{ route('riwayat.index') }}" class="btn btn-sm btn-outline-success px-3 rounded-pill" style="color: #1b4332; border-color: #1b4332;">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="text-muted" style="font-size: 0.8rem; border-bottom: 2px solid #f3f4f6;">
                            <tr>
                                <th class="fw-semibold py-3 border-0">TANGGAL</th>
                                <th class="fw-semibold py-3 border-0">JENIS TRANSAKSI</th>
                                <th class="fw-semibold py-3 border-0">KETERANGAN</th>
                                <th class="fw-semibold py-3 border-0 text-end">NOMINAL</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.9rem;">
                            @forelse($transaksi_terakhir ?? [] as $trx)
                            <tr>
                                <td class="py-3 border-light">{{ \Carbon\Carbon::parse($trx->tgl_transaksi)->format('d M Y') }}</td>
                                <td class="py-3 border-light">
                                    @if($trx->tipe_transaksi == 'setoran')
                                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Setor Sampah</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">Tarik Saldo</span>
                                    @endif
                                </td>
                                <td class="py-3 border-light text-muted">{{ $trx->keterangan ?? '-' }}</td>
                                <td class="py-3 border-light text-end fw-bold {{ $trx->tipe_transaksi == 'setoran' ? 'text-success' : 'text-danger' }}">
                                    {{ $trx->tipe_transaksi == 'setoran' ? '+' : '-' }} Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada riwayat transaksi. Belajar memilah sampah dan lakukan setoran pertama Anda!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
    </script>
</body>
</html>