<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../../assets/img/favicon.ico">
    <title>
        Admin | Sign in
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="../../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../../../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
</head>

<body>
    <!-- Navbar -->
    <nav
        class="top-0 my-3 mt-4 shadow-none navbar navbar-expand-lg position-absolute z-index-3 w-100 navbar-transparent">
        <div class="container">
            <a class="text-white navbar-brand font-weight-bolder ms-lg-0 ms-3"
                href="../../../pages/dashboards/analytics.html">
                <img src="{{ asset('assets/img/logos/mw-logo-blue-light.png') }}" />
            </a>
        </div>
    </nav>
    <!-- End Navbar -->

    <main class="mt-0 main-content">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('{{ asset('assets/img/banner.jpg') }}');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="mx-auto col-lg-4 col-md-8 col-12">
                        <div class="card z-index-0">
                            <div class="p-0 mx-3 card-header position-relative mt-n4 z-index-2">
                                <div class="py-3 border-radius-lg pe-1" style="background-color: #1F7D88;">
                                    <h4 class="mt-2 mb-0 text-center text-white font-weight-bolder">Sign in</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form role="form" class="text-start" method="post" action="{{ route('login') }}">
                                    @csrf
                                    <div class="my-3 input-group input-group-outline">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                    @error('username')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="mb-3 input-group input-group-outline">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                    <div class="mb-3 form-check form-switch d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                                        <label class="mb-0 form-check-label ms-3" for="rememberMe"
                                            name="remember">Remember me</label>
                                    </div>
                                    @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    @if (session('msg'))
                                        <p class="text-danger">{{ session('msg') }}</p>
                                    @endif
                                    <div class="text-center">
                                        <button type="submit" class="my-4 mb-2 text-white btn w-100"
                                            style="background-color: #1F7D88;">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{-- @endsection --}}

    <!-- Core JS Files -->
    <script src="../../../assets/js/core/popper.min.js"></script>
    <script src="../../../assets/js/core/bootstrap.min.js"></script>
    <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>

    <!-- Kanban scripts -->
    <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
    <script src="../../../assets/js/plugins/jkanban/jkanban.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../../../assets/js/material-dashboard.min.js?v=3.1.0"></script>
</body>

</html>
