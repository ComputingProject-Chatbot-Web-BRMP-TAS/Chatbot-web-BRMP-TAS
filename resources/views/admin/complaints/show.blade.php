@extends('layouts.admin')
@section('content')
<div class="container" style="max-width:800px;padding-top: 80px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-weight:700;margin-bottom:0;">Detail Komplain #{{ $complaint->complaint_id }}</h2>
        <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    
    <div class="card shadow" style="border-radius:20px;">
        <div class="card-body p-4">
            <div class="mb-4">
                <h5 class="text-primary mb-3">Informasi Pelanggan</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nama:</strong> {{ $complaint->user->name ?? '-' }}</p>
                        <p><strong>Email:</strong> {{ $complaint->user->email ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>No. Telepon:</strong> {{ $complaint->user->phone ?? '-' }}</p>
                        <p><strong>Tanggal Komplain:</strong> {{ $complaint->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <h5 class="text-primary mb-3">Transaksi</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Tipe Komplain:</strong> {{ $complaint->complaint_types ?? '-' }}</p>
                        <p><strong>Transaction ID:</strong> {{ $complaint->transaction_id ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Produk & Quantity:</strong>
                        @php
                            $transaction = \App\Models\Transaction::with('transactionItems.product')->find($complaint->transaction_id);
                        @endphp
                        @if($transaction && $transaction->transactionItems->count())
                            <ul class="mb-0">
                                @foreach($transaction->transactionItems as $item)
                                    <li>
                                        {{ $item->product->product_name ?? 'Produk #' . $item->product_id }} - {{ number_format($item->quantity, 2) }} Kg
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">Tidak ada data produk</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="text-primary mb-3">Deskripsi Komplain</h5>
                <div class="p-3 bg-light rounded">
                    {{ $complaint->description }}
                </div>
            </div>
            
            @if($complaint->photo_proof)
            <div class="mb-4">
                <h5 class="text-primary mb-3">Bukti Gambar</h5>
                <img src="{{ asset('storage/'.$complaint->photo_proof) }}" alt="Bukti Komplain" style="max-width:100%;max-height:400px;border-radius:14px;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
            </div>
            @endif
            
            @if($complaint->user && $complaint->user->phone)
            <div class="text-center mt-4">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$complaint->user->phone) }}?text=Halo {{ $complaint->user->name }}, kami telah menerima komplain Anda. Tim kami akan segera menghubungi Anda untuk menangani masalah ini. Terima kasih telah menghubungi kami." target="_blank" class="btn btn-success btn-lg">
                    <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 