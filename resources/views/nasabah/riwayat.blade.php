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
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f8; color: #1f2937; margin: 0; padding: 0; }
        
        /* SIDEBAR STYLING */
        .sidebar { background-color: #ffffff; width: 260px; height: 100vh; position: fixed; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; }
        .sidebar-brand { padding: 20px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #e5e7eb; height: 70px; }
        .brand-icon { width: 32px; height: 32px; background-color: #1b4332; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; }
        .nav-link-custom { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #4b5563; text-decoration: none; font-size: 0.85rem; font-weight: 500; border-left: 4px solid transparent; }
        .nav-link-custom:hover { background-color: #f9fafb; color: #1b4332; }
        .nav-link-custom.active { background-color: #e8f5e9; color: #1b4332; border-left-color: #1b4332; font-weight: 600; }
        
        /* MAIN LAYOUT */
        .main-wrapper { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { height: 70px; background-color: #ffffff; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; padding: 0 30px; }
        .content-area { padding: 30px; }

        /* FIGMA CARD CONTAINER */
        .receipt-card { background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        
        /* Input Date Filter */
        .filter-input { border: 1px solid #d1d5db; border-radius: 8px; padding: 8px 12px; color: #6b7280; font-size: 0.85rem; width: 100%; text-align: center; }

        /* Group Bulan Header */
        .month-header { font-size: 0.8rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 25px; margin-bottom: 15px; }
        .month-group:first-child .month-header { margin-top: 0; }

        /* List Transaksi Item (Figma Style) */
        .trx-item { display: flex; align-items: center; justify-content: space-between; padding: 16px 0; border-bottom: 1px solid #f3f4f6; }
        .trx-item:last-child { border-bottom: none; }
        
        .trx-left { display: flex; align-items: center; gap: 16px; }
        
        /* Lingkaran Ikon Bulat */
        .icon-box { width: 44px; height: 44px; border-radius: 10px; display: flex; justify-content: center; align-items: center; font-size: 1.2rem; }
        .icon-setor { background-color: #e8f5e9; color: #15803d; }
        .icon-tarik { background-color: #fdf2f2; color: #dc2626; }
        
        .trx-title { font-weight: 600; font-size: 0.95rem; color: #111827; margin-bottom: 2px; }
        .trx-sub { font-size: 0.8rem; color: #9ca3af; }
        
        .val-setor { color: #15803d; font-weight: 700; font-size: 1.05rem; }
        .val-tarik { color: #dc2626; font-weight: 700; font-size: 1.05rem; }

        .trx-item-link {
        display: block;
        color: inherit;
        transition: background-color 0.2s ease;
        }
        .trx-item-link:hover .trx-item {
            background-color: #f8fafc; /* Efek highlight abu-abu lembut saat bar riwayat disorot/diklik */
            cursor: pointer;
            padding-left: 8px;
            padding-right: 8px;
            border-radius: 8px;
        }
        /* topbar & main wrapper */
        .main-wrapper { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; transition: all 0.3s ease-in-out; }
        .topbar { height: 70px; background-color: #ffffff; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; padding: 0 30px; position: sticky; top: 0; z-index: 999; }
        .content-area { padding: 30px; flex-grow: 1; }
        .mobile-toggle { display: none; background: none; border: none; font-size: 1.5rem; color: #1f2937; cursor: pointer; }

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
        <a href="#" class="nav-link-custom active"><i class="bi bi-clock-history"></i> Riwayat</a>
        <a href="/penarikan/create" class="nav-link-custom"><i class="bi bi-wallet2"></i> Tarik Saldo</a>
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
                <h4 class="fw-bold m-0" style="font-size: 1.25rem;">Riwayat Transaksi</h4>
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
            <div class="receipt-card col-md-10 mx-auto">
                
                @php
                    // Mengelompokkan data berdasarkan Bulan dan Tahun dari tgl_transaksi secara dinamis
                    $riwayatGrouped = $riwayat->groupBy(function($item) {
                        return \Carbon\Carbon::parse($item->tgl_transaksi)->translatedFormat('F Y');
                    });
                @endphp

                @forelse($riwayatGrouped as $bulan => $daftarTransaksi)
                <div class="month-group">
                    <div class="month-header">{{ $bulan }}</div>
                    
                    @foreach($daftarTransaksi as $trx)
                    <a href="{{ route('nasabah.riwayat.detail', $trx->id_transaksi ?? $trx->id) }}" class="trx-item-link text-decoration-none">
                    <div class="trx-item">
                        <div class="trx-left">
                            @if($trx->tipe_transaksi == 'setoran')
                                <div class="icon-box icon-setor">
                                    <i class="bi bi-recycle"></i>
                                </div>
                                <div>
                                    <div class="trx-title">Setor Sampah</div>
                                    <div class="trx-sub">
                                        {{ $trx->keterangan ?? 'Plastik, Kertas' }} • {{ \Carbon\Carbon::parse($trx->tgl_transaksi)->translatedFormat('d M') }}
                                    </div>
                                </div>
                            @else
                                <div class="icon-box icon-tarik">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div>
                                    <div class="trx-title">Tarik Saldo</div>
                                    <div class="trx-sub">
                                        Penarikan Tunai • {{ \Carbon\Carbon::parse($trx->tgl_transaksi)->translatedFormat('d M') }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div>
                            @if($trx->tipe_transaksi == 'setoran')
                                <span class="val-setor">+Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</span>
                            @else
                                <span class="val-tarik">-Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                </a>
                    @endforeach
                </div>
                @empty
                <div class="text-center py-5 text-muted small">
                    <i class="bi bi-clock-history fs-2 d-block opacity-25 mb-2"></i>
                    Belum ada riwayat aktivitas penarikan maupun setoran sampah.
                </div>
                @endforelse

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>