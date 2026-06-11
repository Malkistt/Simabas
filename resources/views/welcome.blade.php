<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #eef7f2, #ffffff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .landing-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(27, 67, 50, 0.08);
            padding: 3rem;
            width: 100%;
            max-width: 500px;
            text-align: center;
            border: 1px solid rgba(25, 135, 84, 0.1);
        }
        .check-icon-wrapper {
            background-color: #e8f5e9;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem auto;
        }
        /* Ilustrasi 3 Keranjang Sampah */
        .bins-illustration {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: 15px;
            margin: 2.5rem 0;
            height: 100px;
        }
        .bin { border-radius: 8px 8px 0 0; width: 45px; position: relative; }
        .bin::after {
            content: ''; position: absolute; top: -10px; left: 50%;
            transform: translateX(-50%); width: 25px; height: 10px;
            border: 2px solid; border-bottom: 0; border-radius: 10px 10px 0 0;
        }
        .bin-1 { height: 60%; background-color: #a3b18a; border-color: #a3b18a; }
        .bin-2 { height: 90%; background-color: #84a98c; border-color: #84a98c; }
        .bin-3 { height: 75%; background-color: #1b4332; border-color: #1b4332; }
        
        .btn-custom {
            background-color: #1b4332;
            color: white;
            border-radius: 12px;
            padding: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .btn-custom:hover { background-color: #143628; color: white; }
    </style>
</head>
<body>

    <div class="landing-card">
        <div class="check-icon-wrapper">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 2.5rem;"></i>
        </div>
        
        <h2 class="fw-bold text-dark mb-1" style="letter-spacing: 1px;">SIMABAS</h2>
        <p class="text-muted small">Sistem Informasi Manajemen Bank Sampah</p>

        <!-- Ilustrasi Keranjang Sesuai Figma -->
        <div class="bins-illustration">
            <div class="bin bin-1"></div>
            <div class="bin bin-2"></div>
            <div class="bin bin-3"></div>
        </div>

        <a href="{{ route('login') }}" class="btn btn-custom w-100 mb-4">
            Mulai Sekarang
        </a>

        <div class="text-muted" style="font-size: 0.75rem;">
            v1.0.0 - UIN SGD Bandung
        </div>
    </div>

</body>
</html>