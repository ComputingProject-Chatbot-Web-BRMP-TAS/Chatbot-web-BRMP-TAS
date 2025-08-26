@extends('layouts.admin')

@section('content')
    <div class="container" style="padding-top:80px;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3>Input Billing & Ongkir</h3>
                <form method="POST" action="{{ route('admin.transactions.billing.store', $transaction->transaction_id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="billing_code_file" class="form-label">File Kode Billing</label>
                        <input type="file" class="form-control" name="billing_code_file" id="billing_code_file"
                            accept=".jpg,.jpeg,.png,.pdf" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_rek_ongkir" class="form-label">No Rekening Ongkir</label>
                        <input type="text" class="form-control" name="no_rek_ongkir" id="no_rek_ongkir" required>
                    </div>
                    <div class="mb-3">
                        <label for="total_ongkir" class="form-label">Total Ongkir</label>
                        <input type="number" class="form-control" name="total_ongkir" id="total_ongkir" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
