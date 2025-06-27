@extends('layouts.main')

@section('content')
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
        }
    </script>
    @include('layouts.navbar-admin')
    <div class="container">
        <h1 class="text-center">Data Produk dan Jasa</h1>
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
                                <form action="{{ route('destroy.product', $product->id) }}" method="POST" value="{{ csrf_token() }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $product->id }}">
                                    Ubah
                                </button>        
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="productModalLabel">Tambah Produk atau Jasa</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('store.product') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                {{-- Picture --}}
                <div class="mb-3">
                  <label for="picture" class="form-label">Gambar</label>
                  <input type="file" class="form-control" id="picture" name="picture" accept="image/*" required>
                </div>
      
                {{-- Product Name --}}
                <div class="mb-3">
                  <label for="product_name" class="form-label">Nama Produk</label>
                  <input type="text" class="form-control" id="product_name" name="product_name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="category_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Stock --}}
                <div class="mb-3">
                  <label for="stock" class="form-label">Stok</label>
                  <input type="number" class="form-control" id="stock" name="stock" min="0" required>
                </div>
      
                {{-- Price --}}
                <div class="mb-3">
                  <label for="price" class="form-label">Harga</label>
                  <input type="number" class="form-control" id="price" name="price" min="0" required>
                </div>
      
                {{-- User ID (hidden, misal user login) --}}
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
      
                <button type="submit" class="btn btn-primary">Simpan</button>
              </form>
            </div>
          </div>
        </div>
      </div>

    @foreach ($products as $product)
    <!-- Modal Edit untuk tiap produk -->
    <div class="modal fade" id="modalEdit{{ $product->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $product->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel{{ $product->id }}">Ubah Produk atau Jasa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update.product', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Gambar (biarkan kosong jika tidak ingin mengganti)</label>
                    <input type="file" class="form-control" name="picture" accept="image/*">
                    @if ($product->picture)
                    <img src="{{ asset('storage/' . $product->picture) }}" width="100" class="mt-2" alt="{{ $product->product_name }}">
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" name="product_name" value="{{ $product->product_name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="category_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control" name="stock" min="0" value="{{ $product->stock }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" class="form-control" name="price" min="0" value="{{ $product->price }}" required>
                </div>

                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </form>
            </div>
            </div>
        </div>
    </div>

    @endforeach



  
@endsection