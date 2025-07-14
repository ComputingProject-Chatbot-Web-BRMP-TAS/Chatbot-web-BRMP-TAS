<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Verify Your Email Address</div>
                    <div class="card-body">
                        @if (session('resent') || session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('resent') ? 'A fresh verification link has been sent to your email address.' : session('message') }}
                            </div>
                        @endif
                        <p>Before proceeding, please check your email for a verification link.</p>
                        <p>If you did not receive the email,</p>
                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">click here to request another</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
