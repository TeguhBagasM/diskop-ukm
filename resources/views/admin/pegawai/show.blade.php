@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header Dashboard Style -->
            <div class="d-flex justify-content-center mb-4">
                <div class="dashboard-header">
                    <h3 class="mb-0">DETAIL DATA PEGAWAI</h3>
                </div>
            </div>

            <div class="card">
                <div class="card-body" style="padding: 0;">
                    <!-- Header dengan style seperti dashboard -->
                    <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0" style="font-weight: 600; color: #5a6c7d;">
                                <i class="fas fa-user me-2"></i>INFORMASI PEGAWAI
                            </h5>
                            <span class="badge bg-info ms-2" style="border-radius: 15px;">{{ $pegawai->nip }}</span>
                        </div>
                        <div>
                            <a href="{{ route('admin.pegawai.edit', $pegawai) }}" class="btn btn-warning btn-sm me-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="row">
                            <!-- Profile Card -->
                            <div class="col-md-4 mb-4">
                                <div class="profile-card text-center">
                                    <div class="profile-avatar mb-3">
                                        <div class="avatar-large" style="width: 120px; height: 120px; background-color: {{ $pegawai->jenis_kelamin == 'L' ? '#2196f3' : '#e91e63' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 48px; margin: 0 auto;">
                                            {{ substr($pegawai->nama, 0, 2) }}
                                        </div>
                                    </div>
                                    <h4 class="profile-name">{{ $pegawai->nama }}</h4>
                                    <p class="profile-title text-muted">{{ $pegawai->jabatan }}</p>

                                    <div class="profile-badges mb-3">
                                        <span class="badge bg-{{ $pegawai->jenis_kelamin == 'L' ? 'primary' : 'danger' }} me-1" style="border-radius: 15px;">
                                            <i class="fas fa-{{ $pegawai->jenis_kelamin == 'L' ? 'mars' : 'venus' }} me-1"></i>
                                            {{ $pegawai->jenis_kelamin == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}
                                        </span>
                                        <br><br>
                                        <span class="badge bg-{{ $pegawai->status == 'AKTIF' ? 'success' : 'warning' }}" style="border-radius: 15px;">
                                            <i class="fas fa-{{ $pegawai->status == 'AKTIF' ? 'check-circle' : 'pause-circle' }} me-1"></i>
                                            {{ $pegawai->status }}
                                        </span>
                                    </div>

                                    <div class="profile-stats">
                                        <div class="stat-item">
                                            <div class="stat-value">{{ $pegawai->umur }}</div>
                                            <div class="stat-label">Tahun</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Details Card -->
                            <div class="col-md-8">
                                <!-- Data Pribadi Section -->
                                <div class="detail-section mb-4">
                                    <div class="section-header">
                                        <h6 class="section-title">
                                            <i class="fas fa-user text-primary me-2"></i>
                                            Data Pribadi
                                        </h6>
                                    </div>
                                    <div class="section-content">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="detail-item">
                                                    <label class="detail-label">Nama Lengkap</label>
                                                    <div class="detail-value">
                                                        <i class="fas fa-user text-muted me-2"></i>
                                                        {{ $pegawai->nama }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="detail-item">
                                                    <label class="detail-label">Jenis Kelamin</label>
                                                    <div class="detail-value">
                                                        <i class="fas fa-venus-mars text-muted me-2"></i>
                                                        {{ $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="detail-item">
                                                    <label class="detail-label">Tanggal Lahir</label>
                                                    <div class="detail-value">
                                                        <i class="fas fa-birthday-cake text-muted me-2"></i>
                                                        {{ date('d F Y', strtotime($pegawai->tanggal_lahir)) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="detail-item">
                                                    <label class="detail-label">Umur</label>
                                                    <div class="detail-value">
                                                        <i class="fas fa-calendar-alt text-muted me-2"></i>
                                                        {{ $pegawai->umur }} Tahun
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="detail-item">
                                                    <label class="detail-label">No. Telepon</label>
                                                    <div class="detail-value">
                                                        <i class="fas fa-phone text-muted me-2"></i>
                                                        <a href="tel:{{ $pegawai->no_telp }}" class="text-decoration-none">{{ $pegawai->no_telp }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Data Kepegawaian Section -->
                                <div class="detail-section mb-4">
                                    <div class="section-header">
                                        <h6 class="section-title">
                                            <i class="fas fa-id-card text-success me-2"></i>
                                            Data Kepegawaian
                                        </h6>
                                    </div>
                                    <div class="section-content">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="detail-item">
                                                    <label class="detail-label">NIP</label>
                                                    <div class="detail-value">
                                                        <i class="fas fa-id-badge text-muted me-2"></i>
                                                        <span class="badge bg-secondary" style="border-radius: 12px; font-family: monospace;">
                                                            {{ $pegawai->nip }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="detail-item">
                                                    <label class="detail-label">Status Kepegawaian</label>
                                                    <div class="detail-value">
                                                        <i class="fas fa-check-circle text-muted me-2"></i>
                                                        <span class="badge bg-{{ $pegawai->status == 'AKTIF' ? 'success' : 'warning' }}" style="border-radius: 15px;">
                                                            {{ $pegawai->status }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="detail-item">
                                                    <label class="detail-label">Pendidikan</label>
                                                    <div class="detail-value">
                                                        <i class="fas fa-graduation-cap text-muted me-2"></i>
                                                        <span class="badge bg-info text-white" style="border-radius: 12px;">
                                                            {{ $pegawai->pendidikan }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="detail-item">
                                                    <label class="detail-label">Jabatan</label>
                                                    <div class="detail-value">
                                                        <i class="fas fa-user-tie text-muted me-2"></i>
                                                        {{ $pegawai->jabatan }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="detail-item">
                                                    <label class="detail-label">Bidang</label>
                                                    <div class="detail-value">
                                                        <i class="fas fa-building text-muted me-2"></i>
                                                        <span class="badge bg-dark" style="border-radius: 12px;">
                                                            {{ $pegawai->bidang }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="action-buttons">
                                    <a href="{{ route('admin.pegawai.edit', $pegawai) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit Data Pegawai
                                    </a>
                                    <form action="{{ route('admin.pegawai.destroy', $pegawai) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus data pegawai {{ $pegawai->nama }}?')">
                                            <i class="fas fa-trash"></i> Hapus Data
                                        </button>
                                    </form>
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

.profile-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    padding: 30px 20px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.profile-name {
    color: #495057;
    font-weight: 700;
    margin-bottom: 5px;
}

.profile-title {
    font-size: 0.95rem;
    margin-bottom: 15px;
}

.profile-stats {
    background: white;
    border-radius: 10px;
    padding: 15px;
    margin-top: 15px;
}

.stat-item {
    text-align: center;
}

.stat-value {
    font-size: 24px;
    font-weight: bold;
    color: #5a6c7d;
}

.stat-label {
    font-size: 12px;
    color: #6c757d;
    text-transform: uppercase;
    font-weight: 500;
}

.detail-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    border-left: 4px solid #5a6c7d;
}

.section-header {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.section-title {
    color: #495057;
    font-weight: 600;
    margin: 0;
    font-size: 1.1rem;
}

.detail-item {
    margin-bottom: 15px;
}

.detail-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
    display: block;
}

.detail-value {
    font-size: 1rem;
    color: #495057;
    font-weight: 500;
}

.action-buttons {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #dee2e6;
}

.action-buttons .btn {
    margin-right: 10px;
    margin-bottom: 10px;
}

.badge {
    font-size: 0.85rem;
    padding: 6px 12px;
}

/* Hover effects */
.profile-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.detail-section:hover {
    background: #f1f3f4;
}
</style>
@endsection
