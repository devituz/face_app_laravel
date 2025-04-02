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
                                        Create Candidate
                                    </h1>

                                </div>

                            </div> <!-- / .row -->

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

                                <form action="{{ route('candidate.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <!-- Ism kiritish -->
                                        <div class="col-md-4 mb-3">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Full name" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="identifier" class="form-label">Identifier</label>
                                            <input type="text" class="form-control" name="identifier" id="identifier" placeholder="Enter identifier" required>
                                        </div>
                                        <!-- Rasm yuklash -->
                                        <div class="col-md-4 mb-3">
                                            <label for="image_url" class="form-label">Upload Image</label>
                                            <input type="file" class="form-control" name="image_url" id="image_url" accept="image/*" onchange="previewImage(event)" required>
                                            <div class="mt-3">
                                                <img id="imagePreview" src="#" alt="Image preview" style="display: none; width: 100%; max-height: 200px; object-fit: cover;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="card-body">
                                            <button type="button" class="btn btn-secondary" onclick="history.back()">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
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
