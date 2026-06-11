<x-app-layout>
    <div class="container py-4">
        <div class="card shadow-sm border-0 col-md-6 mx-auto">
            <div class="card-header bg-danger text-white">Form Penarikan Saldo</div>
            <div class="card-body">
                
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('penarikan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Pilih Nasabah</label>
                        <select name="nasabah_id" class="form-select" required>
                            @foreach($nasabahs as $n)
                                <option value="{{ $n->id }}">{{ $n->user->nama }} (Saldo: Rp {{ number_format($n->saldo) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Jumlah Penarikan (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 50000" required>
                    </div>

                    <button type="submit" class="btn btn-danger w-100">Proses Penarikan</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>