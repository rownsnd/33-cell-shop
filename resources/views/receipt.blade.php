@extends('layouts.main')

@section('content')
@include('layouts.navbar')

<div class="container mt-5">
    <h2 class="text-center mb-4">Lacak Status Resi</h2>

    {{-- Form input kode resi --}}
    <form action="{{ route('receipt.track') }}" method="GET" class="row justify-content-center mb-4">
        <div class="col-md-6">
            <input type="text" name="code" class="form-control" placeholder="Masukkan kode resi..." value="{{ request('code') }}" required>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Lacak</button>
        </div>
    </form>

    {{-- Hasil pencarian --}}
    @if(request('code'))
        @if($receipt)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Kode: {{ $receipt->code }}</h5>
                    <p class="card-text">
                        <strong>Customer:</strong> {{ $receipt->customer_name }} <br>
                        <strong>Produk:</strong> {{ $receipt->product->product_name ?? 'Produk dihapus' }} <br>
                        <strong>Status:</strong> {{ $receipt->status }} <br>
                        <strong>Estimasi Selesai:</strong> {{ \Carbon\Carbon::parse($receipt->estimate)->format('d-m-Y') }}
                    </p>
                </div>
            </div>
        @else
            <div class="alert alert-danger">
                Resi dengan kode <strong>{{ request('code') }}</strong> tidak ditemukan.
            </div>
        @endif
    @endif
</div>
@endsection
