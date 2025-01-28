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
                                        Face id Admin
                                    </h1>

                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('face-id-admin.create') }}" class="btn btn-primary">
                                        Add Admin
                                    </a>
                                </div>
                            </div> <!-- / .row -->
                            <div class="row align-items-center">
                                <div class="col">

                                    <!-- Nav -->
                                    <ul class="nav nav-tabs nav-overflow header-tabs">
                                        <li class="nav-item">
                                            <a href="crm-contacts.html#!" class="nav-link text-nowrap active">
                                                All contacts <span class="badge rounded-pill text-bg-secondary-subtle">823</span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" data-list='{"valueNames": ["item-name", "item-title", "item-email", "item-phone", "item-score", "item-company"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">

                                    <!-- Form -->
                                    <form>
                                        <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                            <input class="form-control list-search" type="search" placeholder="Search">
                                            <span class="input-group-text">
                                                <i class="fe fe-search"></i>
                                            </span>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-auto me-n3">

                                    <!-- Select -->
                                    <form>
                                        <select class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": false}'>
                                            <option>5 per page</option>
                                            <option selected>10 per page</option>
                                            <option>All</option>
                                        </select>
                                    </form>

                                </div>
                            </div> <!-- / .row -->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-nowrap card-table">
                                <thead>
                                <tr>
                                    <th>
                                        <!-- Checkbox -->
                                        <div class="form-check mb-n2">
                                            <input class="form-check-input list-checkbox-all" id="listCheckboxAll" type="checkbox" data-id="id">
                                            <label class="form-check-label" for="listCheckboxAll"></label>
                                        </div>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" data-sort="item-name">Fullname</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" data-sort="item-email">Email</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" data-sort="item-phone">Phone</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" data-sort="item-phone">Status</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" data-sort="item-password">Password</a>
                                    </th>
                                    <th colspan="2">
                                        <a class="list-sort text-body-secondary" data-sort="item-company">Created At</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="list fs-base">
                                @foreach($admins as $admin)
                                    <tr>
                                        <td>
                                            <!-- Checkbox -->
                                            <div class="form-check">
                                                <input class="form-check-input list-checkbox" id="listCheckboxOne" type="checkbox" data-id="{{ $admin->id }}">
                                                <label class="form-check-label" for="listCheckboxOne"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="avatar avatar-xs align-middle me-2">
                                                <img class="avatar-img rounded-circle" src="{{ $admin->image_url }}" alt="...">
                                            </div>
                                            <a class="item-name text-reset">{{ $admin->name }}</a>
                                        </td>
                                        <td>
                                            <span class="item-title">{{ $admin->email }}</span>
                                        </td>
                                        <td>
                                            <span class="item-phone text-reset">{{ $admin->phone }}</span>
                                        </td>
                                        <td>
                                            <span class="item-score badge text-bg-danger-subtle">{{ $admin->is_admin == 1 ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td>
                                            <span class="item-phone text-reset">{{ $admin->password }}</span>
                                        </td>
                                        <td>
                                            <span class="item-phone text-reset">{{ $admin->formatted_created_at }}</span>
                                        </td>
                                        <td class="text-end">
                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                                <a class="dropdown-ellipses dropdown-toggle" href="crm-contacts.html#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a data-bs-target="#modalUpdate" href="{{ route('face-id-admin.edit', $admin->id) }}" class="dropdown-item">Edit</a>
                                                    <a href="#deleteModal" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('deleteForm').action = '{{ route('face-id-admin.destroy', $admin->id) }}';">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <!-- Pagination (prev) -->
                            <ul class="list-pagination-prev pagination pagination-tabs card-pagination">
                                <li class="page-item">
                                    <a class="page-link ps-0 pe-4 border-end" href="crm-contacts.html#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                    </a>
                                </li>
                            </ul>

                            <!-- Pagination -->
                            <ul class="list-pagination pagination pagination-tabs card-pagination"></ul>

                            <!-- Pagination (next) -->
                            <ul class="list-pagination-next pagination pagination-tabs card-pagination">
                                <li class="page-item">
                                    <a class="page-link ps-4 pe-0 border-start" href="crm-contacts.html#">
                                        Next <i class="fe fe-arrow-right ms-1"></i>
                                    </a>
                                </li>
                            </ul>

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
                                        <button id="bulk-delete-btn" data-url="{{ route('admin.bulkDelete') }}" class="btn btn-sm bg-danger text-white">
                                            Delete Selected
                                        </button>
                                    </div>
                                </div>
                                <!-- / .row -->
                                <!-- Close -->
                                <button type="button" class="list-alert-close btn-close" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / .row -->
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteBtn = document.getElementById('bulk-delete-btn');
            const url = deleteBtn.getAttribute('data-url');  // URLni data-url atributidan olish

            const checkboxes = document.querySelectorAll('.list-checkbox');
            const selectAllCheckbox = document.getElementById('listCheckboxAll');
            let selectedIds = [];

            // Select all checkbox ni o'zgartirish
            selectAllCheckbox.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });

                // Tanlangan IDlarni chiqarish
                selectedIds = []; // Avvalgi tanlanganlarni tozalash
                if (selectAllCheckbox.checked) {
                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            selectedIds.push(checkbox.getAttribute('data-id'));
                        }
                    });
                }

                console.log('Selected IDs: ', selectedIds);
            });

            // Har bir checkboxni tekshirish
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (checkbox.checked) {
                        selectedIds.push(checkbox.getAttribute('data-id'));
                    } else {
                        selectedIds = selectedIds.filter(id => id !== checkbox.getAttribute('data-id'));
                    }

                    console.log('Selected IDs: ', selectedIds);
                });
            });

            // Bulk delete tugmasi bosilganda
            deleteBtn.addEventListener('click', function() {
                if (selectedIds.length > 0) {
                    // SweetAlert2 bilan tasdiqlash oynasini chiqarish
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you want to delete the selected admins?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete them!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Agar foydalanuvchi "Yes" ni bossa, o'chirishni amalga oshirish
                            fetch(url, {  // URLni dinamik ravishda olish
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
                                        // O'chirilganidan keyin sahifani yangilash
                                        Swal.fire(
                                            'Deleted!',
                                            'The selected admins have been deleted.',
                                            'success'
                                        );
                                        location.reload();
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        } else {
                            // Agar foydalanuvchi "No" ni bossa, tasdiqlash oynasi yopiladi
                            Swal.fire(
                                'Cancelled',
                                'No admins were deleted.',
                                'info'
                            );
                        }
                    });
                } else {
                    // Agar tanlangan adminlar bo'lmasa
                    alert('Please select at least one admin to delete.');
                }
            });
        });
    </script>

    @extends('pages.face-id-admins.face-id-admin.modal')

@endsection
