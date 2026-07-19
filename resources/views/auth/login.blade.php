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
        content="KSP Pekali 99, koperasi simpan pinjam, sistem informasi koperasi, pinjaman, angsuran, nasabah, laporan koperasi">
    <meta name="author" content="KSP Pekali 99">

    <meta property="og:title" content="Sistem Informasi KSP Pekali 99">
    <meta property="og:description"
        content="Sistem Informasi Koperasi Simpan Pinjam Pekali 99 untuk mengelola data nasabah, pinjaman, angsuran, dan laporan koperasi secara digital.">
    <meta property="og:url" content="https://ksppekali99.web.id">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="KSP Pekali 99">
    <meta property="og:image" content="{{ asset('assets/img/logo-koperasi.png') }}">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Sistem Informasi KSP Pekali 99">
    <meta name="twitter:description"
        content="Sistem Informasi Koperasi Simpan Pinjam Pekali 99 untuk mengelola data nasabah, pinjaman, angsuran, dan laporan koperasi secara digital.">
    <meta name="twitter:image" content="{{ asset('assets/img/logo-koperasi.png') }}">

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

    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/css/pages/authentication.css') }}">

    <style>
        .login-page {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }

        .login-page::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('assets/img/logo-koperasi.png') }}') no-repeat center;
            background-size: 700px;
            opacity: 0.15;
            z-index: -1;
        }
    </style>
</head>

<body class="login-page">
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ content ] Start -->
    <div class="authentication-wrapper authentication-1 px-4">
        <div class="authentication-inner py-5 bg-dark text-white rounded shadow px-4">

            <!-- [ Logo ] Start -->
            <div class="d-flex justify-content-center align-items-center">
                <div class="ui-w-60">
                    <div class="w-100 position-relative">
                        <img src="{{ asset('assets/img/logo-koperasi.png') }}" alt="Logo KSP Pekali 99" class="img-fluid">
                    </div>
                </div>
            </div>

            <hr style="border-top: 1px solid rgba(255,255,255,0.3);">
            <!-- [ Logo ] End -->

            @include('includes.alerts')

            <!-- [ Form ] Start -->
            <form class="my-4" action="{{ route('login.proses') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control bg-secondary text-white border-0" required>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    <label class="form-label d-flex justify-content-between align-items-end">
                        <span>Password</span>
                    </label>
                    <input type="password" name="password" class="form-control bg-secondary text-white border-0" required>
                    <div class="clearfix"></div>
                </div>

                <div class="d-flex justify-content-between align-items-center m-0">
                    <label class="custom-control custom-checkbox m-0">
                        <input type="checkbox" class="custom-control-input">
                    </label>

                    <button type="submit" class="btn btn-primary btn-sm">
                        Login
                    </button>
                </div>
            </form>
            <!-- [ Form ] End -->

            <div class="text-center text-muted">
                Lupa password? Silakan hubungi admin KSP Pekali 99.
            </div>

        </div>
    </div>
    <!-- [ content ] End -->

    <!-- Core scripts -->
    <script src="{{ asset('assets/js/pace.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/sidenav.js') }}"></script>
    <script src="{{ asset('assets/js/material-ripple.js') }}"></script>

    <!-- Libs -->
    <script src="{{ asset('assets/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <!-- Demo -->
    <script src="{{ asset('assets/js/demo.js') }}"></script>
    <script src="{{ asset('assets/js/analytics.js') }}"></script>
</body>

</html>