@push('title')
    Admin | Emails Info
@endpush
@extends('admin.layouts.applayouts')
@section('css')
    <style>
        tbody {
            font-size: 13px;
        }

        .dataTable-wrapper .dataTable-bottom .dataTable-pagination .dataTable-pagination-list .active a {
            background-image: linear-gradient(195deg, #262626 0%, #1F7D88 100%);
        }

        .dataTable-wrapper .dataTable-bottom .dataTable-pagination .dataTable-pagination-list .active a:hover {
            background-image: linear-gradient(195deg, #262626 0%, #1F7D88 100%);
        }

        .dataTable-table th a {
            text-decoration: none;
            color: inherit;
            margin-left: 20px;
        }
    </style>
    {{-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css"> --}}
@endsection

@section('main')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg " id="main">
        <!-- Navbar -->
        <nav class="px-0 py-1 mx-3 mt-2 shadow-none navbar navbar-main navbar-expand-lg position-sticky top-1 border-radius-lg z-index-sticky"
            id="navbarBlur" data-scroll="true">
            <div class="px-2 py-1 container-fluid">
                <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none ">
                    <a href="javascript:;" class="p-0 nav-link text-body">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </div>
                <nav aria-label="breadcrumb" class="ps-2">
                    <ol class="p-0 mb-0 bg-transparent breadcrumb">
                        <li class="text-sm breadcrumb-item"><a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                        </li>
                        <li class="text-sm breadcrumb-item text-dark active font-weight-bold" aria-current="page">Emails
                        </li>
                    </ol>
                </nav>
                <div class="mt-2 collapse navbar-collapse mt-sm-0 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        {{-- <div class="input-group input-group-outline">
                            <label class="form-label">Search here</label>
                            <input type="text" class="form-control">
                        </div> --}}
                    </div>
                    <ul class="navbar-nav justify-content-end">
                        {{-- <li class="nav-item">
                            <a href="../../pages/authentication/signin/illustration.html"
                                class="px-1 py-0 nav-link line-height-0" target="_blank">
                                <i class="material-symbols-rounded">
                                    account_circle
                                </i>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="javascript:;" class="px-1 py-0 nav-link line-height-0">
                                <i class="material-symbols-rounded fixed-plugin-button-nav">
                                    settings
                                </i>
                            </a>
                        </li>
                        {{-- <li class="py-0 nav-item dropdown pe-3">
                            <a href="javascript:;" class="px-1 py-0 nav-link position-relative line-height-0"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="material-symbols-rounded">
                                    notifications
                                </i>
                                <span
                                    class="px-2 py-1 border border-white position-absolute top-5 start-100 translate-middle badge rounded-pill bg-danger small">
                                    <span class="small">11</span>
                                    <span class="visually-hidden">unread notifications</span>
                                </span>
                            </a>
                            <ul class="p-2 dropdown-menu dropdown-menu-end me-sm-n4" aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="py-1 d-flex align-items-center">
                                            <span class="material-symbols-rounded">email</span>
                                            <div class="ms-2">
                                                <h6 class="my-auto text-sm font-weight-normal">
                                                    Check new messages
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="py-1 d-flex align-items-center">
                                            <span class="material-symbols-rounded">podcasts</span>
                                            <div class="ms-2">
                                                <h6 class="my-auto text-sm font-weight-normal">
                                                    Manage podcast session
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="py-1 d-flex align-items-center">
                                            <span class="material-symbols-rounded">shopping_cart</span>
                                            <div class="ms-2">
                                                <h6 class="my-auto text-sm font-weight-normal">
                                                    Payment successfully completed
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="p-0 nav-link text-body" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        {{-- datatable --}}
        @php
            $serviceMap = [
                1 => 'AWS',
                2 => 'GetResponse',
                3 => 'NetZone',
                4 => 'SendMail',
            ];

            // $serverMap = [
            //     1 => 'MW',
            //     2 => 'MW-Process',
            // ];

            $siteMap = [
                1 => 'Pro',
                2 => 'Open',
                3 => 'Admin',
            ];

            $viewMap = [
                1 => 'View',
                2 => 'https://prostg.music-worx.com/admin/usermanager/index',
                3 => 'https://prostg.music-worx.com/admin/usermanager/index',
                36 => 'https://prostg.music-worx.com/admin/usermanager/index',
            ];

        @endphp

        <div class="mx-auto mt-2 mb-3 container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Card header -->
                        {{-- <div class="mb-0 card-header">
                             <h5 class="mb-0">Email List</h5>
                        </div> --}}
                        <div class="mt-0 card-body">
                            <div class="table-responsive">
                                <table class="table table-flush" id="datatable-search">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Subject</th>
                                            <th>Service</th>
                                            <th>Sent From</th>
                                            <th>Server</th>
                                            <th>Site</th>
                                            <th>Summary</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($emails as $index => $email)
                                            <tr>
                                                <td class="text-wrap">{{ $email->name }}</td>
                                                <td class="text-wrap">{{ $email->subject }}</td>
                                                <td class="text-wrap">{{ $serviceMap[$email->service] }}</td>
                                                <td class="text-wrap">{{ $email->sent_from_email }}</td>
                                                <td class="text-wrap">
                                                    {{ $email->sent_from_server == 1 ? 'MW' : 'MW-Process' }}</td>
                                                {{-- <td class="text-wrap">{{ $serverMap[$email->sent_from_server] }}</td> --}}
                                                {{-- <td class="text-wrap">{{ $email->sent_from_site == 1 ? 'Pro' : 'Open' }} </td> --}}
                                                <td class="text-wrap">{{ $siteMap[$email->sent_from_site] }}</td>
                                                <td class="text-wrap">
                                                    <button type="button" class="btn text-light btn-rounded"
                                                        style="background-color: #1F7D88" data-bs-toggle="tooltip"
                                                        data-bs-placement="left" title="{{ $email->summary }}">
                                                        <i class="fa-solid fa-circle-info"></i>
                                                    </button>
                                                    {{-- <button type="button" class="btn btn-secondary"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Tooltip text">
                                                        Hover me
                                                    </button> --}}

                                                </td>
                                                <td>
                                                        <a href="{{ $viewMap[$index + 1] ?? '#' }}"  target="_blank" class="btn btn-sm text-light" style="background-color:#1F7D88 !important;">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- <div class="mt-0 card-footer">
                            {{ $emails->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script src="../../assets/js/plugins/datatables.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script> --}}
    <script>
        const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
            searchable: true,
            //fixedHeight: true,
            // scrollY: "100%",
            // truncatePager: false,
        });

        function initializeTooltips() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        initializeTooltips();

        dataTableSearch.on('datatable.page', function() {
            initializeTooltips();
        });
    </script>

    {{-- <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script> --}}
@endsection
