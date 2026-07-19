<!DOCTYPE html>

<html lang="id" class="material-style layout-fixed">

<head>
    <title>Sistem Informasi KSP Pekali 99</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <meta name="description"
        content="Sistem Informasi Koperasi Simpan Pinjam Pekali 99 untuk mengelola data nasabah, pinjaman, angsuran, dan laporan koperasi secara digital.">
    <meta name="keywords"
        content="KSP Pekali 99, koperasi simpan pinjam, sistem informasi koperasi, nasabah, pinjaman, angsuran, laporan koperasi">
    <meta name="author" content="KSP Pekali 99">

    <meta property="og:title" content="Sistem Informasi KSP Pekali 99">
    <meta property="og:description"
        content="Sistem Informasi Koperasi Simpan Pinjam Pekali 99 untuk mengelola data nasabah, pinjaman, angsuran, dan laporan koperasi secara digital.">
    <meta property="og:url" content="https://ksppekali99.web.id">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="KSP Pekali 99">
    <meta property="og:image" content="{{ asset('assets/img/logo-koperasi.png') }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo-koperasi.png') }}">

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <!-- Icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/open-iconic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/pe-icon-7-stroke.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">

    <!-- Core stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/shreerang-material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/uikit.css') }}">

    <!-- Libs -->
    <link rel="stylesheet" href="{{ asset('assets/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/flot/flot.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
</head>

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    @php
        $role = auth()->user()->role;
    @endphp

    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">

            <!-- [ Layout sidenav ] Start -->
            <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-white logo-dark">

                <div class="app-brand demo">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('assets/img/logo-koperasi.png') }}" alt="Logo KSP Pekali 99"
                            class="img-fluid" style="width: 45px" height="30px">
                    </span>

                    <a href="{{ route('dashboard.index') }}"
                        class="app-brand-text demo sidenav-text font-weight-normal ml-2">
                        <b>KSP PEKALI 99</b>
                    </a>

                    <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
                        <i class="ion ion-md-menu align-middle"></i>
                    </a>
                </div>

                <div class="sidenav-divider mt-0"></div>

                <!-- Links -->
                <ul class="sidenav-inner py-1">

                    <li class="sidenav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.index') }}" class="sidenav-link">
                            <i class="sidenav-icon feather icon-home"></i>
                            <div>Dashboard</div>
                        </a>
                    </li>

                    <li class="sidenav-divider mb-1"></li>
                    <li class="sidenav-header small font-weight-semibold">Menu</li>

                    @if (in_array($role, ['admin', 'petugas', 'pimpinan']))
                        <li class="sidenav-item {{ request()->routeIs('nasabah.index') ? 'active' : '' }}">
                            <a href="{{ route('nasabah.index') }}" class="sidenav-link">
                                <i class="sidenav-icon feather icon-users"></i>
                                <div>Nasabah</div>
                            </a>
                        </li>
                    @endif

                    @if (in_array($role, ['admin', 'petugas', 'pimpinan']))
                        <li class="sidenav-item {{ request()->routeIs('pinjaman.index') ? 'active' : '' }}">
                            <a href="{{ route('pinjaman.index') }}" class="sidenav-link">
                                <i class="sidenav-icon feather icon-credit-card"></i>
                                <div>Pinjaman</div>
                            </a>
                        </li>
                    @endif

                    @if (in_array($role, ['admin', 'petugas', 'pimpinan']))
                        <li class="sidenav-item {{ request()->routeIs('angsuran.index') ? 'active' : '' }}">
                            <a href="{{ route('angsuran.index') }}" class="sidenav-link">
                                <i class="sidenav-icon feather icon-file-text"></i>
                                <div>Angsuran</div>
                            </a>
                        </li>
                    @endif

                    @if ($role == 'admin')
                        <li class="sidenav-item {{ request()->routeIs('aturan-pinjaman.index') ? 'active' : '' }}">
                            <a href="{{ route('aturan-pinjaman.index') }}" class="sidenav-link">
                                <i class="sidenav-icon feather icon-clipboard"></i>
                                <div>Aturan Pinjaman</div>
                            </a>
                        </li>
                    @endif

                    @if (in_array($role, ['admin', 'pimpinan']))
                        <li class="sidenav-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                            <a href="{{ route('laporan.index') }}" class="sidenav-link">
                                <i class="sidenav-icon feather icon-bar-chart-2"></i>
                                <div>Laporan</div>
                            </a>
                        </li>
                    @endif

                    <li class="sidenav-divider mb-1"></li>
                    <li class="sidenav-header small font-weight-semibold">Pengaturan</li>

                    @if ($role == 'admin')
                        <li class="sidenav-item {{ request()->routeIs('pengguna.index') ? 'active' : '' }}">
                            <a href="{{ route('pengguna.index') }}" class="sidenav-link">
                                <i class="sidenav-icon feather icon-user-plus"></i>
                                <div>Pengguna</div>
                            </a>
                        </li>
                    @endif

                    <li class="sidenav-item {{ request()->routeIs('pengguna.profil') ? 'active' : '' }}">
                        <a href="{{ route('pengguna.profil') }}" class="sidenav-link">
                            <i class="sidenav-icon feather icon-user"></i>
                            <div>Profil</div>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- [ Layout sidenav ] End -->

            <!-- [ Layout container ] Start -->
            <div class="layout-container">

                <!-- [ Layout navbar ] Start -->
                <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-dark container-p-x"
                    id="layout-navbar">

                    <a href="{{ route('dashboard.index') }}" class="navbar-brand app-brand demo d-lg-none py-0 mr-4">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('assets/img/logo-koperasi.png') }}" alt="Logo KSP Pekali 99"
                                class="img-fluid" style="width: 45px" height="30px">
                        </span>
                        <span class="app-brand-text demo font-weight-normal ml-2">KSP PEKALI 99</span>
                    </a>

                    <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto">
                        <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:">
                            <i class="ion ion-md-menu text-large align-middle"></i>
                        </a>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#layout-navbar-collapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-collapse collapse" id="layout-navbar-collapse">
                        <hr class="d-lg-none w-100 my-2">

                        <div class="navbar-nav align-items-lg-center">
                            <label class="nav-item navbar-text navbar-search-box p-0 active">
                                <i class="feather icon-search navbar-icon align-middle"></i>
                                <span class="navbar-search-input pl-2">
                                    <input type="text" class="form-control navbar-text mx-2"
                                        placeholder="Cari data...">
                                </span>
                            </label>
                        </div>

                        <div class="navbar-nav align-items-lg-center ml-auto">
                            <div
                                class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">
                                |
                            </div>

                            <div class="demo-navbar-user nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                        <img src="{{ asset('user/' . Auth::user()->foto) }}" alt="Foto Pengguna"
                                            class="d-block ui-w-30 rounded-circle">

                                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0">
                                            {{ Auth::user()->name }}
                                        </span>
                                    </span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ route('pengguna.profil') }}" class="dropdown-item">
                                        <i class="feather icon-user text-muted"></i> &nbsp; Profil Saya
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="feather icon-power"></i> &nbsp; Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- [ Layout navbar ] End -->

                <!-- [ Layout content ] Start -->
                <div class="layout-content">

                    @yield('content')

                    <!-- [ Layout footer ] Start -->
                    <nav class="layout-footer footer bg-white">
                        <div
                            class="container-fluid d-flex flex-wrap justify-content-between align-items-center text-center container-p-x pb-3">
                            <div class="pt-3">
                                <span class="footer-text font-weight-semibold">
                                    &copy; {{ date('Y') }} KSP Pekali 99. Seluruh hak cipta dilindungi.
                                </span>
                            </div>

                            <div class="pt-3">
                                <span class="footer-text text-muted">
                                    Sistem Informasi Koperasi Simpan Pinjam
                                </span>
                            </div>
                        </div>
                    </nav>
                    <!-- [ Layout footer ] End -->

                </div>
                <!-- [ Layout content ] End -->

            </div>
            <!-- [ Layout container ] End -->
        </div>

        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper ] End -->

    <!-- Core scripts -->
    <script src="{{ asset('assets/js/pace.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/sidenav.js') }}"></script>
    <script src="{{ asset('assets/js/layout-helpers.js') }}"></script>
    <script src="{{ asset('assets/js/material-ripple.js') }}"></script>

    <!-- Libs -->
    <script src="{{ asset('assets/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/libs/eve/eve.js') }}"></script>
    <script src="{{ asset('assets/libs/flot/flot.js') }}"></script>
    <script src="{{ asset('assets/libs/flot/curvedLines.js') }}"></script>
    <script src="{{ asset('assets/libs/chart-am4/core.js') }}"></script>
    <script src="{{ asset('assets/libs/chart-am4/charts.js') }}"></script>
    <script src="{{ asset('assets/libs/chart-am4/animated.js') }}"></script>

    <!-- Demo -->
    <script src="{{ asset('assets/js/demo.js') }}"></script>
    <script src="{{ asset('assets/js/analytics.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboards_index.js') }}"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#example").DataTable();
        });
    </script>

    @yield('scripts')
</body>

</html>