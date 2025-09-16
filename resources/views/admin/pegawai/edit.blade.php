@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header Dashboard Style -->
            <div class="d-flex justify-content-center mb-4">
                <div class="dashboard-header">
                    <h3 class="mb-0">EDIT DATA PEGAWAI</h3>
                </div>
            </div>

            <div class="card">
                <div class="card-body" style="padding: 0;">
                    <!-- Header dengan style seperti dashboard -->
                    <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0" style="font-weight: 600; color: #5a6c7d;">
                                <i class="fas fa-user-edit me-2"></i>FORM EDIT PEGAWAI
                            </h5>
                            <span class="badge bg-warning ms-2" style="border-radius: 15px;">{{ $pegawai->nama }}</span>
                        </div>
                        <div>
                            <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h6><i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan:</h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.pegawai.update', $pegawai) }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <!-- Data Pribadi Section -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="section-title">
                                        <i class="fas fa-user text-primary"></i>
                                        Data Pribadi
                                    </h6>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                   id="nama" name="nama" value="{{ old('nama', $pegawai->nama) }}"
                                                   placeholder="Masukkan nama lengkap" required>
                                        </div>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                                    id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="L" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                   id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}" required>
                                        </div>
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="no_telp" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" class="form-control @error('no_telp') is-invalid @enderror"
                                                   id="no_telp" name="no_telp" value="{{ old('no_telp', $pegawai->no_telp) }}"
                                                   placeholder="Contoh: 08123456789" required>
                                        </div>
                                        @error('no_telp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Data Kepegawaian Section -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="section-title">
                                        <i class="fas fa-id-card text-success"></i>
                                        Data Kepegawaian
                                    </h6>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                            <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                                   id="nip" name="nip" value="{{ old('nip', $pegawai->nip) }}"
                                                   placeholder="Masukkan NIP" required>
                                        </div>
                                        @error('nip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status Kepegawaian <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                            <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status" name="status" required>
                                                <option value="">Pilih Status</option>
                                                <option value="AKTIF" {{ old('status', $pegawai->status) == 'AKTIF' ? 'selected' : '' }}>Aktif</option>
                                                <option value="CUTI" {{ old('status', $pegawai->status) == 'CUTI' ? 'selected' : '' }}>Cuti</option>
                                                <option value="NON-AKTIF" {{ old('status', $pegawai->status) == 'NON-AKTIF' ? 'selected' : '' }}>Non-Aktif</option>
                                            </select>
                                        </div>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="pendidikan" class="form-label">Pendidikan <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                            <select class="form-select @error('pendidikan') is-invalid @enderror"
                                                    id="pendidikan" name="pendidikan" required>
                                                <option value="">Pilih Pendidikan</option>
                                                <option value="SD" {{ old('pendidikan', $pegawai->pendidikan) == 'SD' ? 'selected' : '' }}>SD</option>
                                                <option value="SMP" {{ old('pendidikan', $pegawai->pendidikan) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                                <option value="SMA" {{ old('pendidikan', $pegawai->pendidikan) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                                <option value="SMK" {{ old('pendidikan', $pegawai->pendidikan) == 'SMK' ? 'selected' : '' }}>SMK</option>
                                                <option value="D1" {{ old('pendidikan', $pegawai->pendidikan) == 'D1' ? 'selected' : '' }}>D1</option>
                                                <option value="D2" {{ old('pendidikan', $pegawai->pendidikan) == 'D2' ? 'selected' : '' }}>D2</option>
                                                <option value="D3" {{ old('pendidikan', $pegawai->pendidikan) == 'D3' ? 'selected' : '' }}>D3</option>
                                                <option value="D4" {{ old('pendidikan', $pegawai->pendidikan) == 'D4' ? 'selected' : '' }}>D4</option>
                                                <option value="S1" {{ old('pendidikan', $pegawai->pendidikan) == 'S1' ? 'selected' : '' }}>S1</option>
                                                <option value="S2" {{ old('pendidikan', $pegawai->pendidikan) == 'S2' ? 'selected' : '' }}>S2</option>
                                                <option value="S3" {{ old('pendidikan', $pegawai->pendidikan) == 'S3' ? 'selected' : '' }}>S3</option>
                                            </select>
                                        </div>
                                        @error('pendidikan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                                   id="jabatan" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}"
                                                   placeholder="Contoh: Staff Admin" required>
                                        </div>
                                        @error('jabatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="bidang" class="form-label">Bidang <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            <input type="text" class="form-control @error('bidang') is-invalid @enderror"
                                                   id="bidang" name="bidang" value="{{ old('bidang', $pegawai->bidang) }}"
                                                   placeholder="Contoh: Bidang Koperasi" required>
                                        </div>
                                        @error('bidang')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update Data Pegawai
                                </button>
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

.form-section {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    background-color: #f8f9fa;
}

.section-header {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 8px;
}

.section-title {
    color: #495057;
    font-weight: 600;
    margin: 0;
}

.input-group-text {
    background-color: #e9ecef;
    border-color: #ced4da;
    color: #495057;
    font-weight: 500;
}

.form-control:focus, .form-select:focus {
    border-color: #5a6c7d;
    box-shadow: 0 0 0 0.2rem rgba(90, 108, 125, 0.25);
}

.btn-warning {
    background-color: #f0ad4e;
    border-color: #eea236;
}

.btn-warning:hover {
    background-color: #ec971f;
    border-color: #d58512;
}

.invalid-feedback {
    display: block;
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
</script>
@endsection
