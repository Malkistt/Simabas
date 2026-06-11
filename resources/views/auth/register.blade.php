<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SIMABAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px 0; }
        .register-card { background: #ffffff; border-radius: 20px; box-shadow: 0 8px 24px rgba(0,0,0,0.05); width: 100%; max-width: 500px; padding: 2rem; border: 1px solid #e9ecef;}
        .form-control:focus { border-color: #1b4332; box-shadow: 0 0 0 0.25rem rgba(27, 67, 50, 0.25); }
        .btn-daftar { background-color: #1b4332; color: white; border-radius: 10px; padding: 0.7rem; font-weight: 600; }
        .btn-daftar:hover { background-color: #143628; color: white; }
    </style>
</head>
<body>

    <div class="register-card">
        <h4 class="fw-bold text-center mb-1 text-dark">Buat Akun Baru</h4>
        <p class="text-center text-muted small mb-4">Bergabunglah dengan SIMABAS hari ini</p>

    <form method="POST" action="{{ route('register.custom.post') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label small fw-semibold">Nama Lengkap</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label small fw-semibold">Username</label>
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label small fw-semibold">Alamat Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label small fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label small fw-semibold">Ulangi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>

            <button type="submit" class="btn btn-daftar w-100 mb-3">Daftar Sekarang</button>
            <div class="text-center">
                <span class="small text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-success fw-semibold text-decoration-none">Masuk di sini</a></span>
            </div>
        </form>
    </div>

</body>
</html>