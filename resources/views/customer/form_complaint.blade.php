@extends('layouts.app')
@section('content')
<style>
    .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        width: 100%;
        max-width: 700px;
        margin: auto;
        position: relative;
        left: unset;
    }

    .pilih-transaksi-box {
        background: #fff;
        border: 1px solid #e0e0e0;
        min-height: 56px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
    }

    .pilih-transaksi-box.selected {
        background: #eafff0;
        border-color: #16a34a;
    }

    .btn-pilih-transaksi {
        background: #38b449;
        color: #fff;
        font-weight: 600;
        border-radius: 12px;
        padding: 8px 22px;
        font-size: 18px;
        box-shadow: 0 2px 8px rgba(56,180,73,0.10);
        border: none;
        transition: none;
    }
    .btn-pilih-transaksi:hover,
    .btn-pilih-transaksi:active,
    .btn-pilih-transaksi:focus {
        background: #38b449 !important;
        color: #fff !important;
        box-shadow: 0 2px 8px rgba(56,180,73,0.10);
    }
</style>
<div class="container py-4" style="margin-top: 10vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card mb-4" style="border-radius: 16px;">
        <div class="card-body">
            <h5 class="fw-bold mb-3" style="color:#388e3c;">
                <i class="fas fa-file-contract me-2"></i>
                Syarat & Ketentuan Pengaduan Ketidaksesuaian Mutu Benih
            </h5>
            <ol style="font-size:16px;">
                <li>Sertakan informasi yang jelas antara lain nomor kantong dan foto yang mendukung dan menjelaskan ketidaksesuaian barang tersebut.</li>
                <li>Mengirimkan contoh benih yang tidak sesuai minimal 1.000 biji setiap unit kantong kemasan untuk diuji di laboratorium benih BRMP Tanaman Pemanis dan Serat. Untuk keperluan verifikasi disarankan kepada pelanggan untuk menyisakan benih minimal sebanyak 1.000 biji setiap unit kantong kemasan sebelum digunakan.</li>
                <li>Jika ketidaksesuaian tersebut disebabkan oleh pihak UPBS BRMP Tanaman Pemanis dan Serat, maka akan dilakukan penggantian benih sesuai komoditas, varietas dan kelas benih. Jika persediaan varietas dan kelas benih yang dibeli telah habis, maka akan ditawarkan dengan varietas lain yang tersedia.</li>
                <li>Benih yang sudah digunakan, rusak, hilang, atau dikembalikan yang tidak sesuai, TIDAK DAPAT DIGANTI UANG karena sudah masuk ke kas negara.</li>
                <li>Seluruh permasalahan yang timbul akibat proses pengiriman dan lain-lain, tidak menjadi tanggung jawab kami.</li>
                <li>Kami berhak menolak pengaduan jika ketentuan di atas tidak dipenuhi oleh pelanggan.</li>
            </ol>
        </div>
    </div>
    
    <div class="card shadow" style="border-radius: 20px;">
        <div class="card-body p-4">
            <h2 class="text-center mb-4" style="color: #388e3c; font-weight: 700;">
                Form Komplain
            </h2>
            
            @guest
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Anda harus <a href='{{ route('login') }}' class="alert-link">login</a> untuk mengirim komplain.
                </div>
            @else
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Mohon perbaiki kesalahan berikut:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('complaint.store') }}" enctype="multipart/form-data">
                    @csrf
                        
                    <div class="mb-2">
                        <label class="form-label fw-bold">
                            <i class="fas fa-receipt me-1"></i>Pilih Transaksi <span class="text-danger">*</span>
                        </label>
                        <div class="pilih-transaksi-box d-flex align-items-center px-3 py-2 mb-2" style="border-radius:12px;">
                            <div class="flex-grow-1">
                                <!-- Default (belum dipilih) -->
                                <span id="transactionInfoDefault" class="text-muted" style="font-size:18px;">
                                    Belum ada transaksi yang terpilih...
                                </span>
                                <!-- Detail transaksi (setelah dipilih) -->
                                <div id="transactionInfoDetail" style="display:none;">
                                    <!-- Akan diisi JS -->
                                </div>
                                <input type="hidden" name="transaction_id" id="transactionId" required>
                            </div>
                            <button type="button" class="btn btn-pilih-transaksi ms-3" id="btnPilihTransaksi" data-bs-toggle="modal" data-bs-target="#finishedTransactionsModal">
                                Pilih Transaksi
                            </button>
                        </div>
                        @error('transaction_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" style="margin-top:-8px;">
                        <span class="text-muted" style="font-size: 15px;">
                            <i class="fas fa-info-circle me-1"></i>
                            Transaksi yang dapat diajukan adalah transaksi selesai yang kurang dari 30 hari
                        </span>
                    </div>

                    <!-- Modal Daftar Transaksi Selesai -->
                    <div class="modal fade" id="finishedTransactionsModal" tabindex="-1" aria-labelledby="finishedTransactionsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="finishedTransactionsModalLabel">Daftar Transaksi Selesai</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                            <th>Produk</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($finishedTransactions as $transaction)
                                            @php
                                                $canComplain = $transaction->done_date && \Carbon\Carbon::parse($transaction->done_date)->diffInDays(now()) < 30;
                                                $daysLeft = $transaction->done_date ? 30 - \Carbon\Carbon::parse($transaction->done_date)->diffInDays(now()) : null;
                                            @endphp
                                            <tr @if(!$canComplain) style="background-color: #f1f1f1; color: #888;" @endif>
                                                <td>
                                                    @if($transaction->transactionItems && count($transaction->transactionItems))
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach($transaction->transactionItems as $item)
                                                                @if($item->product)
                                                                    <li>
                                                                        {{ $item->product->product_name }} {{ number_format($item->quantity, 2) }} Kg
                                                                    </li>
                                                                @else
                                                                    <li>Produk #{{ $item->product_id }} ({{ number_format($item->quantity, 2) }} Kg)</li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                                <td>Rp{{ number_format($transaction->total_price,0,',','.') }}</td>
                                                <td>
                                                    @if($canComplain)
                                                        @php
                                                            $itemsArray = [];
                                                            foreach ($transaction->transactionItems as $item) {
                                                                $itemsArray[] = [
                                                                    "nama" => $item->product->product_name ?? '-',
                                                                    "harga" => "Rp" . number_format($item->product->price_per_unit ?? 0, 0, ',', '.') . ' / ' . ($item->product->unit ?? 'Kg'),
                                                                    "qty" => number_format($item->quantity, 2),
                                                                    "subtotal" => "Rp" . number_format($item->quantity * ($item->product->price_per_unit ?? 0), 0, ',', '.'),
                                                                    "img" => asset('storage/products/' . ($item->product->image1 ?? 'default.png')),
                                                                    "unit" => $item->product->unit ?? 'Kg'
                                                                ];
                                                            }
                                                        @endphp
                                                        <button type="button" class="btn btn-success btn-sm pilih-transaksi-btn"
                                                            data-id="{{ $transaction->transaction_id }}"
                                                            data-products='@json($itemsArray)'
                                                            data-tanggal="{{ $transaction->created_at->format('d M Y') }}"
                                                            data-total="Rp{{ number_format($transaction->total_price,0,',','.') }}"
                                                        >
                                                            Pilih
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                            Pilih
                                                        </button>
                                                        <div class="text-muted small mt-1">
                                                            Sudah lewat 30 hari, tidak bisa komplain<br>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                             </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-hashtag me-1"></i>Nomor Kantong <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="nomor_kantong" 
                            class="form-control @error('nomor_kantong') is-invalid @enderror" 
                            placeholder="Masukkan nomor kantong"
                            required
                        >
                        @error('nomor_kantong')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-list me-1"></i>Pilih Jenis Komplain <span class="text-danger">*</span>
                        </label>
                        <div>
                            @php
                                $complaintTypes = [
                                    'Produk tidak sesuai',
                                    'Produk rusak',
                                    'Jumlah kurang',
                                    'Paket terlambat',
                                    'Paket rusak/hilang',
                                    'Masalah pembayaran',
                                    'Lainnya'
                                ];
                            @endphp
                            @foreach($complaintTypes as $type)
                                <div class="form-check mb-2">
                                    <input 
                                        class="form-check-input @error('complaint_types') is-invalid @enderror" 
                                        type="radio" 
                                        name="complaint_types" 
                                        id="complaint_types_{{ $loop->index }}" 
                                        value="{{ $type }}"
                                        {{ old('complaint_types') == $type ? 'checked' : '' }}
                                        required
                                    >
                                    <label class="form-check-label" for="complaint_types_{{ $loop->index }}">
                                        {{ $type }}
                                    </label>
                                </div>
                            @endforeach
                            @error('complaint_types')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-edit me-1"></i>Deskripsi Komplain
                        </label>
                        <textarea 
                            name="description" 
                            class="form-control @error('description') is-invalid @enderror" 
                            rows="5" 
                            placeholder="Jelaskan detail masalah atau keluhan Anda..."
                            required
                        >{{ old('description') }}</textarea>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Maksimal 1000 karakter. Jelaskan dengan detail agar kami dapat membantu dengan lebih baik.
                        </div>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-image me-1"></i>Upload Gambar Bukti <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="file" 
                            name="photo_proof" 
                            class="form-control @error('photo_proof') is-invalid @enderror" 
                            accept="image/*" 
                            required
                        >
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Format: JPG, JPEG, PNG. Maksimal 10MB. Bukti foto akan membantu kami memahami masalah dengan lebih baik.
                        </div>
                        @error('photo_proof')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Checkbox Syarat & Ketentuan -->
                    <div class="mb-4">
                        <input type="checkbox" id="termsCheckbox" style="cursor:pointer;">
                        <label for="termsCheckbox" style="cursor:pointer;">
                            Saya telah membaca dan menyetujui <span style="color:#388e3c;text-decoration:underline;">Syarat & Ketentuan Pengaduan</span>
                        </label>
                    </div>
                    
                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-success w-100 py-3" style="font-weight: 600;" id="submitBtn" disabled>
                        <i class="fas fa-paper-plane me-2"></i>Kirim Komplain
                    </button>
                </form>
            @endguest
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.pilih-transaksi-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var products = JSON.parse(this.getAttribute('data-products'));
            var tanggal = this.getAttribute('data-tanggal');
            var total = this.getAttribute('data-total');

            document.getElementById('transactionId').value = id;

            // Hide default info & tombol pilih
            document.getElementById('transactionInfoDefault').style.display = 'none';
            document.getElementById('btnPilihTransaksi').style.display = 'none';

            // Show detail transaksi
            var detail = document.getElementById('transactionInfoDetail');
            detail.style.display = 'block';

            // Render semua produk
            var produkHtml = products.map(function(item) {
                return `
                    <div class="d-flex align-items-center mb-4" style="gap:16px;">
                        <img src="${item.img}" alt="${item.nama}" style="width:80px;height:80px;object-fit:cover;border-radius:12px;">
                        <div>
                            <div style="font-weight:700;font-size:20px;">${item.nama}</div>
                            <div style="color:#38b449;font-weight:600;font-size:18px;">${item.harga}</div>
                        </div>
                        <div class="ms-auto text-end">
                            <div style="font-weight:700;font-size:20px;">${item.qty} ${item.unit}</div>
                            <div style="color:#888;font-size:16px;">Subtotal: <span style="color:#38b449;font-weight:700;">${item.subtotal}</span></div>
                        </div>
                    </div>
                `;
            }).join('');

            detail.innerHTML = `
                ${produkHtml}
                <div class="d-flex justify-content-between align-items-end" style="font-weight:600;font-size:18px;margin-top:10px;">
                    <span class="mt-3" style="font-weight:700;">Tanggal Transaksi: ${tanggal}</span>
                    <button type="button" class="btn btn-pilih-transaksi mt-3" id="btnUbahTransaksi" data-bs-toggle="modal" data-bs-target="#finishedTransactionsModal">
                        Ubah Transaksi
                    </button>
                </div>
            `;

            var box = document.querySelector('.pilih-transaksi-box');
            box.classList.add('selected');

            // Modal hide
            var modalEl = document.getElementById('finishedTransactionsModal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }

            // Event untuk tombol ubah transaksi
            setTimeout(function() {
                var btnUbah = document.getElementById('btnUbahTransaksi');
                if (btnUbah) {
                    btnUbah.onclick = function() {
                        modal.show();
                    };
                }
            }, 100);
        });
    });

    // Checkbox syarat & ketentuan
    var termsCheckbox = document.getElementById('termsCheckbox');
    var submitBtn = document.getElementById('submitBtn');
    termsCheckbox.addEventListener('change', function() {
        submitBtn.disabled = !this.checked;
    });
});
</script>
@endsection 