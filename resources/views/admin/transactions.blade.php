@extends('layouts.admin')

@section('content')
<div style="padding-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Kelola Transaksi</h2>
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Daftar Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Transaksi</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $index => $transaction)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $transaction->id }}</td>
                                        <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                                        <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if($transaction->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($transaction->status == 'paid')
                                                <span class="badge bg-success">Dibayar</span>
                                            @elseif($transaction->status == 'shipped')
                                                <span class="badge bg-info">Dikirim</span>
                                            @elseif($transaction->status == 'delivered')
                                                <span class="badge bg-success">Diterima</span>
                                            @elseif($transaction->status == 'cancelled')
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $transaction->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info">Detail</button>
                                            <button class="btn btn-sm btn-warning">Edit</button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada transaksi</td>
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