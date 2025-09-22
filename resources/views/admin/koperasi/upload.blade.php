@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Header Dashboard Style -->
            <div class="d-flex justify-content-center mb-4">
                <div class="dashboard-header">
                    <h3 class="mb-0">DATA KOPERASI KAB. BANDUNG</h3>
                </div>
            </div>

            <div class="card">
                <div class="card-body" style="padding: 0;">
                    <!-- Header dengan style seperti dashboard -->
                    <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0" style="font-weight: 600; color: #5a6c7d;">UPLOAD FILE EXCEL KOPERASI</h5>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.koperasi.download-template') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-download"></i> Template Excel
                            </a>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                <i class="fas fa-upload"></i> Upload File
                            </button>
                        </div>
                    </div>

                    <div class="p-3">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Search -->
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="search" class="form-label">Search:</label>
                                <input type="text" class="form-control form-control-sm" id="search" placeholder="Cari nama file...">
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-primary btn-sm mt-4" onclick="location.reload()">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #e8f4fd;">
                                    <tr>
                                        <th class="text-center" style="width: 50px; font-weight: 600; color: #1976d2;">NO</th>
                                        <th class="text-center" style="width: 200px; font-weight: 600; color: #1976d2;">NAMA FILE</th>
                                        <th class="text-center" style="width: 100px; font-weight: 600; color: #1976d2;">BULAN</th>
                                        <th class="text-center" style="width: 80px; font-weight: 600; color: #1976d2;">TAHUN</th>
                                        <th class="text-center" style="width: 120px; font-weight: 600; color: #1976d2;">STATUS</th>
                                        <th class="text-center" style="width: 100px; font-weight: 600; color: #1976d2;">TOTAL RECORD</th>
                                        <th class="text-center" style="width: 120px; font-weight: 600; color: #1976d2;">TANGGAL UPLOAD</th>
                                        <th class="text-center" style="width: 120px; font-weight: 600; color: #1976d2;">TINDAH LANJUT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($files as $index => $file)
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span class="badge bg-light text-dark" style="border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                                {{ $files->firstItem() + $loop->index }}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    <i class="fas fa-file-excel" style="color: #28a745; font-size: 1.2rem;"></i>
                                                </div>
                                                <div>
                                                    <span style="font-weight: 600; font-size: 0.9rem;">{{ Str::limit($file->original_name, 30) }}</span>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-hdd me-1"></i>
                                                        {{ $file->readable_file_size }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span class="badge bg-info" style="border-radius: 12px;">
                                                {{ $file->bulan_indonesia }}
                                            </span>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span style="font-weight: 600;">{{ $file->tahun }}</span>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            @php
                                                $statusClass = match($file->status) {
                                                    'COMPLETED' => 'bg-success',
                                                    'PROCESSING' => 'bg-warning text-dark',
                                                    'PENDING' => 'bg-info',
                                                    'FAILED' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}" style="border-radius: 12px;">
                                                {{ $file->status }}
                                            </span>
                                            @if($file->status == 'PROCESSING')
                                                <br>
                                                <small class="text-muted mt-1">{{ $file->progress_percentage }}%</small>
                                            @endif
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span style="font-weight: 600;">{{ number_format($file->processed_records) }}</span>
                                            @if($file->total_records > 0)
                                                <small class="text-muted d-block">/ {{ number_format($file->total_records) }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; font-size: 0.85rem;">
                                            {{ $file->uploaded_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <div class="btn-group" role="group">
                                                @if($file->status == 'COMPLETED')
                                                    <button class="btn btn-success btn-sm" title="Completed" disabled>
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                                @if($file->status == 'FAILED' && $file->error_log)
                                                    <button class="btn btn-warning btn-sm" title="View Error"
                                                            onclick="showError('{{ addslashes($file->error_log) }}')">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </button>
                                                @endif
                                                @if(file_exists(public_path($file->file_path)))
                                                    <a href="{{ asset($file->file_path) }}" class="btn btn-info btn-sm"
                                                       title="Download" download>
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                                <button class="btn btn-danger btn-sm" title="Delete"
                                                        onclick="deleteFile({{ $file->id }}, '{{ $file->original_name }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-file-excel fa-3x text-muted mb-3"></i>
                                                <h6 class="text-muted">Belum ada file yang diupload</h6>
                                                <small class="text-muted">Silakan upload file Excel untuk memproses data koperasi</small>
                                                <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                                    <i class="fas fa-upload"></i> Upload File Pertama
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination dan Info -->
                        @if(method_exists($files, 'links'))
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $files->firstItem() ?? 0 }} - {{ $files->lastItem() ?? 0 }}
                                dari {{ $files->total() }} file
                            </div>
                            <div>
                                {{ $files->links() }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.koperasi.upload.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload File Excel Koperasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File Excel</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls" required>
                        <div class="form-text">Format yang didukung: .xlsx, .xls (Maksimal 10MB)</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select class="form-select" id="bulan" name="bulan" required>
                                <option value="">Pilih Bulan</option>
                                <option value="Jan" {{ date('M') == 'Jan' ? 'selected' : '' }}>Januari</option>
                                <option value="Feb" {{ date('M') == 'Feb' ? 'selected' : '' }}>Februari</option>
                                <option value="Mar" {{ date('M') == 'Mar' ? 'selected' : '' }}>Maret</option>
                                <option value="Apr" {{ date('M') == 'Apr' ? 'selected' : '' }}>April</option>
                                <option value="May" {{ date('M') == 'May' ? 'selected' : '' }}>Mei</option>
                                <option value="Jun" {{ date('M') == 'Jun' ? 'selected' : '' }}>Juni</option>
                                <option value="Jul" {{ date('M') == 'Jul' ? 'selected' : '' }}>Juli</option>
                                <option value="Aug" {{ date('M') == 'Aug' ? 'selected' : '' }}>Agustus</option>
                                <option value="Sep" {{ date('M') == 'Sep' ? 'selected' : '' }}>September</option>
                                <option value="Oct" {{ date('M') == 'Oct' ? 'selected' : '' }}>Oktober</option>
                                <option value="Nov" {{ date('M') == 'Nov' ? 'selected' : '' }}>November</option>
                                <option value="Dec" {{ date('M') == 'Dec' ? 'selected' : '' }}>Desember</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select class="form-select" id="tahun" name="tahun" required>
                                <option value="">Pilih Tahun</option>
                                @for($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Catatan:</strong> Pastikan format file Excel sesuai dengan template yang telah disediakan.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload File
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <pre id="errorContent" class="bg-light p-3" style="white-space: pre-wrap; word-wrap: break-word;"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
function showError(errorLog) {
    document.getElementById('errorContent').textContent = errorLog;
    new bootstrap.Modal(document.getElementById('errorModal')).show();
}

function deleteFile(fileId, fileName) {
    if (confirm(`Yakin ingin menghapus file "${fileName}"?`)) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/koperasi/upload/${fileId}`;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Search functionality
document.getElementById('search').addEventListener('keyup', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const tableRows = document.querySelectorAll('tbody tr');

    tableRows.forEach(row => {
        const fileName = row.querySelector('td:nth-child(2)');
        if (fileName) {
            const text = fileName.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});
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
