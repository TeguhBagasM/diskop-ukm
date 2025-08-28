@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center p-3" style="background-color: #6c7b7f; color: white;">
                    <h4 class="mb-0">AGENDA KEGIATAN DINAS KOPERASI DAN UKM KABUPATEN BANDUNG</h4>
                    <a href="{{ route('admin.agenda.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus"></i> Tambah Agenda
                    </a>
                </div>

                <div class="card-body">
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
                            <form method="GET" action="{{ route('admin.agenda.index') }}" class="d-flex">
                                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                <input type="text" class="form-control form-control-sm me-2"
                                       name="search"
                                       placeholder="Search..."
                                       value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr style="background-color: #e8f4fd;">
                                    <th class="text-center" style="width: 50px;">NO</th>
                                    <th class="text-center" style="width: 100px;">JENIS KEGIATAN</th>
                                    <th class="text-center" style="width: 200px;">NAMA KEGIATAN</th>
                                    <th class="text-center" style="width: 120px;">SUMBER</th>
                                    <th class="text-center" style="width: 150px;">TEMPAT</th>
                                    <th class="text-center" style="width: 80px;">WAKTU</th>
                                    <th class="text-center" style="width: 150px;">PEGAWAI YANG DITUGASKAN</th>
                                    <th class="text-center" style="width: 100px;">TINDAK LANJUT</th>
                                    <th class="text-center" style="width: 100px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($agendaKegiatan as $index => $agenda)
                                <tr>
                                    <td class="text-center">{{ $agendaKegiatan->firstItem() + $index }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $agenda->jenis_kegiatan == 'INTERNAL' ? 'primary' : 'warning' }}">
                                            {{ $agenda->jenis_kegiatan }}
                                        </span>
                                    </td>
                                    <td>{{ $agenda->nama_kegiatan }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $agenda->sumber }}</span>
                                    </td>
                                    <td>{{ $agenda->tempat }}</td>
                                    <td class="text-center">{{ date('H:i', strtotime($agenda->waktu)) }}</td>
                                    <td>{{ $agenda->pegawai_yang_ditugaskan }}</td>
                                    <td class="text-center">
                                        @if($agenda->tindak_lanjut == 'SELESAI')
                                            <span class="text-success">
                                                <i class="fas fa-check-circle"></i>
                                                <i class="fas fa-edit text-primary ms-1"></i>
                                            </span>
                                        @elseif($agenda->tindak_lanjut == 'PENDING')
                                            <i class="fas fa-edit text-danger"></i>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.agenda.show', $agenda) }}"
                                               class="btn btn-info btn-sm"
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.agenda.edit', $agenda) }}"
                                               class="btn btn-warning btn-sm"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.agenda.destroy', $agenda) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus agenda ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                        <br>
                                        Tidak ada data agenda kegiatan.
                                        <br>
                                        <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary btn-sm mt-2">
                                            <i class="fas fa-plus"></i> Tambah Agenda Pertama
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination dan Info -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Menampilkan {{ $agendaKegiatan->firstItem() ?? 0 }} - {{ $agendaKegiatan->lastItem() ?? 0 }}
                            dari {{ $agendaKegiatan->total() }} data
                        </div>
                        <div>
                            {{ $agendaKegiatan->appends(request()->query())->links() }}
                        </div>
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
.table th {
    font-weight: 600;
    font-size: 0.875rem;
}

.table td {
    font-size: 0.875rem;
    vertical-align: middle;
}

.btn-group .btn {
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-radius: 0.25rem 0 0 0.25rem;
}

.btn-group .btn:last-child {
    border-radius: 0 0.25rem 0.25rem 0;
}

.card-header {
    font-weight: 600;
}
</style>
@endsection
