<div data-bs-theme="">
    <nav class="navbar navbar-vertical fixed-start navbar-expand-md" id="sidebar">
        <div class="container-fluid">

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Brand -->
            <a class="navbar-brand" href="index.html">
                <img src="assets/img/logo.svg" class="navbar-brand-img mx-auto" alt="...">
            </a>

            <!-- User (xs) -->
            <div class="navbar-user d-md-none">

                <!-- Dropdown -->
                <div class="dropdown">

                    <!-- Toggle -->
                    <a href="index.html#" id="sidebarIcon" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-sm avatar-online">
                            <img src="assets/img/avatars/profiles/avatar-1.jpg" class="avatar-img rounded-circle" alt="...">
                        </div>
                    </a>

                    <!-- Menu -->
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarIcon">
                        <a href="profile-posts.html" class="dropdown-item">Profile</a>
                        <a href="account-general.html" class="dropdown-item">Settings</a>
                        <hr class="dropdown-divider">
                        <a href="sign-in.html" class="dropdown-item">Logout</a>
                    </div>

                </div>

            </div>

            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidebarCollapse">

                <!-- Form -->
                <form class="mt-4 mb-3 d-md-none">
                    <div class="input-group input-group-rounded input-group-merge input-group-reverse">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-text">
                            <span class="fe fe-search"></span>
                        </div>
                    </div>
                </form>
                <!-- Divider -->
                <hr class="navbar-divider my-3">

                <!-- Navigation -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ url('/dashboard') }}" class="nav-link active">
                            <i class="fe fe-home"></i>   Default
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/user') }}" class="nav-link ">
                            <i class="fe fe-home"></i> Project Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/candidate') }}" class="nav-link ">
                            <i class="fe fe-home"></i>  E-Commerce
                        </a>
                    </li>
                </ul>




                <!-- Navigation -->
                <ul class="navbar-nav mb-md-4">

                </ul>

                <!-- Push content down -->
                <div class="mt-auto"></div>

                <!-- Customize -->
                <div class="mb-4" id="popoverDemo" title="Make Dashkit Your Own!" data-bs-content="Switch the demo to Dark Mode or adjust the navigation layout, icons, and colors!">
                    <a class="btn w-100 btn-primary" data-bs-toggle="offcanvas" href="index.html#offcanvasDemo" aria-controls="offcanvasDemo">
                        <i class="fe fe-sliders me-2"></i> Customize
                    </a>
                </div>
                <div id="popoverDemoContainer" data-bs-theme="dark"></div>

                <!-- User (md) -->
                <div class="navbar-user d-none d-md-flex" id="sidebarUser">

                    <!-- Icon -->
                    <a class="navbar-user-link" data-bs-toggle="offcanvas" href="index.html#sidebarOffcanvasActivity" aria-controls="sidebarOffcanvasActivity">
                  <span class="icon">
                    <i class="fe fe-bell"></i>
                  </span>
                    </a>

                    <!-- Dropup -->
                    <div class="dropup">

                        <!-- Toggle -->
                        <a href="index.html#" id="sidebarIconCopy" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-sm avatar-online">
                                <img src="assets/img/avatars/profiles/avatar-1.jpg" class="avatar-img rounded-circle" alt="...">
                            </div>
                        </a>

                        <!-- Menu -->
                        <div class="dropdown-menu" aria-labelledby="sidebarIconCopy">
                            <a href="profile-posts.html" class="dropdown-item">Profile</a>
                            <a href="account-general.html" class="dropdown-item">Settings</a>
                            <hr class="dropdown-divider">
                            <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
                        </div>

                    </div>

                    <!-- Icon -->
                    <a class="navbar-user-link" data-bs-toggle="offcanvas" href="index.html#sidebarOffcanvasSearch" aria-controls="sidebarOffcanvasSearch">
                  <span class="icon">
                    <i class="fe fe-search"></i>
                  </span>
                    </a>

                </div>

            </div> <!-- / .navbar-collapse -->

        </div>
    </nav>
</div>
