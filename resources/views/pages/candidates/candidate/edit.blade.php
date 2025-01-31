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
                                <h1 class="header-title">Edit Candidate</h1>
                            </div>
                        </div>
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

                                    <form action="{{ route('candidate.update', $candidate['id']) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <!-- Ism kiritish -->
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Full name" value="{{ old('name', $candidate['name']) }}" required>
                                            </div>
                                            <!-- Rasm yuklash -->
                                            <div class="col-md-6 mb-3">
                                                <label for="image_url" class="form-label">Upload Image</label>
                                                <input type="file" class="form-control" name="image_url" id="image_url" accept="image/*" onchange="previewImage(event)">
                                                <div class="mt-3">
                                                    @if (!empty($candidate['image_url']))
                                                        <img src="{{ asset('storage/'.$candidate['image_url']) }}" alt="Current Image" style="width: 100%; max-height: 200px; object-fit: cover;">
                                                    @else
                                                        <img id="imagePreview" src="#" alt="Image preview" style="display: none; width: 100%; max-height: 200px; object-fit: cover;">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="card-body">
                                                <button type="button" class="btn btn-secondary" onclick="history.back()">Close</button>
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
