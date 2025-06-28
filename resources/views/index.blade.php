@extends('layouts.main')

@section('content')
@include('layouts.navbar')

<div class="container">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-dark mb-2">Daftar Produk Dan Jasa</h1>
        <p class="text-muted">Temukan produk terbaik untuk kebutuhan Anda</p>
    </div>

    {{-- Compact Search Form --}}
    <div class="bg-light rounded-3 p-3 mb-4">
        <form action="{{ route('product.index') }}" method="GET" class="row g-2">
            <div class="col-md-4">
                <div class="position-relative">
                    <input type="text" name="keyword" class="form-control border-0 bg-white rounded-2 ps-4" 
                        placeholder="Cari produk..." value="{{ request('keyword') }}">
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-2 text-muted"></i>
                </div>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select border-0 bg-white rounded-2">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="min_price" class="form-control border-0 bg-white rounded-2" 
                    placeholder="Min" value="{{ request('min_price') }}">
            </div>
            <div class="col-md-2">
                <input type="number" name="max_price" class="form-control border-0 bg-white rounded-2" 
                    placeholder="Max" value="{{ request('max_price') }}">
            </div>
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-primary rounded-2">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    {{-- Modern Product Cards --}}
    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden hover-lift" 
                     style="cursor: pointer;" 
                     data-bs-toggle="modal" 
                     data-bs-target="#productModal{{ $product->id }}">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $product->picture) }}" 
                             class="card-img-top" 
                             alt="{{ $product->product_name }}" 
                             style="object-fit: cover; height: 220px;">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                {{ $product->category->category_name ?? 'Tidak ada' }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3 text-truncate">{{ $product->product_name }}</h5>
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small">Harga</span>
                                <span class="fw-bold text-primary fs-5">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                            @if ($product->category && strtolower($product->category->category_name) !== 'jasa')
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-muted small">Stok</span>
                                    <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }} rounded-pill">
                                        {{ $product->stock }} tersedia
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Detail Modal --}}
            <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 rounded-4">
                        <div class="modal-header border-0 pb-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="row g-0">
                                <div class="col-md-6">
                                    <img src="{{ asset('storage/' . $product->picture) }}" 
                                         class="img-fluid rounded-start-4" 
                                         alt="{{ $product->product_name }}" 
                                         style="height: 400px; object-fit: cover; width: 100%;">
                                </div>
                                <div class="col-md-6 p-4">
                                    <div class="mb-3">
                                        <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">
                                            {{ $product->category->category_name ?? 'Tidak ada' }}
                                        </span>
                                        <h3 class="fw-bold mb-3">{{ $product->product_name }}</h3>
                                    </div>

                                    @if ($product->category && strtolower($product->category->category_name) === 'jasa')
                                        {{-- Layout untuk Jasa --}}
                                        <div class="mb-4">
                                            <h4 class="text-primary fw-bold mb-3">
                                                Rp{{ number_format($product->price, 0, ',', '.') }}
                                            </h4>
                                            <p class="text-muted mb-3">
                                                <i class="fas fa-tools me-2"></i>Layanan Jasa Profesional
                                            </p>
                                        </div>

                                        <div class="mb-4">
                                            <h6 class="fw-bold mb-2">Deskripsi Layanan:</h6>
                                            <p class="text-muted small">
                                                {{ $product->description ?? '-' }}
                                            </p>
                                        </div>

                                        <div class="mb-4">
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <div class="border rounded-3 p-3">
                                                        <i class="fas fa-clock text-primary mb-2"></i>
                                                        <div class="small text-muted">Estimasi</div>
                                                        <div class="fw-bold">Konsultasi</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="border rounded-3 p-3">
                                                        <i class="fas fa-shield-alt text-success mb-2"></i>
                                                        <div class="small text-muted">Garansi</div>
                                                        <div class="fw-bold">Tersedia</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Layout untuk Produk --}}
                                        <div class="mb-4">
                                            <h4 class="text-primary fw-bold mb-3">
                                                Rp{{ number_format($product->price, 0, ',', '.') }}
                                            </h4>
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="me-3">Stok:</span>
                                                <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }} rounded-pill px-3 py-2">
                                                    {{ $product->stock }} unit tersedia
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <h6 class="fw-bold mb-2">Detail Produk:</h6>
                                            <p class="text-muted small">
                                                {{ $product->description ?? 'Produk berkualitas tinggi dengan spesifikasi terbaik.' }}
                                            </p>
                                        </div>

                                        <div class="mb-4">
                                            <div class="row text-center">
                                                <div class="col-4">
                                                    <div class="border rounded-3 p-3">
                                                        <i class="fas fa-box text-primary mb-2"></i>
                                                        <div class="small text-muted">Kondisi</div>
                                                        <div class="fw-bold">Baru</div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="border rounded-3 p-3">
                                                        <i class="fas fa-truck text-success mb-2"></i>
                                                        <div class="small text-muted">Pengiriman</div>
                                                        <div class="fw-bold">Tersedia</div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="border rounded-3 p-3">
                                                        <i class="fas fa-undo text-info mb-2"></i>
                                                        <div class="small text-muted">Return</div>
                                                        <div class="fw-bold">7 Hari</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($contact)
                                        <div class="d-grid">
                                            <a href="https://wa.me/{{ $contact->first()->contact }}?text=Halo, saya tertarik dengan {{ $product->category && strtolower($product->category->category_name) === 'jasa' ? 'layanan' : 'produk' }} {{ $product->product_name }}" 
                                               target="_blank" 
                                               class="btn btn-success btn-lg rounded-3">
                                                <i class="fab fa-whatsapp me-2"></i>
                                                {{ $product->category && strtolower($product->category->category_name) === 'jasa' ? 'Konsultasi Sekarang' : 'Pesan Sekarang' }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-search fa-4x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-2">Tidak ada produk ditemukan</h4>
                    <p class="text-muted">Coba ubah kata kunci pencarian atau filter Anda</p>
                </div>
            </div>
        @endforelse
        
    </div>
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>

@if($contact)
<div class="floating-whatsapp">
    <a href="https://wa.me/{{ $contact->first()->contact }}" target="_blank" 
       class="btn btn-success rounded-circle shadow-lg d-flex align-items-center justify-content-center">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png" 
             width="28" height="28" alt="WhatsApp">
    </a>
    <div class="tooltip-text">Hubungi via WhatsApp</div>
</div>
@endif
@endsection
