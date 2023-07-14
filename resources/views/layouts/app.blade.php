<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Local CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS CDN  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Remix Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            @role('Administrator')
            <li class="sidebar-menu-divider mt-3 mb-1 text-uppercase">Admin Menu</li>
            <li class="sidebar-menu-item has-dropdown">
                <a href="#">
                    <i class="ri-shield-user-line sidebar-menu-item-icon"></i> Users, Roles & Permissions <i
                        class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                </a>
                <ul class="sidebar-dropdown-menu">
                    <li class="sidebar-dropdown-menu-item">
                        <a href="/admin/users-list">
                            <i class="ri-settings-2-line sidebar-menu-item-icon"></i> User Management
                        </a>
                    </li>
                </ul>
            </li>
            @endrole
            <li class="sidebar-menu-divider mt-3 mb-1 text-uppercase">Pages</li>
            @can('CRUD')
            <li class="sidebar-menu-item has-dropdown">
                <a href="#">
                    <i class="ri-table-fill sidebar-menu-item-icon"></i>
                    Table List
                    <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                </a>
                <ul class="sidebar-dropdown-menu">
                    <li class="sidebar-dropdown-menu-item alert-button">
                        <a href="/tabel/gedung">
                            <i class="ri-building-2-line sidebar-menu-item-icon"></i>Gedung </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="/tabel/sekolah">
                            <i class="ri-community-line sidebar-menu-item-icon"></i> Sekolah </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="/tabel/health">
                            <i class="ri-hospital-line sidebar-menu-item-icon"></i> Health </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="/tabel/kuliner">
                            <i class="ri-restaurant-line sidebar-menu-item-icon"></i> Kuliner </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="/tabel/toko">
                            <i class="ri-store-3-line sidebar-menu-item-icon"></i> Toko </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="/tabel/office">
                            <i class="ri-building-4-line sidebar-menu-item-icon"></i> Office </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="/tabel/buscen">
                            <i class="ri-suitcase-line sidebar-menu-item-icon"></i> BusCen </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="/tabel/tourism">
                            <i class="ri-road-map-line sidebar-menu-item-icon"></i> Tourism </a>
                    </li>

                </ul>
            </li>
            @endcan
        </ul>
        <!-- my profile -->
        <div class="sidebar-footer d-flex justify-content-center align-items-center p-3 ">
            <div class="dropdown pb-4">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (Auth::user()->photo)
                    <img  src="{{ asset(Auth::user()->photo)}}" alt="profile_image" width="30" height="30" class="rounded-circle">
                    @else
                    <img  src="{{ asset('img/defpfp/OIP.jpeg') }}" alt="profile_image" width="30" height="30" class="rounded-circle">
                    @endif
                    <div class="sidebar-logo p-2">
                        <div class="text text-white h5 mb-0">{{ Auth::user()->username }}</div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="/profile">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <form action="{{ url('/logout?nocache=1')}}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item">Log Out</button>
                    </form>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.js" integrity="sha512-LjPH94gotDTvKhoxqvR5xR2Nur8vO5RKelQmG52jlZo7SwI5WLYwDInPn1n8H9tR0zYqTqfNxWszUEy93cHHwg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap JS CDN  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <!-- Local JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Select2 js --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <!-- End JS -->
</body>
</html>
