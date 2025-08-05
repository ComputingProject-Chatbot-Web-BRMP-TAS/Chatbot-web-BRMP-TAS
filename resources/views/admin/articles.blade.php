@extends('layouts.admin')

@section('content')
<div style="padding-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Kelola Artikel</h2>
                
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Artikel</h5>
                        <button class="btn btn-primary" onclick="window.location.href='{{ route('admin.articles.create') }}'">Tambah Artikel</button>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Fitur kelola artikel sedang dalam pengembangan. Untuk sementara, Anda dapat mengelola artikel melalui panel admin.
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($articles as $index => $article)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $article->headline }}</td>
                                            <td>-</td> <!-- Jika belum ada kategori, tampilkan '-' -->
                                            <td>-</td> <!-- Jika belum ada status, tampilkan '-' -->
                                            <td>{{ $article->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <!-- Tambahkan tombol edit/hapus jika perlu -->
                                                <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus artikel?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada artikel</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection