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
                                        Face id Admin List
                                    </h1>

                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('face-id-admin.create') }}" class="btn btn-primary">
                                        Add Admin
                                    </a>
                                </div>
                            </div> <!-- / .row -->

                        </div>
                    </div>

                    <div class="card" id="contactsList">
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
                                        <div class="form-check mb-n2">
                                            <input class="form-check-input list-checkbox-all" id="listCheckboxAll" type="checkbox" data-id="id">
                                            <label class="form-check-label" for="listCheckboxAll"></label>
                                        </div>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" >Fullname</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary">Email</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" >Phone</a>
                                    </th>
                                    {{--                                    <th>--}}
                                    {{--                                        <a class="list-sort text-body-secondary" data-sort="item-phone">Status</a>--}}
                                    {{--                                    </th>--}}
                                    <th>
                                        <a class="list-sort text-body-secondary" >Password</a>
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
                                            <span class="item-title">{{ $admin->name }}</span>
                                        </td>
                                        <td>
                                            <span class="item-title">{{ $admin->email }}</span>
                                        </td>
                                        <td>
                                            <span class="item-phone text-reset">{{ $admin->phone }}</span>
                                        </td>
                                        {{--                                        <td>--}}
                                        {{--                                            <span class="item-score badge text-bg-danger-subtle">{{ $admin->is_admin == 1 ? 'Active' : 'Inactive' }}</span>--}}
                                        {{--                                        </td>--}}
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
                                        <button id="bulk-delete-btn" data-url="{{ route('face-id-admin.bulkDelete') }}" class="btn btn-sm bg-danger text-white">
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


    @extends('pages.face-id-admins.face-id-admin.modal')

@endsection
