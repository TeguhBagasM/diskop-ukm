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
                                    <th class="text-center" style="width: 100px; font-weight: 600; color: #1976d2;">Tanggal Kegiatan</th>
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
                                        <span class="badge text-black" style="border-radius: 12px;">
                                            {{ $agenda->tanggal_kegiatan->format('d M Y') }}
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
                                    <h6 class="card-title text-warning mb-1">Agenda Disposisi</h6>
                                    <h3 class="mb-0 text-warning">{{ $disposisiAgenda ?? 0 }}</h3>
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
                                    <h6 class="card-title text-danger mb-1">Agenda Dihadiri</h6>
                                    <h3 class="mb-0 text-danger">{{ $dihadiriAgenda ?? 0 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x text-danger opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="row mt-4">
                <!-- Pegawai Card -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 stats-card">
                        <div class="card-body text-center">
                            <div class="stats-header d-flex align-items-center justify-content-center mb-3">
                                <i class="fas fa-users me-2"></i>
                                <h6 class="mb-0 fw-bold">PEGAWAI</h6>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="stats-item">
                                        <h6 class="text-muted mb-1">Pegawai ASN</h6>
                                        <h4 class="fw-bold text-primary mb-0">38</h4>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-item">
                                        <h6 class="text-muted mb-1">Pegawai Non ASN</h6>
                                        <h4 class="fw-bold text-info mb-0">25</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="total-pegawai mb-3">
                                <h6 class="text-muted mb-1">Total Pegawai</h6>
                                <h2 class="fw-bold text-success mb-0">62</h2>
                            </div>

                            <div class="row text-center">
                                <div class="col-3">
                                    <div class="gender-stats">
                                        <i class="fas fa-male text-primary mb-1"></i>
                                        <div class="fw-bold">21</div>
                                        <small class="text-muted">Laki-laki</small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="gender-stats">
                                        <i class="fas fa-female text-danger mb-1"></i>
                                        <div class="fw-bold">15</div>
                                        <small class="text-muted">Perempuan</small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="gender-stats">
                                        <i class="fas fa-male text-success mb-1"></i>
                                        <div class="fw-bold">16</div>
                                        <small class="text-muted">Laki-laki</small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="gender-stats">
                                        <i class="fas fa-female text-warning mb-1"></i>
                                        <div class="fw-bold">10</div>
                                        <small class="text-muted">Perempuan</small>
                                    </div>
                                </div>
                            </div>

                            <small class="text-muted mt-2 d-block">Diupdate: 30 Jul 2024</small>
                        </div>
                    </div>
                </div>

                <!-- Indikator Kinerja Utama -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 stats-card">
                        <div class="card-body">
                            <div class="stats-header d-flex align-items-center justify-content-center mb-3">
                                <i class="fas fa-chart-line me-2"></i>
                                <h6 class="mb-0 fw-bold">INDIKATOR KINERJA UTAMA</h6>
                            </div>

                            <div class="iku-item mb-3 p-3" style="background-color: #f8f9fa; border-radius: 8px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">Indikator Sasaran</small>
                                        <div class="fw-bold">Meningkat 10%</div>
                                    </div>
                                    <span class="badge bg-success">95.5%</span>
                                </div>
                            </div>

                            <div class="iku-item mb-3 p-3" style="background-color: #f8f9fa; border-radius: 8px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">Persentase Kegiatan Selesai</small>
                                        <div class="fw-bold">Target 85%</div>
                                    </div>
                                    <span class="badge bg-warning">78.4%</span>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
                                </div>
                                <small class="text-muted">Overall Performance: 85%</small>
                            </div>

                            <small class="text-muted mt-2 d-block text-center">Diupdate: 30 Jul 2024</small>
                        </div>
                    </div>
                </div>

                <!-- Dana Bergulir UKM -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 stats-card">
                        <div class="card-body">
                            <div class="stats-header d-flex align-items-center justify-content-center mb-3">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                <h6 class="mb-0 fw-bold">DANA BERGULIR UKM</h6>
                            </div>

                            <div class="dana-item mb-3 text-center">
                                <h6 class="text-muted mb-1">Realisasi Tahun</h6>
                                <h5 class="fw-bold text-success mb-0">Rp 2.XXX.XXX.XXX,00</h5>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between">
                                        <small>Penyaluran Koperasi</small>
                                        <span class="badge bg-primary">85.2%</span>
                                    </div>
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar bg-primary" style="width: 85.2%"></div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between">
                                        <small>Penyaluran UKM</small>
                                        <span class="badge bg-info">72.4%</span>
                                    </div>
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar bg-info" style="width: 72.4%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <small class="text-muted">Total Beneficiaries</small>
                                <h4 class="fw-bold text-primary">1,247</h4>
                            </div>

                            <small class="text-muted mt-2 d-block text-center">Diupdate: 30 Jul 2024</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Row Statistics -->
            <div class="row">
                <!-- Realisasi Anggaran -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 stats-card">
                        <div class="card-body">
                            <div class="stats-header d-flex align-items-center justify-content-center mb-4">
                                <i class="fas fa-chart-pie me-2"></i>
                                <h6 class="mb-0 fw-bold">REALISASI ANGGARAN</h6>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="anggaran-item mb-3 p-3" style="border: 1px solid #e9ecef; border-radius: 8px;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">Belanja Pegawai</small>
                                            <span class="badge bg-success progress-badge">85.5%</span>
                                        </div>
                                        <h6 class="mb-1 text-success">Rp 3.XXX.XXX.XXX,00</h6>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-success" style="width: 85.5%"></div>
                                        </div>
                                    </div>

                                    <div class="anggaran-item mb-3 p-3" style="border: 1px solid #e9ecef; border-radius: 8px;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">Belanja Pemeliharaan dan Modal</small>
                                            <span class="badge bg-primary progress-badge">92.1%</span>
                                        </div>
                                        <h6 class="mb-1 text-primary">Rp 1.XXX.XXX.XXX,00</h6>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-primary" style="width: 92.1%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="anggaran-item mb-3 p-3" style="border: 1px solid #e9ecef; border-radius: 8px;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">Belanja Subsidi</small>
                                            <span class="badge bg-warning progress-badge">78.3%</span>
                                        </div>
                                        <h6 class="mb-1 text-warning">Rp 2.XXX.XXX.XXX,00</h6>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-warning" style="width: 78.3%"></div>
                                        </div>
                                    </div>

                                    <div class="anggaran-item mb-3 p-3" style="border: 1px solid #e9ecef; border-radius: 8px;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">Belanja Modal Hibah</small>
                                            <span class="badge bg-info progress-badge">65.7%</span>
                                        </div>
                                        <h6 class="mb-1 text-info">Rp 1.XXX.XXX.XXX,00</h6>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-info" style="width: 65.7%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="anggaran-item p-3" style="border: 1px solid #e9ecef; border-radius: 8px;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">Belanja Bantuan Sosial</small>
                                            <span class="badge bg-secondary progress-badge">89.4%</span>
                                        </div>
                                        <h6 class="mb-1 text-secondary">Rp 4.XXX.XXX.XXX,00</h6>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-secondary" style="width: 89.4%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="anggaran-item p-3" style="border: 1px solid #e9ecef; border-radius: 8px;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">Pembangunan Sarpras</small>
                                            <span class="badge bg-danger progress-badge">94.2%</span>
                                        </div>
                                        <h6 class="mb-1 text-danger">Rp 5.XXX.XXX.XXX,00</h6>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-danger" style="width: 94.2%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <small class="text-muted mt-3 d-block text-center">Diupdate: 30 Jul 2024</small>
                        </div>
                    </div>
                </div>

                <!-- Koperasi & UMKM -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 stats-card">
                        <div class="card-body">
                            <div class="row h-100">
                                <!-- Koperasi Section -->
                                <div class="col-md-6 border-end">
                                    <div class="stats-header d-flex align-items-center justify-content-center mb-3">
                                        <i class="fas fa-handshake me-2"></i>
                                        <h6 class="mb-0 fw-bold">KOPERASI</h6>
                                    </div>

                                    <div class="text-center mb-3">
                                        <h6 class="text-muted mb-1">Jumlah Koperasi</h6>
                                        <h2 class="fw-bold text-primary">1900</h2>
                                    </div>

                                    <!-- Chart Placeholder -->
                                    <div class="chart-placeholder mb-3 text-center">
                                        <canvas id="koperasiChart" width="150" height="100"></canvas>
                                    </div>

                                    <div class="koperasi-stats">
                                        <div class="d-flex justify-content-between mb-2">
                                            <small>Jumlah Koperasi BAT</small>
                                            <span class="fw-bold">245</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <small>Jumlah Koperasi Sehat</small>
                                            <span class="fw-bold">XXXX</span>
                                        </div>

                                        <!-- Pie Chart Legend -->
                                        <div class="mt-3">
                                            <h6 class="mb-2 fw-bold">Jenis Koperasi</h6>
                                            <div class="legend-item d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <span class="legend-color bg-success me-2" style="width: 12px; height: 12px; border-radius: 2px; display: inline-block;"></span>
                                                    <small>Kuliner</small>
                                                </div>
                                                <small class="fw-bold">40%</small>
                                            </div>
                                            <div class="legend-item d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <span class="legend-color bg-primary me-2" style="width: 12px; height: 12px; border-radius: 2px; display: inline-block;"></span>
                                                    <small>Fashion</small>
                                                </div>
                                                <small class="fw-bold">25%</small>
                                            </div>
                                            <div class="legend-item d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <span class="legend-color bg-warning me-2" style="width: 12px; height: 12px; border-radius: 2px; display: inline-block;"></span>
                                                    <small>Kerajinan</small>
                                                </div>
                                                <small class="fw-bold">20%</small>
                                            </div>
                                            <div class="legend-item d-flex justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <span class="legend-color bg-info me-2" style="width: 12px; height: 12px; border-radius: 2px; display: inline-block;"></span>
                                                    <small>Lainnya</small>
                                                </div>
                                                <small class="fw-bold">15%</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <small class="text-muted mt-3 d-block text-center">Diupdate: 30 Jul 2024</small>
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
}

.avatar-circle {
    text-transform: uppercase;
}

.badge {
    font-size: 0.75rem;
}

/* Statistics Cards Styling */
.stats-card {
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
    border: none;
    border-radius: 12px;
}

.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,.15);
}

.stats-header {
    color: #5a6c7d;
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 10px;
}

.stats-item {
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 10px;
}

.gender-stats {
    padding: 8px;
}

.gender-stats i {
    font-size: 1.2rem;
}

.iku-item {
    transition: all 0.3s ease;
}

.iku-item:hover {
    background-color: #e9ecef !important;
    transform: translateX(5px);
}

.dana-item {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.anggaran-item {
    transition: all 0.3s ease;
}

.anggaran-item:hover {
    transform: scale(1.02);
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}

.progress-badge {
    font-size: 0.7rem;
    padding: 4px 8px;
}

.chart-placeholder {
    height: 120px;
    background-color: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px dashed #dee2e6;
}

.legend-item {
    font-size: 0.8rem;
    padding: 2px 0;
}

.legend-color {
    flex-shrink: 0;
}

.koperasi-stats, .umkm-stats {
    font-size: 0.85rem;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-header {
        padding: 15px 20px;
        font-size: 1.1rem;
    }

    .stats-card .card-body {
        padding: 1rem;
    }

    .row .col-md-6.border-end {
        border-right: none !important;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }
}

/* Chart Styling */
#koperasiChart, #umkmChart {
    max-height: 100px;
}
</style>

<!-- Chart.js Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Koperasi Chart
    const koperasiCtx = document.getElementById('koperasiChart');
    if (koperasiCtx) {
        new Chart(koperasiCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Koperasi Baru',
                    data: [12, 19, 15, 25, 22, 18, 24],
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        display: false
                    },
                    x: {
                        display: false
                    }
                }
            }
        });
    }

    // UMKM Chart
    const umkmCtx = document.getElementById('umkmChart');
    if (umkmCtx) {
        new Chart(umkmCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'UMKM Baru',
                    data: [65, 89, 95, 102, 88, 94, 108],
                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        display: false
                    },
                    x: {
                        display: false
                    }
                }
            }
        });
    }
});
</script>
@endsection
