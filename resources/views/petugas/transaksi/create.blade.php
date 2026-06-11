<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMABAS - Transaksi Setoran Sampah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f8; color: #1f2937; margin: 0; padding: 0; }
        
        /* SIDEBAR */
        .sidebar { background-color: #ffffff; width: 250px; height: 100vh; position: fixed; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; z-index: 1000; }
        .sidebar-header { padding: 20px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #e5e7eb; }
        .brand-icon { width: 35px; height: 35px; background-color: #15803d; border-radius: 8px; display: flex; justify-content: center; align-items: center; color: white; }
        .menu-container { padding: 15px 0; flex-grow: 1; }
        .menu-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #6c757d; text-decoration: none; font-size: 0.95rem; font-weight: 500; border-left: 4px solid transparent; }
        .menu-item:hover { color: #15803d; background-color: #f0fdf4; }
        .menu-item.active { background-color: #f0fdf4; color: #15803d; border-left-color: #15803d; font-weight: 600; }
        .sidebar-footer { padding: 20px; border-top: 1px solid #e5e7eb; display: flex; align-items: center; gap: 10px; }
        .avatar-circle { width: 35px; height: 35px; background-color: #fef08a; color: #854d0e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; }

        /* MAIN CONTENT */
        .main-wrapper { margin-left: 250px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background-color: #ffffff; height: 75px; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; border-bottom: 1px solid #e5e7eb; position: sticky; top: 0; z-index: 999; }
        .badge-role { background-color: #fef08a; color: #854d0e; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .content { padding: 30px; }

        /* FORM CARD */
        .form-card { background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .form-title { font-size: 1.1rem; font-weight: 700; color: #111827; margin-bottom: 25px; }
        
        .form-label { font-size: 0.85rem; font-weight: 600; color: #4b5563; }
        .form-control, .form-select { border-color: #d1d5db; border-radius: 8px; padding: 10px 15px; font-size: 0.95rem; }
        .form-control:focus, .form-select:focus { border-color: #15803d; box-shadow: 0 0 0 0.2rem rgba(21, 128, 61, 0.25); }
        
        /* INFO SALDO */
        .info-saldo { background-color: #dcfce7; color: #166534; padding: 8px 15px; border-radius: 8px; font-size: 0.85rem; font-weight: 500; display: inline-block; margin-top: 8px; }

        /* TABLE TRANSAKSI */
        .table-trx th { font-size: 0.75rem; color: #9ca3af; font-weight: 700; text-transform: uppercase; border-bottom: none; padding-bottom: 15px; }
        .table-trx td { vertical-align: middle; border-bottom: 1px solid #f3f4f6; padding: 12px 5px; }
        .btn-remove { background-color: #ef4444; color: white; border: none; border-radius: 6px; width: 32px; height: 32px; display: flex; justify-content: center; align-items: center; cursor: pointer; transition: 0.2s; }
        .btn-remove:hover { background-color: #dc2626; }
        .btn-add { background-color: #f3f4f6; color: #4b5563; border: 1px solid #d1d5db; padding: 8px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: 0.2s; }
        .btn-add:hover { background-color: #e5e7eb; }

        /* SUMMARY BOX */
        .summary-box { background-color: #dcfce7; border-radius: 12px; padding: 25px; margin-top: 25px; }
        .summary-text { color: #166534; font-size: 0.95rem; font-weight: 600; }
        .summary-value { color: #166534; font-size: 1.1rem; font-weight: 700; text-align: right; }
        
        /* ACTION BUTTONS */
        .btn-reset { background-color: #ffffff; color: #4b5563; border: 1px solid #d1d5db; padding: 12px 24px; border-radius: 8px; font-weight: 600; width: 100%; transition: 0.2s; }
        .btn-reset:hover { background-color: #f3f4f6; }
        .btn-submit { background-color: #15803d; color: #ffffff; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; width: 100%; transition: 0.2s; }
        .btn-submit:hover { background-color: #166534; }
    </style>
</head>
<body>

    <script>
        const dataNasabah = @json($nasabah);
        const dataJenisSampah = @json($jenis_sampah);
    </script>

    <div class="sidebar">
        <div class="sidebar-header">
            <div class="brand-icon"><i class="bi bi-circle-fill" style="font-size: 0.8rem;"></i></div>
            <div style="line-height: 1.2;">
                <div style="font-weight: 700; color: #15803d; font-size: 1.1rem;">SIMABAS</div>
                <div style="font-size: 0.75rem; color: #6c757d;">Bank Sampah</div>
            </div>
        </div>
        <div class="menu-container">
            <a href="{{ url('/petugas/dashboard') }}" class="menu-item"><i class="bi bi-bar-chart-fill"></i> Dashboard</a>
            <a href="{{ route('nasabah.index') }}" class="menu-item"><i class="bi bi-people"></i> Data Nasabah</a>
            <a href="{{ route('transaksi.create') }}" class="menu-item active"><i class="bi bi-recycle"></i> Setor Sampah</a>
        </div>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="topbar">
            <h4 class="m-0" style="font-size: 1.1rem; color: #4b5563;">Transaksi Setoran Sampah</h4>
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
            <form action="{{ route('transaksi.store') }}" method="POST" id="formSetoran">
                @csrf
                <div class="form-card">
                    <div class="form-title">Form Setoran Sampah</div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Pilih Nasabah</label>
                            <div class="input-group">
                                <select name="id_nasabah" id="pilihNasabah" class="form-select" required>
                                    <option value="" selected disabled>-- Cari nasabah... --</option>
                                    @foreach($nasabah as $nsb)
                                        <option value="{{ $nsb->id_nasabah }}">
                                            {{ $nsb->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            </div>
                            <div id="infoSaldo" class="info-saldo" style="display: none;">
                                Saldo: Rp <span id="textSaldo">0</span> - <span id="textStatus"></span> <i class="bi bi-check-lg"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Transaksi</label>
                            <input type="date" name="tgl_transaksi" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Detail Sampah yang Disetor</label>
                        <table class="table table-borderless table-trx w-100" id="tableSampah">
                            <thead>
                                <tr>
                                    <th width="30%">JENIS SAMPAH</th>
                                    <th width="25%">HARGA/KG</th>
                                    <th width="20%">BERAT (KG)</th>
                                    <th width="20%">SUBTOTAL</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody id="tbodySampah">
                                </tbody>
                        </table>
                        <button type="button" class="btn-add mt-2" onclick="tambahBaris()">+ Tambah Jenis Sampah</button>
                    </div>

                    <div class="summary-box">
                        <div class="row align-items-center mb-2">
                            <div class="col-6 summary-text">Total Berat</div>
                            <div class="col-6 summary-value"><span id="totalBerat">0</span> kg</div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-6 summary-text" style="font-size: 1.1rem;">Total Nilai Setoran</div>
                            <div class="col-6 summary-value" style="font-size: 1.25rem;">Rp <span id="totalNilai">0</span></div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-6 summary-text" style="font-size: 0.85rem; color: #86efac;">Saldo setelah transaksi</div>
                            <div class="col-6 summary-value" style="font-size: 0.95rem; color: #86efac;">Rp <span id="estimasiSaldo">0</span></div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-3">
                            <button type="reset" class="btn-reset" onclick="setTimeout(hitungTotal, 100)">Reset</button>
                        </div>
                        <div class="col-md-9">
                            <button type="submit" class="btn-submit">
                                <i class="bi bi-printer-fill me-2"></i> Simpan & Cetak Struk
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let saldoSekarang = 0;

        // 1. Logika saat Nasabah dipilih
        document.getElementById('pilihNasabah').addEventListener('change', function() {
            let id = this.value;
            let nsb = dataNasabah.find(n => n.id_nasabah == id);
            
            if (nsb) {
                saldoSekarang = parseInt(nsb.saldo_tersedia) || 0;
                document.getElementById('textSaldo').innerText = saldoSekarang.toLocaleString('id-ID');
                document.getElementById('textStatus').innerText = nsb.status_aktif == 1 ? 'Nasabah Aktif' : 'Nonaktif';
                document.getElementById('infoSaldo').style.display = 'inline-block';
                hitungTotal(); // Update estimasi saldo
            }
        });

        // 2. Fungsi Tambah Baris Sampah Dinamis
        function tambahBaris() {
            let tbody = document.getElementById('tbodySampah');
            let tr = document.createElement('tr');
            
            // Buat pilihan dropdown jenis sampah (harganya dari database)
            let options = '<option value="" disabled selected>Pilih...</option>';
            dataJenisSampah.forEach(js => {
            options += `<option value="${js.id_jenis}" data-harga="${js.harga_per_kg}">${js.kategori}</option>`;
            });

            tr.innerHTML = `
                <td>
                    <select name="id_jenis[]" class="form-select select-jenis" required onchange="updateHarga(this)">
                        ${options}
                    </select>
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">Rp</span>
                        <input type="text" class="form-control border-start-0 input-harga bg-white" readonly value="0">
                    </div>
                    <input type="hidden" name="harga_per_kg[]" class="input-harga-real" value="0">
                </td>
                <td>
                    <input type="number" name="berat[]" class="form-control input-berat" step="0.1" min="0.1" required oninput="hitungTotal()">
                </td>
                <td style="font-weight: 700; color: #15803d; font-size: 1.05rem;">
                    Rp <span class="text-subtotal">0</span>
                </td>
                <td>
                    <button type="button" class="btn-remove" onclick="hapusBaris(this)"><i class="bi bi-x-lg"></i></button>
                </td>
            `;
            tbody.appendChild(tr);
        }

        // 3. Update Harga saat Jenis Sampah dipilih
        function updateHarga(selectElement) {
            let tr = selectElement.closest('tr');
            let harga = selectElement.options[selectElement.selectedIndex].getAttribute('data-harga') || 0;
            
            tr.querySelector('.input-harga-real').value = harga;
            tr.querySelector('.input-harga').value = parseInt(harga).toLocaleString('id-ID');
            
            hitungTotal();
        }

        // 4. Hapus Baris
        function hapusBaris(buttonElement) {
            buttonElement.closest('tr').remove();
            hitungTotal();
        }

        // 5. Kalkulasi Seluruh Subtotal dan Total
        function hitungTotal() {
            let totalBerat = 0;
            let totalNilai = 0;

            let baris = document.querySelectorAll('#tbodySampah tr');
            
            baris.forEach(tr => {
                let harga = parseFloat(tr.querySelector('.input-harga-real').value) || 0;
                let berat = parseFloat(tr.querySelector('.input-berat').value) || 0;
                
                let subtotal = harga * berat;
                tr.querySelector('.text-subtotal').innerText = subtotal.toLocaleString('id-ID');
                
                totalBerat += berat;
                totalNilai += subtotal;
            });

            // Update UI Kotak Hijau
            document.getElementById('totalBerat').innerText = totalBerat;
            document.getElementById('totalNilai').innerText = totalNilai.toLocaleString('id-ID');
            
            // Estimasi Saldo
            let estimasi = saldoSekarang + totalNilai;
            document.getElementById('estimasiSaldo').innerText = estimasi.toLocaleString('id-ID');
        }

        // Inisialisasi 1 baris pertama saat halaman dimuat
        document.addEventListener("DOMContentLoaded", function() {
            tambahBaris();
        });
    </script>
</body>
</html>