<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; color: #1f2937; margin: 0; }
        
        /* SIDEBAR STYLING */
        .sidebar { background-color: #ffffff; width: 260px; height: 100vh; position: fixed; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; }
        .sidebar-brand { padding: 20px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #e5e7eb; height: 70px; }
        .brand-icon { width: 32px; height: 32px; background-color: #1b4332; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; }
        .nav-link-custom { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #4b5563; text-decoration: none; font-size: 0.85rem; font-weight: 500; border-left: 4px solid transparent; }
        .nav-link-custom:hover { background-color: #f9fafb; color: #1b4332; }
        .nav-link-custom.active { background-color: #e8f5e9; color: #1b4332; border-left-color: #1b4332; font-weight: 600; }
        
        /* MAIN CONTENT */
        .main-wrapper { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; transition: all 0.3s ease-in-out; }
        .topbar { height: 70px; background-color: #ffffff; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; padding: 0 30px; position: sticky; top: 0; z-index: 999; }
        .content-area {padding: 30px;flex-grow: 1;max-width: 1200px;width: 100%;margin: 0 auto;}
        .mobile-toggle { display: none; background: none; border: none; font-size: 1.5rem; color: #1f2937; cursor: pointer; }


        /* GREEN PROFILE CARD */
        .profile-card-green { 
            background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 100%); 
            border-radius: 20px; padding: 30px; color: white; display: flex; 
            align-items: center; justify-content: space-between; margin-bottom: 30px;
        }
        .profile-info-left { display: flex; align-items: center; gap: 20px; }
        .avatar-big { 
            width: 80px; height: 80px; background-color: rgba(255,255,255,0.2); 
            border-radius: 50%; display: flex; align-items: center; justify-content: center; 
            font-size: 1.8rem; font-weight: 700; border: 1px solid rgba(255,255,255,0.3);
        }
        .user-detail h4 { margin: 0; font-weight: 700; font-size: 1.25rem; }
        .user-detail p { margin: 2px 0 0; opacity: 0.8; font-size: 0.85rem; }
        .status-badge-white { background: rgba(255,255,255,0.15); padding: 5px 15px; border-radius: 20px; font-size: 0.75rem; font-weight: 500; }

        /* INFO SECTION */
        .info-section { background: white; border-radius: 15px; border: 1px solid #e5e7eb; overflow: hidden; margin-bottom: 20px; }
        .info-header { padding: 15px 25px; background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; color: #9ca3af; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        .info-row { display: flex; justify-content: space-between; padding: 15px 25px; border-bottom: 1px solid #f3f4f6; align-items: center; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #9ca3af; font-size: 0.85rem; }
        .info-value { color: #111827; font-weight: 600; font-size: 0.85rem; }
        .badge-aktif { background-color: #dcfce7; color: #15803d; padding: 4px 15px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }

        /* ACTION LIST */
        .action-list { background: white; border-radius: 15px; border: 1px solid #e5e7eb; overflow: hidden; }
        .action-item { 
            display: flex; justify-content: space-between; padding: 18px 25px; 
            border-bottom: 1px solid #f3f4f6; color: #374151; text-decoration: none; 
            font-size: 0.9rem; font-weight: 600; transition: 0.2s; cursor: pointer;
        }
        .action-item:hover { background-color: #f9fafb; }
        .action-item i { color: #9ca3af; }
        .action-item.text-danger { color: #dc2626; }
        .action-item.text-danger i { color: #dc2626; opacity: 0.5; }

        /* MODAL CUSTOM STYLING */
        .btn-custom-green { background-color: #1b4332; color: white; }
        .btn-custom-green:hover { background-color: #123024; color: white; }

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
        </div>

        <a href="{{ url('/nasabah/dashboard') }}" class="nav-link-custom">
            <i class="bi bi-house-door text-success"></i> Beranda
        </a>
        <a href="{{ route('riwayat.index') }}" class="nav-link-custom">
            <i class="bi bi-clock-history"></i> Riwayat
        </a>
        <a href="{{ route('penarikan.create') }}" class="nav-link-custom">
            <i class="bi bi-wallet2"></i> Tarik Saldo
        </a>
        <a href="{{ route('nasabah.profil.edit') }}" class="nav-link-custom active">
            <i class="bi bi-person-gear"></i> Profil Saya
        </a>
    </div>

    <div class="main-wrapper">
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <h4 class="fw-bold m-0" style="font-size: 1.25rem;">Profil Saya</h4>
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
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="background-color: #dcfce7; color: #15803d;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="background-color: #fee2e2; color: #991b1b;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Terdapat kesalahan pada inputan Anda.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="profile-card-green">
                <div class="profile-info-left">
                    <div class="avatar-big">
                        {{ strtoupper(substr($nasabah->nama ?? 'N', 0, 1)) }}
                    </div>
                    <div class="user-detail">
                        <h4>{{ $nasabah->nama ?? 'Nama Tidak Ada' }}</h4>
                        <p>{{ $nasabah->no_hp ?? '-' }}</p>
                        <p>{{ $nasabah->email ?? '-' }}</p>
                    </div>
                </div>
                <div class="status-badge-white">Nasabah Aktif</div>
            </div>

            <div class="info-section">
                <div class="info-header">Info Akun</div>
                <div class="info-row">
                    <div class="info-label">No. Nasabah</div>
                    <div class="info-value">#NSB-{{ \Carbon\Carbon::parse($nasabah->created_at)->format('Y') }}-{{ str_pad($nasabah->id_nasabah, 4, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal Daftar</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($nasabah->created_at)->translatedFormat('d M Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nomor Telepon</div>
                    <div class="info-value">{{ $nasabah->no_hp ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">{{ $nasabah->alamat ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status</div>
                    <div class="badge-aktif">Aktif</div>
                </div>
            </div>

            <div class="action-list">
                <a class="action-item" data-bs-toggle="modal" data-bs-target="#modalEditProfil">
                    <span><i class="bi bi-pencil-square me-3"></i> Edit Data Diri</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
                
                <a class="action-item" data-bs-toggle="modal" data-bs-target="#modalUbahPassword">
                    <span><i class="bi bi-shield-lock me-3"></i> Ubah Password</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
                
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="action-item text-danger border-0">
                        <span><i class="bi bi-box-arrow-right me-3"></i> Keluar</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditProfil" tabindex="-1" aria-labelledby="modalEditProfilLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="modalEditProfilLabel" style="font-size: 1.1rem;"><i class="bi bi-pencil-square me-2 text-success"></i> Edit Data Diri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('nasabah.profil.update') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ $nasabah->nama }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Nomor Telepon</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ $nasabah->no_hp }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ $nasabah->alamat }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-light border shadow-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-custom-green shadow-sm px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUbahPassword" tabindex="-1" aria-labelledby="modalUbahPasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="modalUbahPasswordLabel" style="font-size: 1.1rem;"><i class="bi bi-shield-lock me-2 text-danger"></i> Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('nasabah.profil.update') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="alert alert-warning small border-0 shadow-sm">
                            Kosongkan jika Anda tidak ingin mengubah password.
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Password Baru</label>
                            <input type="password" name="password_baru" class="form-control" placeholder="Masukkan password baru">
                            @error('password_baru') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_baru_confirmation" class="form-control" placeholder="Ulangi password baru">
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-light border shadow-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-custom-green shadow-sm px-4">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>