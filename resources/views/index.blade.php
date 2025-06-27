@extends('layouts.main')

@section('content')
@include('layouts.navbar')

<div class="container">
    <h1 class="text-center mb-4">Daftar Produk</h1>

    {{-- Form cari --}}
    <form action="{{ route('product.index') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="keyword" class="form-control" placeholder="Cari produk..." value="{{ request('keyword') }}">
        </div>
        <div class="col-md-3">
            <select name="category_id" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="min_price" class="form-control" placeholder="Harga Min" value="{{ request('min_price') }}">
        </div>
        <div class="col-md-2">
            <input type="number" name="max_price" class="form-control" placeholder="Harga Max" value="{{ request('max_price') }}">
        </div>
        <div class="col-md-1 d-grid">
            <button type="submit" class="btn btn-success">Cari</button>
        </div>
    </form>

    {{-- Tabel produk --}}
    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/' . $product->picture) }}" class="card-img-top" alt="{{ $product->product_name }}" style="object-fit: cover; height: 200px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->product_name }}</h5>
                        <p class="card-text">
                            <strong>Kategori:</strong> {{ $product->category->category_name ?? 'Tidak ada' }}<br>
                            <strong>Harga:</strong> Rp{{ number_format($product->price, 0, ',', '.') }}<br>
                            @if ($product->category && strtolower($product->category->category_name) !== 'jasa')
                                <strong>Stok:</strong> {{ $product->stock }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Tidak ada produk ditemukan.
                </div>
            </div>
            
        @endforelse
    </div>
</div>
@if($contact)
<div class="fixed-whatsapp">
    <a href="https://wa.me/{{  $contact->first()->contact}}" target="_blank" class="btn btn-success btn-sm">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png" width="24" height="24" alt="WhatsApp" class="me-2">
        Hubungi via WhatsApp
    </a>
</div>
@endif
<style>
    .fixed-whatsapp {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
    }
</style>
@endsection
