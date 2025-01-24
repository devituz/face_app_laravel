@extends('layouts.app')


@section('content')


    <!-- MAIN CONTENT -->
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
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMembers">
                                        Add Admin
                                    </button>

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
                    <div class="card"
                         data-list='{"valueNames": ["item-name", "item-title", "item-email", "item-phone", "item-score", "item-company"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}'
                         id="contactsList">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">

                                    <!-- Form -->
                                    <form>
                                        <div
                                            class="input-group input-group-flush input-group-merge input-group-reverse">
                                            <input class="form-control list-search" type="search"
                                                   placeholder="Search">
                                            <span class="input-group-text">
                              <i class="fe fe-search"></i>
                            </span>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-auto me-n3">

                                    <!-- Select -->
                                    <form>
                                        <select class="form-select form-select-sm form-control-flush"
                                                data-choices='{"searchEnabled": false}'>
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
                                            <input class="form-check-input list-checkbox-all"
                                                   id="listCheckboxAll" type="checkbox">
                                            <label class="form-check-label" for="listCheckboxAll"></label>
                                        </div>

                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" data-sort="item-name"
                                           href="crm-contacts.html#">Name</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" data-sort="item-title"
                                           href="crm-contacts.html#">Job title</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" data-sort="item-email"
                                           href="crm-contacts.html#">Email</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" data-sort="item-phone"
                                           href="crm-contacts.html#">Phone</a>
                                    </th>
                                    <th>
                                        <a class="list-sort text-body-secondary" data-sort="item-score"
                                           href="crm-contacts.html#">Lead score</a>
                                    </th>
                                    <th colspan="2">
                                        <a class="list-sort text-body-secondary" data-sort="item-company"
                                           href="crm-contacts.html#">Company</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="list fs-base">
                               @for($i = 0; $i < 1; $i++)
                                   <tr>
                                   <td>

                                       <!-- Checkbox -->
                                       <div class="form-check">
                                           <input class="form-check-input list-checkbox" id="listCheckboxOne"
                                                  type="checkbox">
                                           <label class="form-check-label" for="listCheckboxOne"></label>
                                       </div>

                                   </td>
                                   <td>

                                       <!-- Avatar -->
                                       <div class="avatar avatar-xs align-middle me-2">
                                           <img class="avatar-img rounded-circle"
                                                src="assets/img/avatars/profiles/avatar-1.jpg" alt="...">
                                       </div>
                                       <a class="item-name text-reset" href="profile-posts.html">Dianna
                                           Smiley</a>

                                   </td>
                                   <td>

                                       <!-- Text -->
                                       <span class="item-title">Designer</span>

                                   </td>
                                   <td>

                                       <!-- Email -->
                                       <a class="item-email text-reset" href="mailto:john.doe@company.com">diana.smiley@company.com</a>

                                   </td>
                                   <td>

                                       <!-- Phone -->
                                       <a class="item-phone text-reset" href="tel:1-123-456-4890">(988)
                                           568-3568</a>

                                   </td>
                                   <td>

                                       <!-- Badge -->
                                       <span class="item-score badge text-bg-danger-subtle">1/10</span>

                                   </td>
                                   <td>

                                       <!-- Link -->
                                       <a class="item-company text-reset" href="team-overview.html">Twitter</a>

                                   </td>
                                   <td class="text-end">

                                       <!-- Dropdown -->
                                       <div class="dropdown">
                                           <a class="dropdown-ellipses dropdown-toggle"
                                              href="crm-contacts.html#" role="button" data-bs-toggle="dropdown"
                                              aria-haspopup="true" aria-expanded="false">
                                               <i class="fe fe-more-vertical"></i>
                                           </a>
                                           <div class="dropdown-menu dropdown-menu-end">
                                               <a href="crm-contacts.html#!" class="dropdown-item">
                                                   Action
                                               </a>
                                               <a href="crm-contacts.html#!" class="dropdown-item">
                                                   Another action
                                               </a>
                                               <a href="crm-contacts.html#!" class="dropdown-item">
                                                   Something else here
                                               </a>
                                           </div>
                                       </div>

                                   </td>
                               </tr>
                               @endfor
                                <div class="row">
                                    <div class="col-12" style="width: 200px; visibility: hidden;">
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
                                            <input class="form-check-input" id="listAlertCheckbox"
                                                   type="checkbox" checked disabled>
                                            <label class="form-check-label text-white" for="listAlertCheckbox">
                                                <span class="list-alert-count">0</span> deal(s)
                                            </label>
                                        </div>

                                    </div>
                                    <div class="col-auto me-n3">

                                        <!-- Button -->
                                        <button
                                            class="btn btn-sm bg-white text-white bg-opacity-20 bg-opacity-15-hover">
                                            Edit
                                        </button>

                                        <!-- Button -->
                                        <button
                                            class="btn btn-sm bg-white text-white bg-opacity-20 bg-opacity-15-hover">
                                            Delete
                                        </button>

                                    </div>
                                </div> <!-- / .row -->

                                <!-- Close -->
                                <button type="button" class="list-alert-close btn-close"
                                        aria-label="Close"></button>

                            </div>

                        </div>
                    </div>
                </div>
            </div> <!-- / .row -->
        </div>



    @extends('pages.face-id-admins.face-id-admin.create-modal')

@endsection
