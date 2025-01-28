@extends('layouts.app')

<body class="d-flex align-items-center bg-auth border-top border-top-2 border-primary">
<div class="container">
    <div class="row align-items-center">
        <div class="col-12 col-md-6 offset-xl-2 offset-md-1 order-md-2 mb-5 mb-md-0">
            <!-- Image -->
            <div class="text-center">
                <img src="{{asset('assets/logo/NewUU_Logo.png')}}" alt="..." class="img-fluid w-50 me-auto">
            </div>
        </div>
        <div class="col-12 col-md-5 col-xl-4 order-md-1 my-5">
            <!-- Heading -->
            <h1 class="display-4 text-center mb-3">
                Sign in
            </h1>



            @if ($errors->any())
                <div id="error-alert" class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <!-- Email address -->
                <div class="form-group">
                    <!-- Label -->
                    <label class="form-label">
                        Email Address
                    </label>
                    <!-- Input -->
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="name@address.com" required autofocus>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <!-- Label -->
                            <label class="form-label">
                                Password
                            </label>
                        </div>

                    </div> <!-- / .row -->
                    <!-- Input group -->
                    <div class="input-group input-group-merge">
                        <!-- Input -->
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Enter your password" required>
                        <!-- Icon -->
                    </div>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Submit -->
                <button class="btn btn-lg w-100 btn-primary mb-3">
                    Sign in
                </button>
            </form>
        </div>
    </div> <!-- / .row -->
</div>
</body>
