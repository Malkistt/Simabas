<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jenis Sampah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ url('admin/jenis-sampah') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Jenis Sampah</label>
                        <input type="text" name="nama_jenis" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga per Kg (Rp)</label>
                        <input type="number" name="harga_per_kg" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>