{{-- Modern Navbar --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('product.index') }}">
            33 Phone Shop
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-2">
                    <a class="nav-link px-3 py-2 rounded-pill text-dark fw-medium {{ Request::is('/*') ? 'bg-primary text-white' : '' }}" 
                       href="{{ route('product.index') }}">
                        Home
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link px-3 py-2 rounded-pill text-dark fw-medium {{ Request::is('track*') ? 'bg-primary text-white' : '' }}" 
                       href="{{ route('receipt.customer') }}">
                        Resi
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>