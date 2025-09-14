@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Header Dashboard Style -->
            <div class="d-flex justify-content-center mb-4">
                <div class="dashboard-header">
                    <h3 class="mb-0">DATA PEGAWAI DINAS KOPERASI DAN UKM KABUPATEN BANDUNG</h3>
                </div>
            </div>

            <div class="card">
                <div class="card-body" style="padding: 0;">
                    <!-- Header dengan style seperti dashboard -->
                    <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0" style="font-weight: 600; color: #5a6c7d;">DAFTAR DATA PEGAWAI</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.pegawai.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Pegawai
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
                            <div class="col-md-4 ms-auto">
                                <form method="GET" action="{{ route('admin.pegawai.index') }}" class="d-flex">
                                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                    <input type="text" class="form-control form-control-sm me-2"
                                           name="search"
                                           placeholder="Cari nama, NIP, jabatan..."
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
                                        <th class="text-center" style="width: 180px; font-weight: 600; color: #1976d2;">NAMA PEGAWAI</th>
                                        <th class="text-center" style="width: 100px; font-weight: 600; color: #1976d2;">JENIS KELAMIN</th>
                                        <th class="text-center" style="width: 100px; font-weight: 600; color: #1976d2;">UMUR</th>
                                        <th class="text-center" style="width: 140px; font-weight: 600; color: #1976d2;">NIP</th>
                                        <th class="text-center" style="width: 120px; font-weight: 600; color: #1976d2;">NO. TELP</th>
                                        <th class="text-center" style="width: 100px; font-weight: 600; color: #1976d2;">STATUS</th>
                                        <th class="text-center" style="width: 100px; font-weight: 600; color: #1976d2;">PENDIDIKAN</th>
                                        <th class="text-center" style="width: 150px; font-weight: 600; color: #1976d2;">JABATAN</th>
                                        <th class="text-center" style="width: 120px; font-weight: 600; color: #1976d2;">BIDANG</th>
                                        <th class="text-center" style="width: 120px; font-weight: 600; color: #1976d2;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $index => $pegawai)
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span class="badge bg-light text-dark" style="border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                                {{ $loop->iteration }}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2" style="width: 40px; height: 40px; background-color: {{ $pegawai->jenis_kelamin == 'L' ? '#2196f3' : '#e91e63' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                                                    {{ substr($pegawai->nama, 0, 2) }}
                                                </div>
                                                <div>
                                                    <span style="font-weight: 600;">{{ $pegawai->nama }}</span>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-birthday-cake me-1"></i>
                                                        {{ date('d/m/Y', strtotime($pegawai->tanggal_lahir)) }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center text-capitalize" style="vertical-align: middle;">
                                            {{ $pegawai->jenis_kelamin }}
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span style="border-radius: 15px; padding: 6px 12px;">
                                                {{ $pegawai->umur }} Tahun
                                            </span>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span style="border-radius: 12px; font-family: monospace;">
                                                {{ $pegawai->nip }}
                                            </span>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span class="text-muted">
                                                <i class="fas fa-phone me-1"></i>
                                                {{ $pegawai->no_telp }}
                                            </span>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                                {{ $pegawai->status }}
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span style="border-radius: 12px;">
                                                {{ $pegawai->pendidikan }}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle; font-weight: 500;">
                                            <i class="fas fa-user-tie text-primary me-1"></i>
                                            {{ $pegawai->jabatan }}
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span class="badge bg-dark" style="border-radius: 12px;">
                                                {{ $pegawai->bidang }}
                                            </span>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.pegawai.show', $pegawai) }}"
                                                   class="btn btn-info btn-sm"
                                                   title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.pegawai.edit', $pegawai) }}"
                                                   class="btn btn-warning btn-sm"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.pegawai.destroy', $pegawai) }}"
                                                      method="POST"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            title="Hapus"
                                                            onclick="return confirm('Yakin ingin menghapus data pegawai ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                                <h6 class="text-muted">Tidak ada data pegawai</h6>
                                                <small class="text-muted">Silakan tambah data pegawai baru</small>
                                                <a href="{{ route('admin.pegawai.create') }}" class="btn btn-primary btn-sm mt-2">
                                                    <i class="fas fa-plus"></i> Tambah Pegawai Pertama
                                                </a>
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
                                Total: {{ count($data) }} data pegawai
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
