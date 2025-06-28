@extends('layouts.main')

@section('content')
@include('layouts.navbar-admin')

<div class="container mt-4">
    <div class="row g-3">
        <div class="row g-3 mt-2">
            <div class="col-md-4">
                <div class="card shadow-sm text-center bg-success text-white">
                    <div class="card-body">
                        <h6 class="card-title">Completed Receipts</h6>
                        <h4 class="card-text">{{ $completedReceipts }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center bg-warning text-dark">
                    <div class="card-body">
                        <h6 class="card-title">Pending Receipts</h6>
                        <h4 class="card-text">{{ $pendingReceipts }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h6 class="card-title">Total Receipts</h6>
                        <h4 class="card-text">{{ $totalReceipts }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>       
</div>       

<div class="container mt-4">
    @if(session()->has('success'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        <div id="liveToast" class="toast show align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <script>
    const toastEl = document.querySelector('.toast');
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
        setTimeout(function() {
            toastEl.style.display = 'none';
        }, 3000);
    }
    </script>


    <h1 class="text-center mb-4">Data Resi</h1>
    <form action="{{ route('receipt.index') }}" method="GET">
        <div class="row g-2 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama atau kode" value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="sort" class="form-select">
                    <option value="">-- Pilih --</option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </div>
    </form>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Resi</button>
    <div style="overflow-x: auto;">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Kode</th>
                <th>Produk</th>
                <th>Status</th>
                <th>Estimasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($receipts as $receipt)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $receipt->customer_name }}</td>
                <td>{{ $receipt->code }}</td>
                <td>{{ $receipt->product->product_name ?? 'Jasa tidak ada' }}</td>
                <td>{{ $receipt->status }}</td>
                <td>{{ \Carbon\Carbon::parse($receipt->estimate)->format('d-m-Y') }}</td>

                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $receipt->id }}">Ubah</button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $receipt->id }}">
                        Hapus
                    </button>
                    @include('partials.receipt.delete-receipt')

                </td>
            </tr>
            @include('partials.receipt.edit-receipt')
            @endforeach
        </tbody>
    </table>
    </div>
</div>


@include('partials.receipt.add-receipt')

@endsection

