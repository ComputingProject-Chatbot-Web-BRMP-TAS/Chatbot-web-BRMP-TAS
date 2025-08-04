@extends('layouts.admin')
@section('content')
<div class="container" style="padding-top: 80px;max-width:1200px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-weight:700;margin-bottom:0;">Dashboard Komplain</h2>
        <a href="{{ route('admin.complaints.index') }}" class="btn btn-primary">
            <i class="fas fa-list"></i> Lihat Semua Komplain
        </a>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3 class="card-title">{{ $totalComplaints }}</h3>
                    <p class="card-text">Total Komplain</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3 class="card-title">{{ $recentComplaints->count() }}</h3>
                    <p class="card-text">Komplain Terbaru</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Complaints -->
    <div class="card shadow" style="border-radius:16px;">
        <div class="card-header bg-white">
            <h5 class="mb-0">Komplain Terbaru</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($recentComplaints as $complaint)
                        <tr>
                            <td>{{ $complaint->complaint_id }}</td>
                            <td>{{ $complaint->user->name ?? '-' }}</td>
                            <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $complaint->description }}</td>
                            <td>{{ $complaint->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.complaints.show', $complaint->complaint_id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
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