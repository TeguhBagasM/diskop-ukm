@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Header Dashboard Style -->
            <div class="d-flex justify-content-center mb-4">
                <div class="dashboard-header">
                    <h3 class="mb-0">DATA KOPERASI KAB. BANDUNG</h3>
                </div>
            </div>

            <div class="card">
                <div class="card-body" style="padding: 0;">
                    <!-- Header dengan style seperti dashboard -->
                    <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0" style="font-weight: 600; color: #5a6c7d;">DAFTAR DATA KOPERASI</h5>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.koperasi.upload.index') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-upload"></i> Upload Excel
                            </a>
                            <a href="{{ route('admin.koperasi.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Koperasi
                            </a>
                        </div>
                    </div>

                    <div class="p-3">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Filter dan Search -->
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="show" class="form-label">Show:</label>
                                <select class="form-select form-select-sm" id="show" name="per_page" onchange="updatePerPage()">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label">Status:</label>
                                <select class="form-select form-select-sm" id="status" name="status" onchange="applyFilters()">
                                    <option value="">Semua Status</option>
                                    <option value="AKTIF" {{ request('status') == 'AKTIF' ? 'selected' : '' }}>Aktif</option>
                                    <option value="TIDAK AKTIF" {{ request('status') == 'TIDAK AKTIF' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="jenis" class="form-label">Jenis:</label>
                                <select class="form-select form-select-sm" id="jenis" name="jenis" onchange="applyFilters()">
                                    <option value="">Semua Jenis</option>
                                    <option value="Produksi" {{ request('jenis') == 'Produksi' ? 'selected' : '' }}>Produksi</option>
                                    <option value="Konsumen" {{ request('jenis') == 'Konsumen' ? 'selected' : '' }}>Konsumen</option>
                                    <option value="Simpan Pinjam" {{ request('jenis') == 'Simpan Pinjam' ? 'selected' : '' }}>Simpan Pinjam</option>
                                    <option value="Serba Usaha" {{ request('jenis') == 'Serba Usaha' ? 'selected' : '' }}>Serba Usaha</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <form method="GET" action="{{ route('admin.koperasi.index') }}" class="d-flex">
                                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                    <input type="hidden" name="status" value="{{ request('status') }}">
                                    <input type="hidden" name="jenis" value="{{ request('jenis') }}">
                                    <label for="search" class="form-label me-2 pt-2">Search:</label>
                                    <input type="text" class="form-control form-control-sm me-2"
                                           name="search" id="search"
                                           placeholder="Cari nama koperasi, alamat, ketua..."
                                           value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #e8f4fd;">
                                    <tr>
                                        <th class="text-center" style="width: 50px; font-weight: 600; color: #1976d2;">NO</th>
                                        <th class="text-center" style="width: 250px; font-weight: 600; color: #1976d2;">KOPERASI</th>
                                        <th class="text-center" style="width: 200px; font-weight: 600; color: #1976d2;">ALAMAT</th>
                                        <th class="text-center" style="width: 100px; font-weight: 600; color: #1976d2;">KELURAHAN</th>
                                        <th class="text-center" style="width: 100px; font-weight: 600; color: #1976d2;">KECAMATAN</th>
                                        <th class="text-center" style="width: 80px; font-weight: 600; color: #1976d2;">STATUS</th>
                                        <th class="text-center" style="width: 120px; font-weight: 600; color: #1976d2;">JENIS KOPERASI</th>
                                        <th class="text-center" style="width: 120px; font-weight: 600; color: #1976d2;">TINDAH LANJUT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $index => $koperasi)
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span class="badge bg-light text-dark" style="border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                                {{ $data->firstItem() + $loop->index }}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2" style="width: 40px; height: 40px; background-color: {{ $koperasi->status == 'AKTIF' ? '#4caf50' : '#f44336' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                                                    <i class="fas fa-{{ $koperasi->status == 'AKTIF' ? 'handshake' : 'times' }}"></i>
                                                </div>
                                                <div>
                                                    <span style="font-weight: 600; font-size: 0.9rem;">{{ Str::limit($koperasi->nama_koperasi, 40) }}</span>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-user-tie me-1"></i>
                                                        {{ $koperasi->ketua ?? 'Belum diisi' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle; font-size: 0.85rem;">
                                            {{ Str::limit($koperasi->alamat, 50) }}
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            {{ $koperasi->kelurahan }}
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            {{ $koperasi->kecamatan }}
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span class="badge {{ $koperasi->status == 'AKTIF' ? 'bg-success' : 'bg-danger' }}" style="border-radius: 12px;">
                                                {{ $koperasi->status }}
                                            </span>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span class="badge bg-primary" style="border-radius: 12px;">
                                                {{ $koperasi->jenis_koperasi }}
                                            </span>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.koperasi.show', $koperasi) }}"
                                                   class="btn btn-info btn-sm"
                                                   title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.koperasi.edit', $koperasi) }}"
                                                   class="btn btn-warning btn-sm"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.koperasi.destroy', $koperasi) }}"
                                                      method="POST"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            title="Hapus"
                                                            onclick="return confirm('Yakin ingin menghapus data koperasi ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
                                                <h6 class="text-muted">Tidak ada data koperasi</h6>
                                                <small class="text-muted">Silakan tambah data koperasi baru atau upload file Excel</small>
                                                <div class="mt-2">
                                                    <a href="{{ route('admin.koperasi.upload.index') }}" class="btn btn-success btn-sm me-2">
                                                        <i class="fas fa-upload"></i> Upload Excel
                                                    </a>
                                                    <a href="{{ route('admin.koperasi.create') }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-plus"></i> Tambah Koperasi
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination dan Info -->
                        @if(method_exists($data, 'links'))
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }}
                                dari {{ $data->total() }} data
                            </div>
                            <div>
                                {{ $data->appends(request()->query())->links() }}
                            </div>
                        </div>
                        @else
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Total: {{ count($data) }} data koperasi
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updatePerPage() {
    const perPage = document.getElementById('show').value;
    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);
    window.location.href = url.toString();
}

function applyFilters() {
    const status = document.getElementById('status').value;
    const jenis = document.getElementById('jenis').value;
    const perPage = document.getElementById('show').value;

    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);

    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }

    if (jenis) {
        url.searchParams.set('jenis', jenis);
    } else {
        url.searchParams.delete('jenis');
    }

    window.location.href = url.toString();
}
</script>

<style>
.dashboard-header {
    background-color: #5a6c7d;
    color: white;
    padding: 15px 30px;
    border-radius: 50px;
    font-weight: bold;
    margin-top: 20px;
    font-size: 1.1rem;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}

.card {
    border-radius: 12px;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}

.table th {
    border-bottom: 2px solid #dee2e6;
    font-size: 0.875rem;
}

.table td {
    font-size: 0.875rem;
    border-bottom: 1px solid #f1f1f1;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.btn-group .btn {
    border-radius: 0.25rem;
    margin: 0 1px;
}

.avatar-circle {
    text-transform: uppercase;
}

.badge {
    font-size: 0.75rem;
}

/* Custom hover effects */
.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,.1);
}

/* Button hover effects */
.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}
</style>
@endsection
