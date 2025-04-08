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
                                        Scan Lists
                                    </h1>



                                </div>
                                    <div class="col-auto">
                                        <a href="{{ route('candidatelist.export') }}" class="btn btn-primary">
                                            Export Excel
                                        </a>
                                    </div>


                            </div>



                        </div>
                    </div>

                    <div class="card" id="contactsList">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">

                                    <!-- Form -->
                                    <form method="GET" action="{{ route('candidatelist.index') }}">
                                        <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                            <input class="form-control list-search" type="search" name="query" placeholder="Search" value="{{ request('query') }}">
                                            <span class="input-group-text">
                                            <i class="fe fe-search"></i>
                                        </span>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-auto me-n3">
                                    <!-- Delete Button (Initially Hidden) -->
                                    <button type="submit" class="btn btn-danger" id="bulk-delete-btn" style="display:none;">
                                        Delete Selected
                                    </button>
                                </div>
                            </div> <!-- / .row -->
                        </div>

                        <div class="table-responsive">
                            <form id="bulk-delete-form" method="POST" action="{{ route('candidatelist.bulkDelete') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" id="selected-ids" name="ids[]">

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
                                        <a class="list-sort text-body-secondary" >Search Image</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" >Upload Image</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" >Fullname</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" >Identifier</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" >Scan</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" data-sort="item-name">Created_at</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="list fs-base">
                                @foreach ($students as $student)
                                    <tr>
                                        <td>

                                            <div class="form-check">
                                                <input class="form-check-input list-checkbox" id="listCheckboxOne" type="checkbox" data-id="{{ $student->search_id }}">
                                                <label class="form-check-label" for="listCheckboxOne"></label>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="avatar avatar-xs align-middle me-2">
                                                <img class="avatar-img"
                                                     src="{{ $student->search_image_path }}"
                                                     data-bs-toggle="modal"
                                                     data-bs-target="#imageModal"
                                                     data-image="{{ $student->search_image_path }}"
                                                     alt="...">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="avatar avatar-xs align-middle me-2">
                                                <img class="avatar-img"
                                                     src="{{ $student->image_path }}"
                                                     data-bs-toggle="modal"
                                                     data-bs-target="#imageModal"
                                                     data-image="{{ $student->image_path }}"
                                                     alt="...">
                                            </div>
                                        </td>


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

                                        <td>
                                            <span class="item-title">{{ $student->name }}</span>
                                        </td>
                                        <td>
                                            <span class="item-identifier">{{ $student->identifier }}</span>
                                        </td>
                                        <td>
                                            <span class="item-identifier">{{ $student->scan_id ?? 'No scan available' }}</span>
                                        </td>
                                        <td>
                                            <span class="item-created_at">{{ \Carbon\Carbon::parse($student->student_created_at)->format('M d, Y H:i:s') }}</span>
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
                            </form>
                        </div>

                        <div class="card-footer d-flex justify-content-between">

                            <!-- Pagination (prev) -->
                            @if($prevPage)
                                <a class="btn btn-outline-primary" href="{{ url()->current() }}?page={{ $prevPage }}">
                                    <i class="fe fe-arrow-left"></i> Prev
                                </a>
                            @else
                                <button class="btn btn-outline-primary" disabled>
                                    <i class="fe fe-arrow-left"></i> Prev
                                </button>
                            @endif

                            <!-- Pagination (next) -->
                            @if($nextPage)
                                <a class="btn btn-outline-primary" href="{{ url()->current() }}?page={{ $nextPage }}">
                                    <i class="fe fe-arrow-right"></i> Next
                                </a>
                            @else
                                <button class="btn btn-outline-primary" disabled>
                                    <i class="fe fe-arrow-right"></i> Next
                                </button>
                            @endif
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

        // Checkboxlarni kuzatish
        document.querySelectorAll('.list-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                toggleDeleteButton();
                updateSelectedIds(); // Tanlangan ID'larni yangilash
            });
        });

        // All checkboxlarni tanlash
        document.getElementById('listCheckboxAll').addEventListener('change', function() {
            const isChecked = this.checked;
            document.querySelectorAll('.list-checkbox').forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
            toggleDeleteButton();
            updateSelectedIds(); // Tanlangan ID'larni yangilash
        });

        // Delete tugmasini ko'rsatish yoki yashirish
        function toggleDeleteButton() {
            const selectedCheckboxes = document.querySelectorAll('.list-checkbox:checked').length;
            const deleteButton = document.getElementById('bulk-delete-btn');

            // Agar checkboxlar tanlangan bo'lsa, delete buttonni ko'rsatish
            if (selectedCheckboxes > 0) {
                deleteButton.style.display = 'block';
            } else {
                deleteButton.style.display = 'none';
            }
        }

        // Tanlangan checkboxlar orqali ID'larni forma inputiga qo'shish
        function updateSelectedIds() {
            const selectedIds = [];
            document.querySelectorAll('.list-checkbox:checked').forEach(function(checkbox) {
                selectedIds.push(checkbox.getAttribute('data-id'));
            });

            // Tanlangan ID'larni forma inputiga qo'shish
            document.getElementById('selected-ids').value = selectedIds.join(',');
        }
    </script>


@endsection
