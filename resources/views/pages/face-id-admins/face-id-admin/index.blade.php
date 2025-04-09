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
                                    <h6 class="header-pretitle">
                                        Overview
                                    </h6>


                                    <h1 class="header-title text-truncate">
                                       Mobile Admins List
                                    </h1>

                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('face-id-admin.create') }}" class="btn btn-primary">
                                        Add Admin
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="card" id="contactsList">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <form method="GET" action="{{ route('face-id-admin.index') }}">
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
                                    <i id="bulk-delete-btn" class="bi bi-trash-fill text-danger" style="cursor: pointer; display: none;" title="Delete Selected"></i>


                                </div>
                            </div>

                        </div>

                        <div class="table-responsive">
                            <form method="POST" action="{{ route('face-id-admin.bulkDelete') }}">
                                @csrf
                                @method('DELETE')
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
                                        <a class="list-sort text-body-secondary" >Image</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" >Fullname</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" >Email</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" >Phone</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary">Password</a>
                                    </th>
                                    <th colspan="2">
                                        <a class="list-sort text-body-secondary" >Created At</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="list fs-base">
                                @foreach($admins as $admin)
                                    <tr>
                                        <td>

                                            <div class="form-check">
                                                <input class="form-check-input list-checkbox" id="listCheckboxOne" type="checkbox" data-id="{{ $admin->id }}">
                                                <label class="form-check-label" for="listCheckboxOne"></label>
                                            </div>
                                        </td>
                                        <td>

                                            <div class="avatar avatar-xs align-middle me-2" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ $admin->image_url }}">
                                                <img class="avatar-img" src="{{ $admin->image_url }}" alt="...">
                                            </div>
                                        </td>

                                         <td>
                                            <span class="item-title">{{ $admin->name }}</span>
                                         </td>
                                        <td>
                                            <span class="item-title">{{ $admin->email }}</span>
                                        </td>
                                        <td>
                                            <span class="item-phone text-reset">{{ $admin->phone }}</span>
                                        </td>

                                        <td>
                                            <span class="item-phone text-reset">{{ $admin->password }}</span>
                                        </td>
                                        <td>
                                            <span class="item-phone text-reset">{{ $admin->formatted_created_at }}</span>
                                        </td>
                                        <td class="text-end">

                                            <div class="dropdown">
                                                <a class="dropdown-ellipses dropdown-toggle" href="crm-contacts.html#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a data-bs-target="#modalUpdate" href="{{ route('face-id-admin.edit', $admin->id) }}" class="dropdown-item">Edit</a>
                                                </div>
                                            </div>
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


{{--    @extends('components.model')--}}
{{--    @extends('pages.face-id-admins.face-id-admin.modal')--}}



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
                logSelectedIds(); // Tanlangan idlarni chiqarish
            });
        });

        // All checkboxlarni tanlash
        document.getElementById('listCheckboxAll').addEventListener('change', function() {
            const isChecked = this.checked;
            document.querySelectorAll('.list-checkbox').forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
            toggleDeleteButton();
            logSelectedIds(); // Tanlangan idlarni chiqarish
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

        // Tanlangan checkboxlar orqali ID'larni konsolga chiqarish
        function logSelectedIds() {
            const selectedIds = [];
            document.querySelectorAll('.list-checkbox:checked').forEach(function(checkbox) {
                selectedIds.push(checkbox.getAttribute('data-id'));
            });
            console.log('Selected IDss:', selectedIds); // Tanlangan idlarni chiqarish
        }


        // Delete tugmasini bosilganda tanlangan ID'larni o'chirish
        document.getElementById('bulk-delete-btn').addEventListener('click', function(event) {
            event.preventDefault(); // Formani yuborishni to'xtatish

            const selectedIds = [];
            document.querySelectorAll('.list-checkbox:checked').forEach(function(checkbox) {
                selectedIds.push(checkbox.getAttribute('data-id'));
            });

            if (selectedIds.length > 0) {
                // AJAX so'rovini yuborish
                fetch('{{ route('face-id-admin.bulkDelete') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ ids: selectedIds })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {

                            alert(data.message); // Success message

                            document.getElementById('bulk-delete-btn').style.display = 'none';

                            // Tanlangan checkboxlarni olib tashlash
                            document.querySelectorAll('.list-checkbox:checked').forEach(function(checkbox) {
                                checkbox.closest('tr').remove(); // Tanlangan satrni o'chirish
                            });
                        } else {
                            alert(data.message); // Error message
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Xatolik yuz berdi');
                    });
            } else {
                alert('Hech narsa tanlanmagan');
            }
        });


    </script>

@endsection
