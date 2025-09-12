@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header Dashboard Style -->
            <div class="d-flex justify-content-center mb-4">
                <div class="dashboard-header">
                    <h3 class="mb-0">EDIT AGENDA KEGIATAN DINAS KOPERASI DAN UKM</h3>
                </div>
            </div>

            <div class="card">
                <div class="card-body" style="padding: 0;">
                    <!-- Header dengan style seperti dashboard -->
                    <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0" style="font-weight: 600; color: #5a6c7d;">
                                <i class="fas fa-edit me-2"></i>FORM EDIT AGENDA
                            </h5>
                            <span class="badge bg-{{ $agenda->jenis_kegiatan == 'INTERNAL' ? 'success' : 'warning' }} ms-2" style="border-radius: 15px;">
                                {{ $agenda->jenis_kegiatan }}
                            </span>
                        </div>
                        <div>
                            <a href="{{ route('admin.agenda.show', $agenda) }}" class="btn btn-info btn-sm me-1">
                                <i class="fas fa-eye"></i> Detail
                            </a>
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

                        <!-- Info Card untuk data yang sedang diedit -->
                        <div class="alert alert-info" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle fa-2x me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">Sedang mengedit agenda:</h6>
                                    <strong>{{ $agenda->nama_kegiatan }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $agenda->tanggal_kegiatan ? $agenda->tanggal_kegiatan->format('d/m/Y') : '-' }}
                                        <i class="fas fa-clock ms-2 me-1"></i>
                                        {{ $agenda->waktu ? date('H:i', strtotime($agenda->waktu)) : '-' }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.agenda.update', $agenda) }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

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
                                        <option value="INTERNAL" {{ (old('jenis_kegiatan', $agenda->jenis_kegiatan) == 'INTERNAL') ? 'selected' : '' }}>
                                            INTERNAL
                                        </option>
                                        <option value="EKSTERNAL" {{ (old('jenis_kegiatan', $agenda->jenis_kegiatan) == 'EKSTERNAL') ? 'selected' : '' }}>
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
                                           value="{{ old('sumber', $agenda->sumber) }}"
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
                                       value="{{ old('nama_kegiatan', $agenda->nama_kegiatan) }}"
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
                                           value="{{ old('tempat', $agenda->tempat) }}"
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
                                           value="{{ old('waktu', $agenda->waktu ? date('H:i', strtotime($agenda->waktu)) : '') }}"
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
                                           value="{{ old('tanggal_kegiatan', $agenda->tanggal_kegiatan ? $agenda->tanggal_kegiatan->format('Y-m-d') : '') }}"
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
                                        <option value="DIHADIRI" {{ (old('tindak_lanjut', $agenda->tindak_lanjut) == 'DIHADIRI') ? 'selected' : '' }}>DIHADIRI</option>
                                        <option value="DISPOSISI" {{ (old('tindak_lanjut', $agenda->tindak_lanjut) == 'DISPOSISI') ? 'selected' : '' }}>DISPOSISI</option>
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
                                       value="{{ old('pegawai_yang_ditugaskan', $agenda->pegawai_yang_ditugaskan) }}"
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
                                          placeholder="Masukkan keterangan tambahan jika diperlukan">{{ old('keterangan', $agenda->keterangan) }}</textarea>
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
                                    <button type="button" class="btn btn-warning me-2" onclick="resetToOriginal()">
                                        <i class="fas fa-undo"></i> Reset ke Asli
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Agenda
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- History/Change Log Card (Optional - if you want to show what changed) -->
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-history text-muted"></i> Informasi Agenda
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Dibuat:</strong>
                                {{ $agenda->created_at ? $agenda->created_at->format('d/m/Y H:i') : '-' }}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Terakhir diupdate:</strong>
                                {{ $agenda->updated_at ? $agenda->updated_at->format('d/m/Y H:i') : '-' }}
                            </small>
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

/* Highlight changes */
.form-control.changed, .form-select.changed {
    border-left: 4px solid #28a745;
    background-color: #f8fff8;
}
</style>

<script>
// Store original values for comparison
const originalValues = {
    jenis_kegiatan: '{{ $agenda->jenis_kegiatan }}',
    nama_kegiatan: '{{ $agenda->nama_kegiatan }}',
    sumber: '{{ $agenda->sumber }}',
    tempat: '{{ $agenda->tempat }}',
    waktu: '{{ $agenda->waktu ? date('H:i', strtotime($agenda->waktu)) : '' }}',
    tanggal_kegiatan: '{{ $agenda->tanggal_kegiatan ? $agenda->tanggal_kegiatan->format('Y-m-d') : '' }}',
    pegawai_yang_ditugaskan: '{{ $agenda->pegawai_yang_ditugaskan }}',
    tindak_lanjut: '{{ $agenda->tindak_lanjut }}',
    keterangan: `{{ $agenda->keterangan }}`
};

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

// Reset to original values
function resetToOriginal() {
    if (confirm('Apakah Anda yakin ingin mengembalikan semua field ke nilai asli?')) {
        document.getElementById('jenis_kegiatan').value = originalValues.jenis_kegiatan;
        document.getElementById('nama_kegiatan').value = originalValues.nama_kegiatan;
        document.getElementById('sumber').value = originalValues.sumber;
        document.getElementById('tempat').value = originalValues.tempat;
        document.getElementById('waktu').value = originalValues.waktu;
        document.getElementById('tanggal_kegiatan').value = originalValues.tanggal_kegiatan;
        document.getElementById('pegawai_yang_ditugaskan').value = originalValues.pegawai_yang_ditugaskan;
        document.getElementById('tindak_lanjut').value = originalValues.tindak_lanjut;
        document.getElementById('keterangan').value = originalValues.keterangan;

        // Remove validation classes
        document.querySelector('.needs-validation').classList.remove('was-validated');

        // Remove change highlights
        document.querySelectorAll('.changed').forEach(el => el.classList.remove('changed'));
    }
}

// Highlight changes as user types
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.needs-validation');
    const inputs = form.querySelectorAll('input, select, textarea');

    inputs.forEach(input => {
        input.addEventListener('input', function() {
            const fieldName = this.name;
            const currentValue = this.value;
            const originalValue = originalValues[fieldName] || '';

            if (currentValue !== originalValue) {
                this.classList.add('changed');
            } else {
                this.classList.remove('changed');
            }
        });
    });
});
</script>
@endsection
