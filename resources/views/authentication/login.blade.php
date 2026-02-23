@extends('layouts.main')

@section('content')
<div class="container d-flex justify-content-center align-items-center mt-5">
<div class="col-12 col-sm-8 col-md-6 col-lg-4">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0">Login</h4>
            </div>
            <div class="card-body p-4">
                <div class="col-12 text-center">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <script>
                            setTimeout(function() {
                                document.querySelector('.alert-success').style.display = 'none';
                            }, 3000);
                        </script>
                    </div>
                    @endif
                </div>  
                <form method="POST" action="{{ route('authenticate') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    @if ($errors->has('loginError'))
                        <div class="alert alert-danger text-center" role="alert">
                            {{ $errors->first('loginError') }}
                        </div>
                    @endif

                    @if(session('berhasilTambahPengguna'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ session('berhasilTambahPengguna') }}
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Login
                        </button>
                        <a href="{{ route('password.request') }}">Lupa sandi</a>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('register') }}">Daftar akun</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection