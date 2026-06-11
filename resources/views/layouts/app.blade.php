<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Dashboard Admin</title>
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Warna background abu-abu halus ala Figma */
            color: #1f2937;
        }
        
        /* SIDEBAR STYLING */
        .sidebar {
            background-color: #ffffff;
            width: 250px;
            min-height: 100vh;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }
        
        .sidebar-brand {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #e5e7eb;
            height: 70px;
        }
        
        .brand-icon {
            width: 32px;
            height: 32px;
            background-color: #15803d;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .brand-icon .circle {
            width: 12px;
            height: 12px;
            background-color: white;
            border-radius: 50%;
        }

        .menu-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: #9ca3af;
            letter-spacing: 1px;
            margin: 20px 20px 8px 20px;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            color: #4b5563;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            border-left: 4px solid transparent;
        }

        .nav-link-custom:hover {
            background-color: #f9fafb;
        }

        .nav-link-custom.active {
            background-color: #ecfdf5;
            color: #065f46;
            border-left-color: #10b981;
            font-weight: 600;
        }

        .user-profile-bottom {
            padding: 15px 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: auto;
        }

        /* MAIN CONTENT & TOPBAR */
        .main-wrapper {
            margin-left: 250px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 70px;
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .content-area {
            padding: 30px;
            flex-grow: 1;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><div class="circle"></div></div>
            <div>
                <div class="fw-bold text-dark" style="font-size: 1rem; color: #15803d !important; letter-spacing: 0.5px;">SIMABAS</div>
                <div style="font-size: 0.65rem; color: #9ca3af;">Admin Panel</div>
            </div>
        </div>

        <div class="menu-label">UTAMA</div>
        <a href="{{ route('dashboard') }}" class="nav-link-custom active">
            <i class="bi bi-bar-chart-fill text-success"></i> Dashboard
        </a>
        <a href="#" class="nav-link-custom">
            <i class="bi bi-people-fill text-secondary"></i> Nasabah
        </a>

        <div class="menu-label">DATA MASTER</div>
        <a href="#" class="nav-link-custom">
            <i class="bi bi-box-seam-fill" style="color: #d97706;"></i> Jenis Sampah
        </a>
        <a href="#" class="nav-link-custom">
            <i class="bi bi-currency-dollar text-secondary"></i> Harga Sampah
        </a>

        <div class="menu-label">LAPORAN</div>
        <a href="#" class="nav-link-custom">
            <i class="bi bi-graph-up text-danger"></i> Laporan
        </a>
        <a href="#" class="nav-link-custom">
            <i class="bi bi-journal-text" style="color: #92400e;"></i> Riwayat
        </a>

        <div class="menu-label">SISTEM</div>
        <a href="#" class="nav-link-custom">
            <i class="bi bi-person-fill" style="color: #3b82f6;"></i> Pengguna
        </a>
        <a href="#" class="nav-link-custom">
            <i class="bi bi-gear-fill text-secondary"></i> Pengaturan
        </a>

        <!-- Profil Bawah -->
        <div class="user-profile-bottom">
            <div class="d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; border-radius: 50%; background-color: #ecfdf5; color: #065f46; font-size: 0.8rem;">
                NA
            </div>
            <div>
                <div class="fw-bold text-dark" style="font-size: 0.8rem;">Admin</div>
                <div style="font-size: 0.65rem; color: #9ca3af;">Super Admin</div>
            </div>
        </div>
    </div>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <!-- TOPBAR -->
        <div class="topbar">
        <button class="btn d-md-none" id="sidebarToggle"><i class="bi bi-list"></i></button>
        <div class="fw-bold text-dark" style="font-size: 1.1rem;">Dashboard</div>
            
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    <i class="bi bi-bell text-secondary fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger-subtle text-danger border border-white" style="font-size: 0.6rem;">
                        3
                    </span>
                </div>
                
                <div class="d-flex align-items-center gap-2 ms-2">
                    <div class="d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; border-radius: 50%; background-color: #ecfdf5; color: #065f46; font-size: 0.8rem;">
                        NA
                    </div>
                    <span class="fw-medium" style="font-size: 0.85rem;">Admin <i class="bi bi-caret-down-fill ms-1" style="font-size: 0.6rem;"></i></span>
                </div>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

</body>
</html>