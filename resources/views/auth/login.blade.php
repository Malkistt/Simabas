<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIMABAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }
        .card-header-green {
            background-color: #1b4332;
            padding: 1.5rem;
            text-align: center;
            border-radius: 20px 20px 0 0;
            margin: 10px 10px 0 10px;
        }
        .form-control:focus { border-color: #1b4332; box-shadow: 0 0 0 0.25rem rgba(27, 67, 50, 0.25); }
        .btn-masuk { background-color: #1b4332; color: white; border-radius: 10px; padding: 0.7rem; font-weight: 600; }
        .btn-masuk:hover { background-color: #143628; color: white; }
        .demo-box { background-color: #e8f5e9; border: 1px solid #c8e6c9; border-radius: 10px; padding: 10px; font-size: 0.85rem; color: #2e7d32; }
    </style>
</head>
<body>

    <div class="login-card p-3">
        <div class="card-header-green mb-4">
            <i class="bi bi-person-fill text-white" style="font-size: 2rem;"></i>
        </div>
        
        <div class="px-4 pb-4">
            <h4 class="fw-bold text-center mb-1">Masuk</h4>
            <p class="text-center text-muted small mb-4">Selamat datang kembali!</p>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <!-- Error Validation Messages -->
            @if ($errors->any())
                <div class="alert alert-danger p-2 small">Email atau password salah.</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Username / Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Masukkan username atau email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                        
                        <span class="input-group-text bg-white border-start-0 text-muted" id="togglePassword" style="cursor: pointer;">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-masuk w-100 mb-3">Masuk</button>
                
                <div class="text-center mb-4">
                    <span class="small text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-success fw-semibold text-decoration-none">Daftar ke tempat SIMABAS</a></span>
                </div>

                <!-- Info Demo -->
                <div class="demo-box text-center fw-medium">
                    Demo: username nasabah / password: nasabah123
                </div>
            </form>
        </div>
    </div>

<script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            // Toggle tipe input antara 'password' dan 'text'
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle icon mata (dari bi-eye menjadi bi-eye-slash)
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</body>
</html>