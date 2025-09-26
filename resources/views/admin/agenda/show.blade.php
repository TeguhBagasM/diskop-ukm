@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header Dashboard Style -->
            <div class="d-flex justify-content-center mb-4">
                <div class="dashboard-header">
                    <h3 class="mb-0">DETAIL AGENDA KEGIATAN DINAS KOPERASI DAN UKM</h3>
                </div>
            </div>

            <!-- Action Buttons Card -->
            <div class="card mb-3">
                <div class="card-body" style="padding: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-{{ $agenda->jenis_kegiatan == 'INTERNAL' ? 'success' : 'warning' }} me-2" style="border-radius: 15px; padding: 8px 16px;">
                                <i class="fas fa-tag me-1"></i>{{ $agenda->jenis_kegiatan }}
                            </span>
                            <span class="badge bg-info me-2" style="border-radius: 15px; padding: 8px 16px;">
                                <i class="fas fa-building me-1"></i>{{ $agenda->sumber }}
                            </span>
                            @if($agenda->tindak_lanjut == 'DIHADIRI')
                                <span class="badge bg-success" style="border-radius: 15px; padding: 8px 16px;">
                                    <i class="fas fa-check-circle me-1"></i>DIHADIRI
                                </span>
                            @elseif($agenda->tindak_lanjut == 'DISPOSISI')
                                <span class="badge bg-warning" style="border-radius: 15px; padding: 8px 16px;">
                                    <i class="fas fa-clock me-1"></i>DISPOSISI
                                </span>
                            @endif
                        </div>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route('admin.agenda.edit', $agenda) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.agenda.destroy', $agenda) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus agenda ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Main Detail Card -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="background: linear-gradient(135deg, #5a6c7d 0%, #495761 100%); color: white; border-radius: 12px 12px 0 0;">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>INFORMASI DETAIL AGENDA
                            </h5>
                        </div>
                        <div class="card-body" style="padding: 0;">
                            <!-- Nama Kegiatan -->
                            <div class="detail-section">
                                <div class="detail-header">
                                    <i class="fas fa-calendar-check text-success"></i>
                                    <span>Nama Kegiatan</span>
                                </div>
                                <div class="detail-content">
                                    <h4 class="text-primary mb-0">{{ $agenda->nama_kegiatan }}</h4>
                                </div>
                            </div>

                            <!-- Waktu dan Tempat -->
                            <div class="detail-section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <div class="detail-label">
                                                <i class="fas fa-calendar text-warning"></i>
                                                Tanggal Kegiatan
                                            </div>
                                            <div class="detail-value">
                                                <span class="badge bg-warning text-dark" style="border-radius: 20px; padding: 10px 15px; font-size: 0.9rem;">
                                                    {{ $agenda->tanggal_kegiatan ? $agenda->tanggal_kegiatan->format('d F Y') : '-' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <div class="detail-label">
                                                <i class="fas fa-clock text-dark"></i>
                                                Waktu
                                            </div>
                                            <div class="detail-value">
                                                <span class="badge bg-dark" style="border-radius: 20px; padding: 10px 15px; font-size: 0.9rem;">
                                                    {{ $agenda->waktu ? date('H:i', strtotime($agenda->waktu)) : '-' }} WIB
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tempat -->
                            <div class="detail-section">
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                        Tempat Kegiatan
                                    </div>
                                    <div class="detail-value">
                                        <div class="location-card">
                                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                            <span>{{ $agenda->tempat }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pegawai yang Ditugaskan -->
                            <div class="detail-section">
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-user-tie text-primary"></i>
                                        Pegawai yang Ditugaskan
                                    </div>
                                    <div class="detail-value">
                                        <div class="employee-card">
                                            {{-- <div class="avatar-circle me-3" style="width: 40px; height: 40px; background-color: #5a6c7d; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px;">
                                                {{ substr($agenda->pegawai_yang_ditugaskan, 0, 2) }}
                                            </div> --}}
                                            <div>
                                                <strong>{{ $agenda->pegawai_yang_ditugaskan }}</strong>
                                                <br>
                                                <small class="text-muted">Penanggung Jawab Kegiatan</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($agenda->keterangan)
                            <!-- Keterangan -->
                            <div class="detail-section">
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-comment text-muted"></i>
                                        Keterangan
                                    </div>
                                    <div class="detail-value">
                                        <div class="keterangan-card">
                                            <p class="mb-0">{{ $agenda->keterangan }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Side Information -->
                <div class="col-md-4">
                    <!-- Status Card -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-tasks"></i> Status Tindak Lanjut
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            @if($agenda->tindak_lanjut == 'DIHADIRI')
                                <div class="status-icon text-success mb-2">
                                    <i class="fas fa-check-circle fa-3x"></i>
                                </div>
                                <h5 class="text-success">DIHADIRI</h5>
                                <p class="text-muted small">Kegiatan telah dilaksanakan dengan baik</p>
                            @elseif($agenda->tindak_lanjut == 'DISPOSISI')
                                <div class="status-icon text-warning mb-2">
                                    <i class="fas fa-clock fa-3x"></i>
                                </div>
                                <h5 class="text-warning">DISPOSISI</h5>
                                <p class="text-muted small">Kegiatan sedang menunggu tindak lanjut</p>
                            @else
                                <div class="status-icon text-secondary mb-2">
                                    <i class="fas fa-question-circle fa-3x"></i>
                                </div>
                                <h5 class="text-secondary">-</h5>
                                <p class="text-muted small">Status belum ditentukan</p>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Info Card -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-info"></i> Informasi Cepat
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="quick-info-item">
                                <div class="quick-info-label">Jenis Kegiatan:</div>
                                <div class="quick-info-value">
                                    <span class="badge bg-{{ $agenda->jenis_kegiatan == 'INTERNAL' ? 'success' : 'warning' }}">
                                        {{ $agenda->jenis_kegiatan }}
                                    </span>
                                </div>
                            </div>
                            <div class="quick-info-item">
                                <div class="quick-info-label">Sumber:</div>
                                <div class="quick-info-value">
                                    <span class="badge bg-info">{{ $agenda->sumber }}</span>
                                </div>
                            </div>
                            <div class="quick-info-item">
                                <div class="quick-info-label">Tanggal:</div>
                                <div class="quick-info-value">
                                    {{ $agenda->tanggal_kegiatan ? $agenda->tanggal_kegiatan->format('d/m/Y') : '-' }}
                                </div>
                            </div>
                            <div class="quick-info-item">
                                <div class="quick-info-label">Waktu:</div>
                                <div class="quick-info-value">
                                    {{ $agenda->waktu ? date('H:i', strtotime($agenda->waktu)) : '-' }} WIB
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timestamp Card -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-history"></i> Riwayat Data
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="timeline-item">
                                <div class="timeline-icon bg-success">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Dibuat</h6>
                                    <small class="text-muted">
                                        {{ $agenda->created_at ? $agenda->created_at->format('d F Y, H:i') : '-' }}
                                    </small>
                                </div>
                            </div>
                            @if($agenda->updated_at && $agenda->updated_at != $agenda->created_at)
                            <div class="timeline-item">
                                <div class="timeline-icon bg-warning">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Terakhir Diupdate</h6>
                                    <small class="text-muted">
                                        {{ $agenda->updated_at->format('d F Y, H:i') }}
                                    </small>
                                </div>
                            </div>
                            @endif
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
    margin-bottom: 20px;
}

.detail-section {
    border-bottom: 1px solid #f1f1f1;
    padding: 20px;
}

.detail-section:last-child {
    border-bottom: none;
}

.detail-header {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    font-weight: 600;
    color: #5a6c7d;
    font-size: 1rem;
}

.detail-header i {
    margin-right: 8px;
    font-size: 1.1rem;
}

.detail-content h4 {
    font-weight: 600;
    line-height: 1.4;
}

.detail-item {
    margin-bottom: 15px;
}

.detail-label {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    font-weight: 600;
    color: #5a6c7d;
    font-size: 0.9rem;
}

.detail-label i {
    margin-right: 8px;
    font-size: 1rem;
}

.detail-value {
    margin-left: 24px;
}

.location-card {
    background-color: #fff5f5;
    padding: 15px;
    border-radius: 10px;
    border-left: 4px solid #dc3545;
    display: flex;
    align-items: center;
    font-weight: 500;
}

.employee-card {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    border-left: 4px solid #5a6c7d;
    display: flex;
    align-items: center;
}

.keterangan-card {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    border-left: 4px solid #6c757d;
    line-height: 1.6;
}

.quick-info-item {
    display: flex;
    justify-content: between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f1f1f1;
}

.quick-info-item:last-child {
    border-bottom: none;
}

.quick-info-label {
    font-weight: 500;
    color: #5a6c7d;
    flex: 1;
    font-size: 0.9rem;
}

.quick-info-value {
    font-weight: 500;
    text-align: right;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
    position: relative;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 15px;
    top: 35px;
    height: calc(100% - 5px);
    width: 2px;
    background-color: #dee2e6;
}

.timeline-icon {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.8rem;
    margin-right: 15px;
    z-index: 1;
    position: relative;
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-weight: 600;
    color: #5a6c7d;
}

.btn {
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.badge {
    font-size: 0.75rem;
}

.status-icon {
    margin-bottom: 10px;
}

@media (max-width: 768px) {
    .detail-value {
        margin-left: 0;
        margin-top: 8px;
    }

    .employee-card, .location-card {
        flex-direction: column;
        text-align: center;
    }

    .employee-card .avatar-circle {
        margin-bottom: 10px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scroll for any anchor links if needed
    const scrollLinks = document.querySelectorAll('a[href^="#"]');
    scrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Add loading state for buttons
    const actionButtons = document.querySelectorAll('.btn[type="submit"]');
    actionButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            this.disabled = true;
        });
    });
});
</script>
@endsection
