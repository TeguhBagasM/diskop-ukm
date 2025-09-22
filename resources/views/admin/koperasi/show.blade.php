@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Header Dashboard Style -->
            <div class="d-flex justify-content-center mb-4">
                <div class="dashboard-header">
                    <h3 class="mb-0">DETAIL KOPERASI - {{ strtoupper($koperasi->nama_koperasi) }}</h3>
                </div>
            </div>

            <div class="card">
                <div class="card-body" style="padding: 0;">
                    <!-- Header dengan style seperti dashboard -->
                    <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0" style="font-weight: 600; color: #5a6c7d;">INFORMASI LENGKAP KOPERASI</h5>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.koperasi.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route('admin.koperasi.edit', $koperasi) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>

                    <div class="p-4">
                        <!-- Status Badge -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge {{ $koperasi->status == 'AKTIF' ? 'bg-success' : 'bg-danger' }} fs-6 px-3 py-2">
                                            <i class="fas fa-{{ $koperasi->status == 'AKTIF' ? 'check-circle' : 'times-circle' }} me-2"></i>
                                            {{ $koperasi->status }}
                                        </span>
                                        <span class="badge bg-primary fs-6 px-3 py-2 ms-2">
                                            <i class="fas fa-industry me-2"></i>
                                            {{ $koperasi->jenis_koperasi }}
                                        </span>
                                    </div>
                                    <div class="text-muted">
                                        <small>Terakhir diupdate: {{ $koperasi->updated_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Umum -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="border-bottom pb-2 mb-3" style="color: #5a6c7d; font-weight: 600;">
                                    <i class="fas fa-info-circle me-2"></i>INFORMASI UMUM
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Koperasi</label>
                                <p class="form-control-plaintext bg-light p-2 rounded">{{ $koperasi->nama_koperasi }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">No. Badan Hukum</label>
                                <p class="form-control-plaintext bg-light p-2 rounded">{{ $koperasi->no_badan_hukum ?? '-' }}</p>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Alamat</label>
                                <p class="form-control-plaintext bg-light p-2 rounded">{{ $koperasi->alamat }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Kelurahan</label>
                                <p class="form-control-plaintext bg-light p-2 rounded">{{ $koperasi->kelurahan }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Kecamatan</label>
                                <p class="form-control-plaintext bg-light p-2 rounded">{{ $koperasi->kecamatan }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Tanggal Berdiri</label>
                                <p class="form-control-plaintext bg-light p-2 rounded">
                                    {{ $koperasi->tanggal_berdiri ? $koperasi->tanggal_berdiri->format('d/m/Y') : '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- Pengurus -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="border-bottom pb-2 mb-3" style="color: #5a6c7d; font-weight: 600;">
                                    <i class="fas fa-users me-2"></i>PENGURUS KOPERASI
                                </h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-tie fa-2x mb-2"></i>
                                        <h6>Ketua</h6>
                                        <p class="mb-0">{{ $koperasi->ketua ?? 'Belum diisi' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-edit fa-2x mb-2"></i>
                                        <h6>Sekretaris</h6>
                                        <p class="mb-0">{{ $koperasi->sekretaris ?? 'Belum diisi' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <i class="fas fa-calculator fa-2x mb-2"></i>
                                        <h6>Bendahara</h6>
                                        <p class="mb-0">{{ $koperasi->bendahara ?? 'Belum diisi' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kontak -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="border-bottom pb-2 mb-3" style="color: #5a6c7d; font-weight: 600;">
                                    <i class="fas fa-address-book me-2"></i>INFORMASI KONTAK
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-phone me-2 text-primary"></i>No. Telepon
                                </label>
                                <p class="form-control-plaintext bg-light p-2 rounded">
                                    {{ $koperasi->no_telepon ?? '-' }}
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-envelope me-2 text-primary"></i>Email
                                </label>
                                <p class="form-control-plaintext bg-light p-2 rounded">
                                    {{ $koperasi->email ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- Data Keuangan -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="border-bottom pb-2 mb-3" style="color: #5a6c7d; font-weight: 600;">
                                    <i class="fas fa-chart-line me-2"></i>DATA KEUANGAN & KEANGGOTAAN
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-info">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title text-info">
                                                    <i class="fas fa-users me-2"></i>Jumlah Anggota
                                                </h6>
                                                <h4 class="mb-0">{{ number_format($koperasi->jumlah_anggota) }}</h4>
                                            </div>
                                            <i class="fas fa-users fa-2x text-info opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-success">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title text-success">
                                                    <i class="fas fa-piggy-bank me-2"></i>Modal Sendiri
                                                </h6>
                                                <h5 class="mb-0">{{ $koperasi->formatted_modal_sendiri }}</h5>
                                            </div>
                                            <i class="fas fa-piggy-bank fa-2x text-success opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-warning">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title text-warning">
                                                    <i class="fas fa-hand-holding-usd me-2"></i>Modal Luar
                                                </h6>
                                                <h5 class="mb-0">{{ $koperasi->formatted_modal_luar }}</h5>
                                            </div>
                                            <i class="fas fa-hand-holding-usd fa-2x text-warning opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title text-primary">
                                                    <i class="fas fa-chart-bar me-2"></i>Volume Usaha
                                                </h6>
                                                <h5 class="mb-0">{{ $koperasi->formatted_volume_usaha }}</h5>
                                            </div>
                                            <i class="fas fa-chart-bar fa-2x text-primary opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-danger">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title text-danger">
                                                    <i class="fas fa-coins me-2"></i>Total Modal
                                                </h6>
                                                <h5 class="mb-0">Rp {{ number_format($koperasi->total_modal, 0, ',', '.') }}</h5>
                                            </div>
                                            <i class="fas fa-coins fa-2x text-danger opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-dark">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title text-dark">
                                                    <i class="fas fa-trophy me-2"></i>SHU (Sisa Hasil Usaha)
                                                </h6>
                                                <h5 class="mb-0">{{ $koperasi->formatted_shu }}</h5>
                                            </div>
                                            <i class="fas fa-trophy fa-2x text-dark opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        @if($koperasi->keterangan)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="border-bottom pb-2 mb-3" style="color: #5a6c7d; font-weight: 600;">
                                    <i class="fas fa-sticky-note me-2"></i>KETERANGAN
                                </h6>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    {{ $koperasi->keterangan }}
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.koperasi.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                                </a>
                                <a href="{{ route('admin.koperasi.edit', $koperasi) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Edit Data
                                </a>
                                <form action="{{ route('admin.koperasi.destroy', $koperasi) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus koperasi {{ $koperasi->nama_koperasi }}?')">
                                        <i class="fas fa-trash me-2"></i>Hapus Data
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

.card .card {
    transition: transform 0.2s ease;
}

.card .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,.1);
}

.form-control-plaintext {
    border: 1px solid #e9ecef;
    min-height: 38px;
}

.opacity-50 {
    opacity: 0.5;
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.badge {
    font-size: 0.85rem;
}
</style>
@endsection
