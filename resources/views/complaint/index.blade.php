@extends('layouts.app')
@section('content')
<div class="container" style="margin-top:60px;max-width:1100px;">
    <h2 style="font-weight:700;margin-bottom:24px;">Daftar Komplain</h2>
    <div class="card shadow" style="border-radius:16px;">
        <div class="card-body p-4">
            <table class="table table-hover align-middle" style="background:#fff;border-radius:12px;overflow:hidden;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>No. Telepon</th>
                        <th>Deskripsi</th>
                        <th>Bukti Gambar</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($complaints as $complaint)
                    <tr style="cursor:pointer;" onclick="window.location='{{ route('complaint.show', $complaint->id) }}'">
                        <td>{{ $complaint->id }}</td>
                        <td>{{ $complaint->user->name ?? '-' }}</td>
                        <td>{{ $complaint->user->phone ?? '-' }}</td>
                        <td style="max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $complaint->deskripsi }}</td>
                        <td>
                            @if($complaint->bukti_gambar)
                                <img src="{{ asset('storage/'.$complaint->bukti_gambar) }}" alt="Bukti" style="width:48px;height:48px;object-fit:cover;border-radius:8px;">
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $complaint->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 