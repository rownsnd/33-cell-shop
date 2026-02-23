@extends('layouts.main')

@section('content')
@include('layouts.navbar')

<div class="container mt-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Lacak Status Perbaikan</h2>
        <p class="text-muted">Masukkan kode resi Anda untuk melihat status perbaikan.</p>
    </div>

    {{-- Form input kode resi --}}
    <div class="bg-light p-4 rounded-3 shadow-sm mb-4">
        <form action="{{ route('receipt.track') }}" method="GET" class="row g-2 justify-content-center">
            <div class="col-md-6">
                <input type="text" name="code" class="form-control border-0 shadow-sm rounded-2" 
                    placeholder="Masukkan kode resi..." value="{{ request('code') }}" required>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary rounded-2">
                    <i class="fas fa-search me-1"></i> Lacak
                </button>
            </div>
        </form>
    </div>

    {{-- Hasil pencarian --}}
    @if(request('code'))
        @if($receipt)
            <div class="card border-0 shadow rounded-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-barcode me-2 text-primary"></i> 
                        Kode: <span class="text-dark fw-bold">{{ $receipt->code }}</span>
                    </h5>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-transparent px-0 d-flex justify-content-between">
                            <span><i class="fas fa-user me-2 text-muted"></i> Customer</span>
                            <span class="fw-bold">{{ $receipt->customer_name }}</span>
                        </li>
                        <li class="list-group-item bg-transparent px-0 d-flex justify-content-between">
                            <span><i class="fas fa-box-open me-2 text-muted"></i> Jasa</span>
                            <span class="fw-bold">{{ $receipt->product->product_name ?? 'Produk dihapus' }}</span>
                        </li>
                        <li class="list-group-item bg-transparent px-0 d-flex justify-content-between">
                            <span><i class="fas fa-info-circle me-2 text-muted"></i> Status</span>
                            <span class="badge bg-{{ $receipt->status == 'Selesai' ? 'success' : 'warning' }} rounded-pill">
                                {{ $receipt->status }}
                            </span>
                        </li>
                        <li class="list-group-item bg-transparent px-0 d-flex justify-content-between">
                            <span><i class="fas fa-calendar-alt me-2 text-muted"></i> Estimasi Selesai</span>
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($receipt->estimate)->format('d-m-Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        @else
            <div class="alert alert-danger shadow-sm rounded-2">
                <i class="fas fa-exclamation-circle me-2"></i>
                Resi dengan kode <strong>{{ request('code') }}</strong> tidak ditemukan.
            </div>
        @endif
    @endif
</div>
@endsection
