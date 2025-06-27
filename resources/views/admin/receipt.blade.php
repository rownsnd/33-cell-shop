@extends('layouts.main')

@section('content')
@include('layouts.navbar-admin')

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
        <div class="row mb-4">
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
                <td>{{ $receipt->product->product_name ?? 'Produk dihapus' }}</td>
                <td>{{ $receipt->status }}</td>
                <td>{{ \Carbon\Carbon::parse($receipt->estimate)->format('d-m-Y') }}</td>

                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $receipt->id }}">Ubah</button>
                    <form action="{{ route('receipt.destroy', $receipt->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus resi ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            <!-- Modal Edit -->
            <div class="modal fade" id="editModal{{ $receipt->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('receipt.update', $receipt->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Ubah Resi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Customer</label>
                                    <input type="text" name="customer_name" class="form-control" value="{{ $receipt->customer_name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Kode</label>
                                    <input type="text" name="code" class="form-control" value="{{ $receipt->code }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Produk</label>
                                    <select name="product_id" class="form-select" required>
                                        <option value="">Pilih Produk</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ $product->id == $receipt->product_id ? 'selected' : '' }}>
                                                {{ $product->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="Terima Hp" {{ $receipt->status == 'Terima Hp' ? 'selected' : '' }}>Terima Hp</option>
                                        <option value="Proses" {{ $receipt->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="Selesai" {{ $receipt->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Estimasi</label>
                                    <input type="date" name="estimate" class="form-control" value="{{ $receipt->estimate }}" required>
                                </div>
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('receipt.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Resi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Customer</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Produk</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Terima Hp">Terima Hp</option>
                            <option value="Proses">Proses</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Estimasi</label>
                        <input type="date" name="estimate" class="form-control" required>
                    </div>
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
    </div>
</div>

@endsection

