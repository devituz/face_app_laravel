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

                    <div class="card" data-list='' id="contactsList">
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
                                    <form>
                                        <select class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": false}'>
                                            <option>5 per page</option>
                                            <option selected>10 per page</option>
                                            <option>All</option>
                                        </select>
                                    </form>

                                </div>
{{--                                <div class="col-auto me-n3">--}}
{{--                                    <!-- Delete Button (Initially Hidden) -->--}}
{{--                                    <button type="submit" class="btn btn-danger" id="bulk-delete-btn" style="display:none;">--}}
{{--                                        Delete Selected--}}
{{--                                    </button>--}}
{{--                                </div>--}}
                            </div>

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
        document.querySelectorAll('.avatar').forEach(function(avatar) {
            avatar.addEventListener('click', function() {
                var imageUrl = avatar.getAttribute('data-image');
                document.getElementById('modalImage').src = imageUrl;
            });
        });

    </script>
    @extends('components.model')
    @extends('pages.face-id-admins.face-id-admin.modal')

@endsection
