@extends('layouts.app')

@section('content')

    <div class="main-content">

        @extends('components.theme')

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">

                    <!-- Header -->
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
                                        Candidate List
                                    </h1>

                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('candidate.create') }}" class="btn btn-primary">
                                        Add Candidate
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('students.export') }}" class="btn btn-primary">
                                        Export Excel
                                    </a>
                                </div>
                            </div> <!-- / .row -->
                            <div class="row align-items-center">
                                <div class="col">

                                    <!-- Nav -->


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" data-list='' id="contactsList">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">

                                    <!-- Form -->
                                    <form action="{{ route('candidates.search') }}" method="GET">
                                        <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                            <input class="form-control list-search" type="search" name="query"
                                                   placeholder="Search" value="{{ request('query') }}">
                                            <span class="input-group-text">
                                                <i class="fe fe-search"></i>
                                            </span>
                                        </div>
                                    </form>

                                </div>

                            </div> <!-- / .row -->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-nowrap card-table">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="form-check mb-n2">
                                            <input class="form-check-input list-checkbox-all" id="listCheckboxAll" type="checkbox" data-id="id">
                                            <label class="form-check-label" for="listCheckboxAll"></label>
                                        </div>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary">Image</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" >Fullname</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" >Identifier</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" >Created_at</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="list fs-base">
                                @foreach ($students as $student)
                                    <tr>
                                        <td>
                                            <!-- Checkbox -->
                                            <div class="form-check">
                                                <input class="form-check-input list-checkbox" id="listCheckboxOne" type="checkbox" data-id="{{ $student['id'] }}">
                                                <label class="form-check-label" for="listCheckboxOne"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <!-- Avatar rasm -->
                                            <div class="avatar avatar-xs align-middle me-2">
                                                <img class="avatar-img"
                                                     src="{{ $student['image_url'] }}"
                                                     data-bs-toggle="modal"
                                                     data-bs-target="#imageModal"
                                                     data-image="{{ $student['image_url'] }}"
                                                     alt="...">
                                            </div>

                                            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="imageModalLabel">Full Image</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img id="modalImage" class="img-fluid" src="" alt="Full Image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            <span class="item-title">{{ $student['name'] }}</span>
                                        </td>
                                        <td>
                                            <span class="item-identifier">{{ $student['identifier'] }}</span>
                                        </td>
                                        <td>
                                            <span class="item-created_at">{{ $student['created_at'] }}</span>
                                        </td>


                                    </tr>
                                @endforeach
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12" style="width: 200px; visibility: hidden;">
                                            Bu element ko'rinmaydi, lekin joy egallaydi.
                                        </div>
                                    </div>
                                </div>
                                </tbody>
                            </table>
                        </div>

                                                <div class="card-footer d-flex justify-content-between">
                                                    <!-- Pagination (prev) -->
                                                                                @if ($prevPage)
                                                                                    <a class="btn btn-outline-primary" href="{{ route('candidate.index', ['page' => $prevPage]) }}">
                                                                                        <i class="fe fe-arrow-left"></i> Prev
                                                                                    </a>
                                                                                @else
                                                                                    <button class="btn btn-outline-secondary disabled">
                                                                                        <i class="fe fe-arrow-left"></i> Prev
                                                                                    </button>
                                                                                @endif
                                                    <!-- Pagination -->
{{--                                                    <ul class="list-pagination pagination pagination-tabs card-pagination"></ul>--}}

                                                    <!-- Pagination (next) -->
                                                    @if ($nextPage)
                                                        <a class="btn btn-outline-primary" href="{{ route('candidate.index', ['page' => $nextPage]) }}">
                                                            Next <i class="fe fe-arrow-right"></i>
                                                        </a>
                                                    @else
                                                        <button class="btn btn-outline-secondary disabled">
                                                            Next <i class="fe fe-arrow-right"></i>
                                                        </button>
                                                    @endif


                                                    <!-- Alert -->
                                                    <div class="list-alert alert alert-dark alert-dismissible border fade" role="alert">
                                                        <!-- Content -->
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <!-- Checkbox -->
                                                                <div class="form-check">
                                                                    <input class="form-check-input" id="listAlertCheckbox" type="checkbox" checked disabled>
                                                                    <label class="form-check-label text-white" for="listAlertCheckbox">
                                                                        <span class="list-alert-count">0</span> deal(s)
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto me-n3">
                                                                <button id="candidate-bulk-delete-btn" data-url="{{ route('candidate.bulkDelete') }}" class="btn btn-sm bg-danger text-white">
                                                                    Delete Selected
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="list-alert-close btn-close" aria-label="Close"></button>
                                                    </div>
                                                </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal ochilganda rasm manzilini o'zgartirish
        document.querySelectorAll('.avatar img').forEach(function(avatar) {
            avatar.addEventListener('click', function() {
                var imageUrl = avatar.getAttribute('data-image');
                document.getElementById('modalImage').src = imageUrl;
            });
        });



        document.addEventListener("DOMContentLoaded", function () {
            let checkboxes = document.querySelectorAll(".list-checkbox");
            let alertBox = document.querySelector(".list-alert");
            let alertCount = document.querySelector(".list-alert-count");

            function updateAlert() {
                let selectedCount = document.querySelectorAll(".list-checkbox:checked").length;

                if (selectedCount > 0) {
                    alertBox.classList.add("show");
                    alertCount.textContent = selectedCount;
                } else {
                    alertBox.classList.remove("show");
                }
            }

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener("change", updateAlert);
            });

            // Sahifa yuklanganda tekshirish
            updateAlert();
        });

    </script>

@endsection
