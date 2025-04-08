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
                                    <!-- Search Form -->
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
                            </div>
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
                                                <input class="form-check-input list-checkbox-all" id="listCheckboxAll" type="checkbox">
                                                <label class="form-check-label" for="listCheckboxAll"></label>
                                            </div>
                                        </th>
                                        <th>Search Image</th>
                                        <th>Upload Image</th>
                                        <th>Fullname</th>
                                        <th>Identifier</th>
                                        <th>Scan</th>
                                        <th>Created_at</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input list-checkbox" type="checkbox" data-id="{{ $student->search_id }}">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="avatar avatar-xs align-middle me-2">
                                                    <img class="avatar-img" src="{{ $student->search_image_path }}" alt="...">
                                                </div>
                                            </td>

                                            <td>
                                                <div class="avatar avatar-xs align-middle me-2">
                                                    <img class="avatar-img" src="{{ $student->image_path }}" alt="...">
                                                </div>
                                            </td>

                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->identifier }}</td>
                                            <td>{{ $student->scan_id ?? 'No scan available' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($student->student_created_at)->format('M d, Y H:i:s') }}</td>
                                        </tr>
                                    @endforeach
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
