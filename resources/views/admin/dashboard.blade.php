@extends('layouts.main')

@section('content')
@include('layouts.navbar-admin')

<div class="container mt-4">
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

    <div class="card shadow-sm mt-4">
        <div class="card-header">
            <h5 class="mb-0">Products per Category</h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($productsPerCategory as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $category->category_name }}
                        <span class="badge bg-primary rounded-pill">{{ $category->products_count }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
