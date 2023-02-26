<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Local CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">
    <!-- Bootstrap CSS CDN  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Font Awesome Icons CDN -->
    <link href="<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Box Icons CDN -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Remix Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <title>you need help</title>
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand sidebar-logo text-uppercase fw-bold text-decoration-none text-white fs-4"
                href="">CRUD</a>
            <button aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                class="navbar-toggler" data-bs-target="#navbarNav" data-bs-toggle="collapse" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link text-uppercase text-white" href="#">CRUD</a>
                    </li>
                </ul>
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <div class="input-group">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <span class="input-group-text">
                                <i class="ri-search-line"></i>
                            </span>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="path/to/image.jpg" class="rounded-circle me-2" width="30" height="30" alt="Profile Image"> Raihan </a>
                        <ul class="dropdown-menu dropdown-menu-end p-2">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="ri-user-2-line me-2"></i>My Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="ri-settings-3-line me-2"></i>Settings </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="ri-logout-box-line me-2"></i>Logout </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                {{-- Sidebar --}}
                <div class="sidebar collapsed position-fixed top-0 start-0 bottom-0 border-end">
                    <div class="d-flex align-items-center p-3">
                        <a class="sidebar-logo text-uppercase fw-bold text-decoration-none text-white fs-4"
                            href="">CRUD</a>
                        <div class="sidebar-toggle-wrapper ms-auto">
                            <!-- add a wrapper div around the sidebar toggle -->
                            <i class="sidebar-toggle ri-arrow-left-s-line fs-5"></i>
                        </div>
                    </div>
                    <ul class="sidebar-menu p-3 m-0 mb-0">
                        <li class="sidebar-menu-item active">
                            <a href="#">
                                <i class="ri-dashboard-fill sidebar-menu-item-icon"></i> Dashboard </a>
                        </li>
                        <li class="sidebar-menu-divider mt-3 mb-1 text-uppercase">Custom</li>
                        <li class="sidebar-menu-item has-dropdown">
                            <a href="#">
                                <i class="ri-shield-user-line sidebar-menu-item-icon"></i> Users <i
                                    class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                            </a>
                            <ul class="sidebar-dropdown-menu">
                                <li class="sidebar-dropdown-menu-item alert-button">
                                    <a href="#">
                                        <i class="ri-user-line sidebar-menu-item-icon"></i> User Profile </a>
                                </li>
                                <li class="sidebar-dropdown-menu-item">
                                    <a href="#">
                                        <i class="ri-settings-2-line sidebar-menu-item-icon"></i> User Management </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-menu-item has-dropdown">
                            <a href="#">
                                <i class="ri-shield-user-line sidebar-menu-item-icon"></i> Users <i
                                    class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                            </a>
                            <ul class="sidebar-dropdown-menu">
                                <li class="sidebar-dropdown-menu-item alert-button">
                                    <a href="#">
                                        <i class="ri-user-line sidebar-menu-item-icon"></i> User Profile </a>
                                </li>
                                <li class="sidebar-dropdown-menu-item">
                                    <a href="#">
                                        <i class="ri-settings-2-line sidebar-menu-item-icon"></i> User Management </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-menu-divider mt-3 mb-1 text-uppercase">Pages</li>
                        <li class="sidebar-menu-item">
                            <a href="#">
                                <i class="ri-table-line sidebar-menu-item-icon"></i> Table List </a>
                        </li>
                    </ul>
                </div>
                <!-- End Sidebar -->
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <div class="container-fluid mt-5 pt-3" style="margin-left: 250px;">
        @yield('content')
    </div>

    <!-- JS -->
    <!-- jQuery JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Local JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Bootstrap JS CDN  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <!-- End JS -->
</body>

</html>
