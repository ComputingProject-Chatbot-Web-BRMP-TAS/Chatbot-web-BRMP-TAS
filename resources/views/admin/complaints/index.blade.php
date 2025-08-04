@extends('layouts.admin')
@section('content')
<div class="container" style="padding-top: 80px;max-width:1200px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-weight:700;margin-bottom:0;">Kelola Komplain</h2>
        <div>
            <a href="{{ route('admin.complaints.dashboard') }}" class="btn btn-info me-2">
                <i class="fas fa-chart-bar"></i> Dashboard
            </a>
            <span class="badge bg-primary">Total: {{ $complaints->count() }}</span>
        </div>
    </div>
    
    <div class="card shadow" style="border-radius:16px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle" style="background:#fff;border-radius:12px;overflow:hidden;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>No. Telepon</th>
                            <th>Deskripsi</th>
                            <th>Bukti Gambar</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($complaints as $complaint)
                        <tr>
                            <td>{{ $complaint->complaint_id }}</td>
                            <td>{{ $complaint->user->name ?? '-' }}</td>
                            <td>{{ $complaint->user->phone ?? '-' }}</td>
                            <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $complaint->description }}</td>
                            <td>
                                @if($complaint->photo_proof)
                                    <img src="{{ asset('storage/'.$complaint->photo_proof) }}" alt="Bukti" style="width:48px;height:48px;object-fit:cover;border-radius:8px;" data-bs-toggle="modal" data-bs-target="#imageModal{{ $complaint->complaint_id }}">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $complaint->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.complaints.show', $complaint->complaint_id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        
                        <!-- Image Modal -->
                        @if($complaint->photo_proof)
                        <div class="modal fade" id="imageModal{{ $complaint->complaint_id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Bukti Komplain #{{ $complaint->complaint_id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/'.$complaint->photo_proof) }}" alt="Bukti Komplain" style="max-width:100%;max-height:500px;border-radius:8px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>Tidak ada komplain yang ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 