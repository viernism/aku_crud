<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Local CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS CDN  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Font Awesome Icons CDN -->
    <link href="<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Box Icons CDN -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Remix Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <title>{{ $title ?? 'app-name' }}</title>
</head>

<body>
    <!-- sidebar -->
    <div class="sidebar collapsed position-fixed top-0 start-0 bottom-0 border-end">
        <div class="d-flex align-items-center p-3">
            <a class="sidebar-logo text-uppercase fw-bold text-decoration-none text-white fs-4" href="/home">CRUD</a>
            <div class="sidebar-toggle-wrapper ms-auto">
                <i class="sidebar-toggle ri-arrow-left-s-line fs-5"></i>
            </div>
        </div>
        <ul class="sidebar-menu p-3 m-0 mb-0">
            <li class="sidebar-menu-item">
                <a href="/dashboard">
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
                        <a href="/user-profile">
                            <i class="ri-user-line sidebar-menu-item-icon"></i> User Profile </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="#">
                            <i class="ri-settings-2-line sidebar-menu-item-icon"></i> User Management </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-menu-divider mt-3 mb-1 text-uppercase">Pages</li>
            <li class="sidebar-menu-item has-dropdown">
                <a href="#">
                    <i class="ri-shield-user-line sidebar-menu-item-icon"></i> Table List <i
                        class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                </a>
                <ul class="sidebar-dropdown-menu">
                    <li class="sidebar-dropdown-menu-item alert-button">
                        <a href="/gedung">
                            <i class="ri-building-2-line sidebar-menu-item-icon"></i>Gedung </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="#">
                            <i class="ri-community-line sidebar-menu-item-icon"></i> Sekolah</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- my profile -->
        <div class="sidebar-footer d-flex justify-content-center align-items-center p-3 ">
            <div class="dropdown pb-4">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/af/Tux.png" alt="nobitches"
                        width="30" height="30" class="rounded-circle">
                    <div class="sidebar-logo p-2">
                        <div class="text text-white h5 mb-0">Raihan</div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="/user-profile">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end my profile -->
    <!-- end sidebar -->

    <!-- content -->
    <div class="py-4 ms-5">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- JS Area -->

    <!-- jQuery JS CDN -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous">
    </script>

    <!-- Bootstrap JS CDN  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <!-- Local JS -->
    <script src="{{ asset('js/app.js') }}"></script>


    <!-- End JS -->
</body>
</html>
