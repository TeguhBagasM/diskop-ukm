@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header Dashboard -->
            <div class="d-flex justify-content-center mb-4">
                <div class="dashboard-header">
                    <h3 class="mb-0">DASHBOARD PIMPINAN</h3>
                </div>
            </div>

            <!-- Agenda Kegiatan Hari Ini -->
            <div class="card">
                <div class="card-body" style="padding: 0;">
                    <!-- Header Agenda -->
                    <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0" style="font-weight: 600;">AGENDA KEGIATAN HARI INI</h5>
                            <span class="badge bg-primary ms-2" style="border-radius: 15px;">{{ date('d M Y') }}</span>
                        </div>
                        <div>
                            <a href="{{ route('admin.agenda.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i> Lihat Semua
                            </a>
                        </div>
                    </div>

                    <!-- Tabel Agenda -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #e8f4fd;">
                                <tr>
                                    <th class="text-center" style="width: 50px; font-weight: 600; color: #1976d2;">No</th>
                                    <th class="text-center" style="width: 120px; font-weight: 600; color: #1976d2;">Jenis Kegiatan</th>
                                    <th style="font-weight: 600; color: #1976d2;">Nama Kegiatan</th>
                                    <th class="text-center" style="width: 100px; font-weight: 600; color: #1976d2;">Sumber</th>
                                    <th style="width: 150px; font-weight: 600; color: #1976d2;">Tempat</th>
                                    <th class="text-center" style="width: 80px; font-weight: 600; color: #1976d2;">Waktu</th>
                                    <th style="width: 180px; font-weight: 600; color: #1976d2;">Pegawai yang Ditugaskan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todayAgenda as $index => $agenda)
                                <tr style="border-left: 4px solid {{ $agenda->jenis_kegiatan == 'INTERNAL' ? '#4caf50' : '#ff9800' }};">
                                    <td class="text-center" style="vertical-align: middle;">
                                        <span class="badge bg-light text-dark" style="border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <span class="badge bg-{{ $agenda->jenis_kegiatan == 'INTERNAL' ? 'success' : 'warning' }}"
                                              style="border-radius: 15px; padding: 6px 12px;">
                                            {{ $agenda->jenis_kegiatan }}
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle; font-weight: 500;">
                                        {{ $agenda->nama_kegiatan }}
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <span class="badge bg-info text-white" style="border-radius: 12px;">
                                            {{ $agenda->sumber }}
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        {{ $agenda->tempat }}
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <span class="badge bg-dark" style="border-radius: 15px; padding: 6px 12px;">
                                            <i class="fas fa-clock me-1"></i>{{ date('H:i', strtotime($agenda->waktu)) }}
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2" style="width: 32px; height: 32px; background-color: #5a6c7d; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">
                                                {{ substr($agenda->pegawai_yang_ditugaskan, 0, 2) }}
                                            </div>
                                            <span style="font-weight: 500;">{{ $agenda->pegawai_yang_ditugaskan }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                            <h6 class="text-muted">Tidak ada agenda kegiatan hari ini</h6>
                                            <small class="text-muted">Silakan tambah agenda kegiatan baru</small>
                                            <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary btn-sm mt-2">
                                                <i class="fas fa-plus"></i> Tambah Agenda
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mt-4">
                <div class="col-md-3 mb-3">
                    <div class="card h-100" style="border-left: 4px solid #4caf50; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title text-success mb-1">Agenda Hari Ini</h6>
                                    <h3 class="mb-0 text-success">{{ $todayAgenda->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar-day fa-2x text-success opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card h-100" style="border-left: 4px solid #2196f3; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title text-primary mb-1">Total Agenda Bulan Ini</h6>
                                    <h3 class="mb-0 text-primary">{{ $monthlyAgenda ?? 0 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar-alt fa-2x text-primary opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card h-100" style="border-left: 4px solid #ff9800; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title text-warning mb-1">Agenda Pending</h6>
                                    <h3 class="mb-0 text-warning">{{ $pendingAgenda ?? 0 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x text-warning opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card h-100" style="border-left: 4px solid #f44336; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title text-danger mb-1">Agenda Selesai</h6>
                                    <h3 class="mb-0 text-danger">{{ $completedAgenda ?? 0 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x text-danger opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-header {
    background-color: #5a6c7d;
    color: white;
    padding: 15px 420px;
    border-radius: 50px;
    font-weight: bold;
    margin-top: 50px;
    font-size: 1.3rem;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}

.card {
    border-radius: 12px;
    border: none;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,.15) !important;
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
    /* transform: scale(1.01);
    transition: all 0.2s ease; */
}

.avatar-circle {
    text-transform: uppercase;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endsection
