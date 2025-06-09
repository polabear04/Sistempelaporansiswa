<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sispes</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/css/vendor.bundle.base.css') }}">

    <!-- Plugin CSS for datatables -->
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/js/select.dataTables.min.css') }}">

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/vertical-layout-light/style.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('dashboard/images/favicon.png') }}" />
</head>


<body>
    <div class="container-scroller">

        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="{{ URL::to('/index') }}"><img
                        src="dashboard/images/sispes_final.svg" class="mr-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="{{ URL::to('/index') }}"><img
                        src="dashboard/images/sispes_final.svg" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>

                <ul class="navbar-nav navbar-nav-right">

                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="{{ Auth::user()->foto ? asset('img/' . Auth::user()->foto) : asset('img/profile.png') }}"
                                alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="{{ URL::to('profile') }}">
                                <i class="icon-head text-primary"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ti-power-off text-primary"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>

                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ URL::to('/index') }}">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                                aria-controls="ui-basic">
                                <i class="icon-layout menu-icon"></i>
                                <span class="menu-title">Akun</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-basic">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="{{ URL::to('/akun') }}">Akun
                                            terdaftar</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="{{ URL::to('/akunGuru') }}">Akun
                                            Guru</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="{{ URL::to('/akunMurid') }}">Akun
                                            Murid</a></li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if (in_array(Auth::user()->role, ['guru', 'murid']))
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false"
                                aria-controls="form-elements">
                                <i class="icon-book menu-icon"></i>
                                <span class="menu-title">Pelaporan</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="form-elements">
                                <ul class="nav flex-column sub-menu">
                                    @if (Auth::user()->role == 'murid')
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ URL::to('pengajuan') }}">Pengajuan Laporan</a></li>
                                    @endif

                                    @if (Auth::user()->role == 'guru')
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ URL::to('penerimaan') }}">Penerimaan Laporan</a></li>
                                    @endif

                                    {{-- Semua bisa lihat laporan --}}
                                    <li class="nav-item"><a class="nav-link" href="{{ URL::to('draft') }}">Draft
                                            Laporan</a></li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if (in_array(Auth::user()->role, ['guru', 'murid']))
                        <li class="nav-item">
                            <a class="nav-link" aria-controls="form-elements" href="{{ URL::to('/chats') }}">
                                <i class="icon-mail menu-icon"></i>
                                <span class="menu-title">Chat Room</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false"
                            aria-controls="auth">
                            <i class="icon-head menu-icon"></i>
                            <span class="menu-title">User Pages</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="auth">
                            <ul class="nav flex-column sub-menu">
                                @if (in_array(Auth::user()->role, ['guru', 'murid']))
                                    <li class="nav-item"> <a class="nav-link"
                                            href="{{ URL::to('profile') }}">Profile</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>

                    </li>
                </ul>
        </div>
        </li>
        </ul>

        </nav>
