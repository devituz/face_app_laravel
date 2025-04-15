@extends('layouts.app')
@section('content')

    <div class="main-content">

        @extends('components.theme')
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">

                    <div class="header">
                        <div class="header-body">
                            <div class="row align-items-center">
                                <div class="col">

                                    <!-- Pretitle -->
                                    <h6 class="header-pretitle">
                                        Overview
                                    </h6>

                                    <!-- Title -->
                                    <h1 class="header-title text-truncate">
                                        Edit Face Id Admin
                                    </h1>

                                </div>

                            </div>

                        </div>
                    </div>
                    <div id="forms">

                        <div class="card">
                            <div class="card-body">


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
                                <form action="{{ route('face-id-admin.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT') <!-- Update qilish uchun methodni PUT qilib qo'yish zarur -->

                                    <div class="row">
                                        <!-- Full name input -->
                                        <div class="col-md-4 mb-3">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $admin->name }}" placeholder="Enter Full name" required>
                                        </div>
                                        <!-- Phone Number input -->
                                        <div class="col-md-4 mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $admin->phone }}" placeholder="Enter Phone Number" required>
                                        </div>
                                        <!-- Email input -->
                                        <div class="col-md-4 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" value="{{ $admin->email }}" placeholder="Enter Email" required>
                                        </div>
                                        <!-- Image Upload -->
                                        <div class="col-md-4 mb-3">
                                            <label for="image" class="form-label">Upload Image</label>
                                            <input type="file" class="form-control" name="image" id="image" accept="image/*" onchange="previewImage(event)" required>
                                            <div class="mt-3">
                                                <img id="imagePreview" src="{{ $admin->image ? asset('storage/' . $admin->image) : '#' }}" alt="Image preview" style="width: 100%; max-height: 200px; object-fit: cover;">
                                            </div>
                                        </div>

                                        <!-- Password input -->
                                        <div class="col-md-4 mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" value="{{ $admin->password }}" placeholder="Enter Password" required>
                                        </div>
                                        <!-- Password confirmation input -->
                                        <div class="col-md-4 mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="{{ $admin->password }}" placeholder="Confirm Password" required>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <div class="card-body">
                                        <button id="close-btn"  class="btn btn-secondary">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
