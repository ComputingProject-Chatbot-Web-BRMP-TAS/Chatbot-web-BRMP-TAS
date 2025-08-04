@php $hideAppbar = true; @endphp
@extends('layouts.app')
@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100" style="background: #eaffea;">
    <div class="w-100" style="max-width: 400px;">
        <div class="card shadow" style="border-radius: 20px;">
            <div class="card-body p-4">
                <h2 class="text-center mb-4" style="color: #388e3c;">Daftar</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('register.post') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required autofocus style="background: #fffbe7; border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required style="background: #fffbe7; border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <input type="tel" name="phone" class="form-control" placeholder="Nomor HP" pattern="^(08|628)[0-9]{7,11}$" required style="background: #fffbe7; border-radius: 10px;">
                    </div>
                    <div class="mb-3 position-relative">
                        <input type="password" name="password" class="form-control password-field" placeholder="Password" required style="background: #fffbe7; border-radius: 10px;">
                        <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3" style="cursor:pointer; color:#ffd600;">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                    <div class="mb-3 position-relative">
                        <input type="password" name="password_confirmation" class="form-control password-field" placeholder="Konfirmasi Password" required style="background: #fffbe7; border-radius: 10px;">
                        <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3" style="cursor:pointer; color:#ffd600;">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                    <button type="submit" class="btn w-100" style="background: #388e3c; color: #fff; border-radius: 10px;">Daftar</button>
                </form>
                <div class="text-center mt-3">
                    <small>Sudah punya akun? <a href="{{ route('login') }}" style="color: #ffd600;">Masuk</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        $('.toggle-password').on('click', function() {
            let input = $(this).siblings('.password-field');
            let type = input.attr('type') === 'password' ? 'text' : 'password';
            input.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });
    });
</script>
@endpush
