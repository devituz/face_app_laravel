@extends('layouts.app')
@section('content')

    <div class="main-content">
        @extends('components.theme')
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    <div id="forms">
                        <div class="header mt-md-5">
                            <div class="header-body">

                                <!-- Title -->
                                <h1 class="header-title">
                                    Forms
                                </h1>


                                <p class="header-subtitle">
                                    Dashkit supports all of Bootstrap's default form styling in addition to a handful of new input types and
                                    features. Please read
                                    <a target="_blank" href="https://getbootstrap.com/docs/5.3/forms/overview/">the official documentation</a> for
                                    a full list of options from Bootstrap's core library.
                                </p>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">

                                <!-- Form -->
                                <form action="{{ route('face-id-admin.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <!-- Full name input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Full name" required>
                                        </div>
                                        <!-- Phone Number input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone Number" required>
                                        </div>
                                        <!-- Email input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required>
                                        </div>
                                        <!-- Image Upload -->
                                        <div class="col-md-6 mb-3">
                                            <label for="image" class="form-label">Upload Image</label>
                                            <input type="file" class="form-control" name="image" id="image" accept="image/*" onchange="previewImage(event)">
                                            <div class="mt-3">
                                                <img id="imagePreview" src="#" alt="Image preview" style="display: none; width: 100%; max-height: 200px; object-fit: cover;">
                                            </div>
                                        </div>
                                        <!-- Password input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required>
                                        </div>
                                        <!-- Password confirmation input -->
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection



