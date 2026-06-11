<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4 fw-bold">Riwayat Transaksi</h2>
        
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Nasabah</th>
                            <th>Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $r)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($r['tanggal'])->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $r['status'] }}">{{ $r['jenis'] }}</span>
                            </td>
                            <td>{{ $r['nama'] }}</td>
                            <td>Rp {{ number_format($r['jumlah'], 0, ',', '.') }}</td>
                            <td>
                                @if($r['jenis'] == 'Setoran')
                                    <a href="{{ route('transaksi.cetak', $r['id']) }}" class="btn btn-sm btn-info" target="_blank">Cetak</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>