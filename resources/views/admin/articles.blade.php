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
                        <button class="btn btn-primary">Tambah Artikel</button>
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
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada artikel</td>
                                    </tr>
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