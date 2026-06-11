<x-app-layout>
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white">Form Setoran Sampah</div>
            <div class="card-body">
                <form action="{{ url('transaksi/store') }}" method="POST">
                    @csrf
                    <!-- Pilih Nasabah -->
                    <div class="mb-3">
                        <label>Nasabah</label>
                        <select name="nasabah_id" class="form-select" required>
                            @foreach($nasabahs as $n)
                                <option value="{{ $n->id }}">{{ $n->user->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Sampah -->
                    <div class="mb-3">
                        <label>Jenis Sampah</label>
                        <select name="jenis_sampah_id" id="jenis_sampah" class="form-select" required onchange="hitungTotal()">
                            @foreach($jenisSampahs as $s)
                                <option value="{{ $s->id }}" data-harga="{{ $s->harga_per_kg }}">{{ $s->nama_jenis }} (Rp {{ number_format($s->harga_per_kg) }}/kg)</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Berat -->
                    <div class="mb-3">
                        <label>Berat (Kg)</label>
                        <input type="number" name="berat" id="berat" class="form-control" step="0.1" required oninput="hitungTotal()">
                    </div>

                    <!-- Total -->
                    <div class="mb-3">
                        <label>Total Nilai (Rp)</label>
                        <input type="text" id="total_nilai" class="form-control" readonly>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan & Cetak Struk</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function hitungTotal() {
            let harga = document.getElementById('jenis_sampah').options[document.getElementById('jenis_sampah').selectedIndex].getAttribute('data-harga');
            let berat = document.getElementById('berat').value;
            let total = harga * berat;
            document.getElementById('total_nilai').value = new Intl.NumberFormat('id-ID').format(total);
        }
    </script>
</x-app-layout>