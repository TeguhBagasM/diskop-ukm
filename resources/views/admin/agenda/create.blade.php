@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header Dashboard Style -->
            <div class="d-flex justify-content-center mb-4">
                <div class="dashboard-header">
                    <h3 class="mb-0">TAMBAH AGENDA KEGIATAN DINAS KOPERASI DAN UKM</h3>
                </div>
            </div>

            <div class="card">
                <div class="card-body" style="padding: 0;">
                    <!-- Header dengan style seperti dashboard -->
                    <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0" style="font-weight: 600; color: #5a6c7d;">
                                <i class="fas fa-plus-circle me-2"></i>FORM TAMBAH AGENDA
                            </h5>
                            <span class="badge bg-primary ms-2" style="border-radius: 15px;">Baru</span>
                        </div>
                        <div>
                            <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>
                    </div>

                    <div class="p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h6 class="alert-heading">
                                    <i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan input:
                                </h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.agenda.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <div class="row">
                                <!-- Jenis Kegiatan -->
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kegiatan" class="form-label fw-bold">
                                        <i class="fas fa-tags text-primary"></i> Jenis Kegiatan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('jenis_kegiatan') is-invalid @enderror"
                                            id="jenis_kegiatan"
                                            name="jenis_kegiatan"
                                            required>
                                        <option value="">Pilih Jenis Kegiatan</option>
                                        <option value="INTERNAL" {{ old('jenis_kegiatan') == 'INTERNAL' ? 'selected' : '' }}>
                                            INTERNAL
                                        </option>
                                        <option value="EKSTERNAL" {{ old('jenis_kegiatan') == 'EKSTERNAL' ? 'selected' : '' }}>
                                            EKSTERNAL
                                        </option>
                                    </select>
                                    @error('jenis_kegiatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sumber -->
                                <div class="col-md-6 mb-3">
                                    <label for="sumber" class="form-label fw-bold">
                                        <i class="fas fa-building text-info"></i> Sumber
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('sumber') is-invalid @enderror"
                                           id="sumber"
                                           name="sumber"
                                           value="{{ old('sumber') }}"
                                           placeholder="Masukkan sumber kegiatan"
                                           required>
                                    @error('sumber')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nama Kegiatan -->
                            <div class="mb-3">
                                <label for="nama_kegiatan" class="form-label fw-bold">
                                    <i class="fas fa-calendar-check text-success"></i> Nama Kegiatan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                       id="nama_kegiatan"
                                       name="nama_kegiatan"
                                       value="{{ old('nama_kegiatan') }}"
                                       placeholder="Masukkan nama kegiatan"
                                       required>
                                @error('nama_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <!-- Tempat -->
                                <div class="col-md-8 mb-3">
                                    <label for="tempat" class="form-label fw-bold">
                                        <i class="fas fa-map-marker-alt text-danger"></i> Tempat
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('tempat') is-invalid @enderror"
                                           id="tempat"
                                           name="tempat"
                                           value="{{ old('tempat') }}"
                                           placeholder="Masukkan lokasi tempat kegiatan"
                                           required>
                                    @error('tempat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Waktu -->
                                <div class="col-md-4 mb-3">
                                    <label for="waktu" class="form-label fw-bold">
                                        <i class="fas fa-clock text-dark"></i> Waktu
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="time"
                                           class="form-control @error('waktu') is-invalid @enderror"
                                           id="waktu"
                                           name="waktu"
                                           value="{{ old('waktu') }}"
                                           required>
                                    @error('waktu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Tanggal Kegiatan -->
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_kegiatan" class="form-label fw-bold">
                                        <i class="fas fa-calendar text-warning"></i> Tanggal Kegiatan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date"
                                           class="form-control @error('tanggal_kegiatan') is-invalid @enderror"
                                           id="tanggal_kegiatan"
                                           name="tanggal_kegiatan"
                                           value="{{ old('tanggal_kegiatan') }}"
                                           required>
                                    @error('tanggal_kegiatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Tindak Lanjut -->
                                <div class="col-md-6 mb-3">
                                    <label for="tindak_lanjut" class="form-label fw-bold">
                                        <i class="fas fa-tasks text-secondary"></i> Tindak Lanjut
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('tindak_lanjut') is-invalid @enderror"
                                            id="tindak_lanjut"
                                            name="tindak_lanjut"
                                            required>
                                        <option value="">Pilih Status</option>
                                        <option value="DIHADIRI KEPALA DINAS" {{ old('tindak_lanjut') == 'DIHADIRI KEPALA DINAS' ? 'selected' : '' }}>
                                            DIHADIRI KEPALA DINAS
                                        </option>
                                        <option value="DISPOSISI" {{ old('tindak_lanjut') == 'DISPOSISI' ? 'selected' : '' }}>
                                            DISPOSISI
                                        </option>
                                    </select>
                                    @error('tindak_lanjut')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Pegawai yang Ditugaskan -->
                            <div class="mb-3">
                                <label for="pegawai_yang_ditugaskan" class="form-label fw-bold">
                                    <i class="fas fa-user-tie text-primary"></i> Pegawai yang Ditugaskan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('pegawai_yang_ditugaskan') is-invalid @enderror"
                                       id="pegawai_yang_ditugaskan"
                                       name="pegawai_yang_ditugaskan"
                                       value="{{ old('pegawai_yang_ditugaskan') }}"
                                       placeholder="Masukkan nama pegawai yang bertugas"
                                       required>
                                @error('pegawai_yang_ditugaskan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="mb-4">
                                <label for="keterangan" class="form-label fw-bold">
                                    <i class="fas fa-comment text-muted"></i> Keterangan
                                    <small class="text-muted">(Opsional)</small>
                                </label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                          id="keterangan"
                                          name="keterangan"
                                          rows="4"
                                          placeholder="Masukkan keterangan tambahan jika diperlukan">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="text-muted small">
                                        <i class="fas fa-info-circle"></i>
                                        Field yang bertanda <span class="text-danger">*</span> wajib diisi
                                    </span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.agenda.index') }}" class="btn btn-light me-2">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="reset" class="btn btn-warning me-2">
                                        <i class="fas fa-undo"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan Agenda
                                    </button>
                                </div>
                            </div>
                        </form>
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

.form-label {
    margin-bottom: 0.5rem;
    color: #5a6c7d;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #5a6c7d;
    box-shadow: 0 0 0 0.2rem rgba(90, 108, 125, 0.25);
}

.btn {
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #5a6c7d;
    border-color: #5a6c7d;
}

.btn-primary:hover {
    background-color: #495761;
    border-color: #495761;
}

.invalid-feedback {
    font-size: 0.875rem;
}

.alert {
    border-radius: 10px;
    border: none;
}

.badge {
    font-size: 0.75rem;
}

.text-danger {
    color: #dc3545 !important;
}
</style>

<script>
// Bootstrap form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Reset form validation when reset button clicked
document.addEventListener('DOMContentLoaded', function() {
    const resetBtn = document.querySelector('button[type="reset"]');
    const form = document.querySelector('.needs-validation');

    if (resetBtn && form) {
        resetBtn.addEventListener('click', function() {
            form.classList.remove('was-validated');
        });
    }
});
</script>
@endsection
