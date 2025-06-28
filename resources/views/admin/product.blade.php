@extends('layouts.main')

@section('content')
    @if(session()->has('success'))
        <div class="position-fixed top-0 end-0 p-3 notif" style="z-index: 9999">
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
            const toast = new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: 3000
            });
            toast.show();
        }
    </script>
    @include('layouts.navbar-admin')
    <div class="container mt-4">
        <h1 class="text-center">Data Produk dan Jasa</h1>
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h6 class="card-title">Total Categories</h6>
                        <h4 class="card-text">{{ $totalCategories }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h6 class="card-title">Total Products</h6>
                        <h4 class="card-text">{{ $totalProducts }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <form action="{{ route('product') }}" method="GET" class="row g-2 mb-3">
            <div class="col-md-5">
                <input class="form-control" type="search" name="keyword" placeholder="Cari produk atau jasa..." value="{{ request('keyword') }}">
            </div>
            <div class="col-md-4">
                <select class="form-select" name="category_id">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-grid">
                <button class="btn btn-outline-success" type="submit">Cari</button>
            </div>
        </form>
        <div class="">        
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                Tambah
            </button>
            <div style="overflow-x: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Diubah</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>
                                <img src="{{ asset('storage/' . $product->picture) }}" alt="{{ $product->product_name }}" width="100">
                            </td>
                            <td>{{ $product->product_name }}</td>
                            <td>
                                
                                @if ($product->category)
                                    <span class="badge bg-secondary">{{ $product->category->category_name }}</span>
                                @else
                                    <span class="badge bg-warning">Tanpa Kategori</span>
                                @endif

                                
                            </td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->updated_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $product->id }}">
                                    Ubah
                                </button>        
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $product->id }}">
                                    Hapus
                                  </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>

    @include('partials.product.delete-product')
    @include('partials.product.add-product')
    @include('partials.product.edit-product')
  
@endsection