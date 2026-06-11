<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Pengajuan Tarik Saldo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; color: #1f2937; }
        .sidebar { background-color: #ffffff; width: 260px; height: 100vh; position: fixed; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; }
        .sidebar-brand { padding: 20px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #e5e7eb; height: 70px; }
        .brand-icon { width: 32px; height: 32px; background-color: #1b4332; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; }
        .nav-link-custom { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #4b5563; text-decoration: none; font-size: 0.85rem; font-weight: 500; border-left: 4px solid transparent; }
        .nav-link-custom:hover { background-color: #f9fafb; color: #1b4332; }
        .nav-link-custom.active { background-color: #e8f5e9; color: #1b4332; border-left-color: #1b4332; font-weight: 600; }.main-wrapper { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
        
        .card-form { background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 30px; }
        .saldo-box { background-color: #e8f5e9; color: #1b4332; border-radius: 10px; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .confirm-box { background-color: #fffde7; border: 1px solid #fff59d; border-radius: 10px; padding: 20px; color: #5d4037; }
        .btn-submit-green { background-color: #1b4332; color: white; font-weight: 600; border: none; padding: 12px; border-radius: 8px; width: 100%; }
    
        .main-wrapper { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; transition: all 0.3s ease-in-out; }
        .topbar { height: 70px; background-color: #ffffff; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; padding: 0 30px; position: sticky; top: 0; z-index: 999; }
        .content-area { padding: 30px; flex-grow: 1; }
        .mobile-toggle { display: none; background: none; border: none; font-size: 1.5rem; color: #1f2937; cursor: pointer; }

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

    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-circle-fill" style="font-size: 0.8rem;"></i></div>
            <div>
                <div class="fw-bold" style="color: #1b4332; font-size: 1rem; line-height: 1;">SIMABAS</div>
                <div style="font-size: 0.65rem; color: #9ca3af;">Nasabah Panel</div>
            </div>
        </div>
        <a href="/nasabah/dashboard" class="nav-link-custom"><i class="bi bi-house-door"></i> Beranda</a>
        <a href="/riwayat" class="nav-link-custom"><i class="bi bi-clock-history"></i> Riwayat</a>
        <a href="#" class="nav-link-custom active"><i class="bi bi-wallet2"></i> Tarik Saldo</a>
        <a href="{{ route('nasabah.profil.edit') }}" class="nav-link-custom {{ Request::is('*profil*') ? 'active' : '' }}">
        <i class="bi bi-person-gear"></i> Profil Saya
        </a>
    </div>

    <div class="main-wrapper">
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <h4 class="fw-bold m-0" style="font-size: 1.25rem;">Tarik Saldo</h4>
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
            <div class="card-form col-md-9 mx-auto">
                <div class="fw-bold mb-4 text-dark fs-5">Form Tarik Saldo</div>

                @if(session('success'))
                    <div class="alert alert-success small mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger small mb-4">{{ session('error') }}</div>
                @endif

                <form action="{{ route('penarikan.store') }}" method="POST">
                    @csrf
                    
                    <div class="saldo-box mb-4">
                        <div>
                            <div class="small fw-medium opacity-75">Saldo Tersedia</div>
                            <div class="fw-bold fs-3">Rp {{ number_format($total_saldo, 0, ',', '.') }}</div>
                        </div>
                        <span class="badge bg-success px-3 py-2 rounded-pill small" style="background-color: #1b4332 !important;">Nasabah Aktif</span>
                    </div>

                    <div class="mb-2">
                        <label for="nominal" class="form-label fw-bold small text-secondary">Jumlah Penarikan (Rp)</label>
                        <input type="number" class="form-control py-2" id="nominal_nasabah" name="nominal" placeholder="Contoh: 50000" min="1000" oninput="hitungKonfirmasiNasabah()" required>
                        <div class="form-text text-muted small mt-1">Minimal penarikan: Rp 10.000</div>
                    </div>

                    <div id="box-konfirmasi-nasabah" class="confirm-box mb-4 d-none">
                        <div class="fw-bold small mb-2"><i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> Konfirmasi Pengajuan</div>
                        <div class="d-flex justify-content-between mb-2 small fw-medium">
                            <span>Jumlah ditarik</span>
                            <span id="preview-ditarik-nasabah">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between small fw-medium">
                            <span>Saldo setelah</span>
                            <span class="text-success fw-bold" id="preview-sisa-nasabah">Rp 0</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-4">
                            <button type="reset" class="btn btn-light w-100 py-2 fw-medium" onclick="document.getElementById('box-konfirmasi-nasabah').classList.add('d-none')">Batal</button>
                        </div>
                        <div class="col-8">
                            <button type="submit" class="btn-submit-green"><i class="bi bi-check-lg me-1"></i> Tarik Saldo</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const saldoNasabah = {{ $total_saldo }};
        
        function hitungKonfirmasiNasabah() {
            const nominal = parseInt(document.getElementById('nominal_nasabah').value) || 0;
            const box = document.getElementById('box-konfirmasi-nasabah');
            
            if(nominal > 0) {
                box.classList.remove('d-none');
                document.getElementById('preview-ditarik-nasabah').innerText = "Rp " + nominal.toLocaleString('id-ID');
                document.getElementById('preview-sisa-nasabah').innerText = "Rp " + (saldoNasabah - nominal).toLocaleString('id-ID');
            } else {
                box.classList.add('d-none');
            }
        }
    </script>
</body>
</html>