<!--
=========================================================
* Material Dashboard 2 PRO - v3.1.0
=========================================================

* Product Page:  https://www.creative-tim.com/product/material-dashboard-pro
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->

@extends('admin.layouts.applayouts')
@push('title')
    Admin | Dashboard
@endpush
@section('css')
    <style>

    </style>
@endsection
@section('main')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
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
                        <li class="text-sm breadcrumb-item text-dark active font-weight-bold" aria-current="page">
                            Statistics</li>
                    </ol>
                </nav>
                <div class="mt-2 collapse navbar-collapse mt-sm-0 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group input-group-outline">
                            <label class="form-label">Search here</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item">
                            {{-- <a href="../../pages/authentication/signin/illustration.html"
                            class="px-1 py-0 nav-link line-height-0" target="_blank">
                            <i class="material-symbols-rounded">
                                account_circle
                            </i>
                        </a> --}}
                            {{-- <div class="flex-shrink-0 dropdown">
                                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="https://github.com/mdo.png" alt="mdo" width="25" height="25" class="rounded-circle">
                                    <i class="material-symbols-rounded">account_circle</i>
                                </a>
                                <ul class="shadow dropdown-menu text-small">
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
                                </ul>
                            </div> --}}
                        </li>
                        <li class="nav-item">
                            <a href="javascript:;" class="px-1 py-0 nav-link line-height-0">
                                <i class="material-symbols-rounded fixed-plugin-button-nav">
                                    settings
                                </i>
                            </a>
                        </li>
                        <li class="py-0 nav-item dropdown pe-3">
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
                        </li>
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
        <div class="py-2 container-fluid">
            <div class="row">
                <div class="col-lg-12 position-relative z-index-2">

                    <div class="ms-3 row">
                        <!-- Title Section -->
                        <div class="col-12 col-md-8">
                            <h3 class="mb-0 h4 font-weight-bolder">Statistics</h3>
                            <p class="text-muted">Check the sales, value, and bounce rate by country.</p>
                        </div>

                        <!-- Date Filter Dropdown -->
                        <div class="col-12 col-md-4 text-end">
                            <div class="dropdown">
                                <button class="btn bg-gradient-dark shadow-dark dropdown-toggle" type="button"
                                    id="dateFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    October 24, 2024 - October 30, 2024 Report
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dateFilterDropdown">
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">Yesterday</a></li>
                                    <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">Last Month</a></li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <!-- Custom Range Trigger -->
                                        <a class="dropdown-item custom-range-trigger" href="#"
                                            id="customRangeTrigger">Custom Range</a>

                                        <!-- Custom Range Date Picker -->
                                        <div class="custom-range-dropdown" style="display: none; padding: 10px;">
                                            <div class="mb-2">
                                                <label for="fromDate" class="form-label">From:</label>
                                                <input type="date" class="form-control" id="fromDate"
                                                    value="2024-10-24">
                                            </div>
                                            <div class="mb-2">
                                                <label for="toDate" class="form-label">To:</label>
                                                <input type="date" class="form-control" id="toDate"
                                                    value="2024-10-30">
                                            </div>
                                            <div class="mt-2">
                                                <button class="btn btn-primary me-2" id="applyCustomRange">Apply</button>
                                                <button class="btn btn-secondary" id="cancelCustomRange">Cancel</button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    {{-- <div class="ms-3 row">
                        <h3 class="mb-0 h4 font-weight-bolder col-2">Statistics</h3>
                        <p class="mb-4">
                            Check the sales, value and bounce rate by country.
                        </p>

                        <div class="dropdown float-end col-4">
                            <button class="btn bg-gradient-dark shadow-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                October 24, 2024 - October 30, 2024 report
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">Yesterday</a></li>
                                <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                                <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">Last Month</a></li>
                                <li><a class="dropdown-item" href="#">Custom Range</a></li>
                            </ul>
                        </div>

                        <div class="custom-range" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="fromDate">From:</label>
                                    <input type="date" class="form-control" id="fromDate" value="2024-10-24">
                                </div>
                                <div class="col-md-6">
                                    <label for="toDate">To:</label>
                                    <input type="date" class="form-control" id="toDate" value="2024-10-30">
                                </div>
                            </div>
                            <button class="mt-2 btn btn-primary" id="applyCustomRange">Apply</button>
                            <button class="mt-2 btn btn-secondary" id="cancelCustomRange">Cancel</button>
                        </div>
                    </div> --}}

                    {{-- <div class="row">
                        <div class="mb-4 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="mb-0 ">Website Views</h6>
                                    <p class="text-sm ">Last Campaign Performance</p>
                                    <div class="pe-2">
                                        <div class="chart">
                                            <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                                        </div>
                                    </div>
                                    <hr class="dark horizontal">
                                    <div class="d-flex ">
                                        <i class="my-auto text-sm material-symbols-rounded me-1">schedule</i>
                                        <p class="mb-0 text-sm"> campaign sent 2 days ago </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-4 col-md-6">
                            <div class="card ">
                                <div class="card-body">
                                    <h6 class="mb-0 "> Daily Sales </h6>
                                    <p class="text-sm "> (<span class="font-weight-bolder">+15%</span>) increase in today
                                        sales. </p>
                                    <div class="pe-2">
                                        <div class="chart">
                                            <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                                        </div>
                                    </div>
                                    <hr class="dark horizontal">
                                    <div class="d-flex ">
                                        <i class="my-auto text-sm material-symbols-rounded me-1">schedule</i>
                                        <p class="mb-0 text-sm"> updated 4 min ago </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="mb-0 ">Completed Tasks</h6>
                                    <p class="text-sm ">Last Campaign Performance</p>
                                    <div class="pe-2">
                                        <div class="chart">
                                            <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
                                        </div>
                                    </div>
                                    <hr class="dark horizontal">
                                    <div class="d-flex ">
                                        <i class="my-auto text-sm material-symbols-rounded me-1">schedule</i>
                                        <p class="mb-0 text-sm">just updated</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="mt-2 row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Bookings</p>
                                            <h4 class="mb-0">281</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">weekend</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+55% </span>than
                                        last week</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Today's Users</p>
                                            <h4 class="mb-0">2,300</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">leaderboard</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Revenue</p>
                                            <h4 class="mb-0">$34,000</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">store</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+35% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Followers</p>
                                            <h4 class="mb-0">+2,910</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">person_add</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm">Just updated</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Bookings</p>
                                            <h4 class="mb-0">281</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">weekend</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+55% </span>than
                                        last week</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Today's Users</p>
                                            <h4 class="mb-0">2,300</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">leaderboard</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Revenue</p>
                                            <h4 class="mb-0">$34,000</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">store</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+35% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Followers</p>
                                            <h4 class="mb-0">+2,910</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">person_add</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm">Just updated</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Bookings</p>
                                            <h4 class="mb-0">281</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">weekend</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+55% </span>than
                                        last week</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Today's Users</p>
                                            <h4 class="mb-0">2,300</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">leaderboard</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Revenue</p>
                                            <h4 class="mb-0">$34,000</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">store</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+35% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Followers</p>
                                            <h4 class="mb-0">+2,910</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">person_add</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm">Just updated</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Bookings</p>
                                            <h4 class="mb-0">281</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">weekend</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+55% </span>than
                                        last week</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Today's Users</p>
                                            <h4 class="mb-0">2,300</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">leaderboard</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Revenue</p>
                                            <h4 class="mb-0">$34,000</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">store</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+35% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Followers</p>
                                            <h4 class="mb-0">+2,910</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">person_add</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm">Just updated</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Bookings</p>
                                            <h4 class="mb-0">281</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">weekend</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+55% </span>than
                                        last week</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Today's Users</p>
                                            <h4 class="mb-0">2,300</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">leaderboard</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Revenue</p>
                                            <h4 class="mb-0">$34,000</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">store</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+35% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Followers</p>
                                            <h4 class="mb-0">+2,910</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">person_add</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm">Just updated</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Bookings</p>
                                            <h4 class="mb-0">281</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">weekend</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+55% </span>than
                                        last week</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Today's Users</p>
                                            <h4 class="mb-0">2,300</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">leaderboard</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Revenue</p>
                                            <h4 class="mb-0">$34,000</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">store</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+35% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Followers</p>
                                            <h4 class="mb-0">+2,910</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">person_add</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm">Just updated</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Bookings</p>
                                            <h4 class="mb-0">281</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">weekend</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+55% </span>than
                                        last week</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Today's Users</p>
                                            <h4 class="mb-0">2,300</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">leaderboard</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Revenue</p>
                                            <h4 class="mb-0">$34,000</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">store</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+35% </span>than
                                        last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="mb-2 card">
                                <div class="p-2 card-header ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0 text-sm text-capitalize">Followers</p>
                                            <h4 class="mb-0">+2,910</h4>
                                        </div>
                                        <div
                                            class="text-center shadow icon icon-md icon-shape bg-gradient-dark shadow-dark border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">person_add</i>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="p-2 card-footer ps-3">
                                    <p class="mb-0 text-sm">Just updated</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="mt-3 row">
                        <div class="col-lg-4 col-md-6">
                            <div class="card" data-animation="true">
                                <div class="p-2 bg-transparent card-header position-relative z-index-2">
                                    <a class="d-block blur-shadow-image">
                                        <img src="https://images.unsplash.com/photo-1527547637224-a93d42c7b332?q=80&w=1200&auto=format&fit=crop"
                                            alt="img-blur-shadow" class="shadow img-fluid border-radius-lg">
                                    </a>
                                    <div class="colored-shadow"
                                        style="background-image: url(https://images.unsplash.com/photo-1527547637224-a93d42c7b332?q=80&w=1200&auto=format&fit=crop">
                                    </div>
                                </div>
                                <div class="text-left card-body">
                                    <div class="mx-auto d-flex mt-n6">
                                        <a class="border-0 btn btn-link text-primary ms-auto" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Refresh">
                                            <i class="text-lg material-symbols-rounded">refresh</i>
                                        </a>
                                        <button class="border-0 btn btn-link text-info me-auto" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Edit">
                                            <i class="text-lg material-symbols-rounded">edit</i>
                                        </button>
                                    </div>
                                    <h5 class="mt-3 font-weight-bold">
                                        <a href="javascript:;">Cozy 5 Stars Apartment</a>
                                    </h5>
                                    <p class="mb-0 text-sm">
                                        The place is close to Barceloneta Beach and bus stop just 2 min by walk and near to
                                        "Naviglio" where you can enjoy the main night life in Barcelona.
                                    </p>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="text-lg material-symbols-rounded me-1">place</i>
                                        <p class="my-auto text-sm">Barcelona, Spain</p>
                                    </div>
                                    <p class="my-auto font-weight-bold text-dark">$899/night</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card" data-animation="true">
                                <div class="p-2 bg-transparent card-header position-relative z-index-2">
                                    <a class="d-block blur-shadow-image">
                                        <img src="https://images.unsplash.com/photo-1622485480253-8abe11c61751?q=80&w=1200&auto=format&fit=crop"
                                            alt="img-blur-shadow" class="shadow img-fluid border-radius-lg">
                                    </a>
                                    <div class="colored-shadow"
                                        style="background-image: url('https://images.unsplash.com/photo-1622485480253-8abe11c61751?q=80&w=1200&auto=format&fit=crop');">
                                    </div>
                                </div>
                                <div class="text-left card-body">
                                    <div class="mx-auto d-flex mt-n6">
                                        <a class="border-0 btn btn-link text-primary ms-auto" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Refresh">
                                            <i class="text-lg material-symbols-rounded">refresh</i>
                                        </a>
                                        <button class="border-0 btn btn-link text-info me-auto" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Edit">
                                            <i class="text-lg material-symbols-rounded">edit</i>
                                        </button>
                                    </div>
                                    <h5 class="mt-3 font-weight-bold">
                                        <a href="javascript:;">Tibetan Buddhist Temple</a>
                                    </h5>
                                    <p class="mb-0 text-sm">
                                        Join our unique experience to visit the Tibetan Buddhist Temple in the center of
                                        Bali. You will be guided by a local monk and learn about it.
                                    </p>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="text-lg material-symbols-rounded me-1">place</i>
                                        <p class="my-auto text-sm">Ubud, Bali</p>
                                    </div>
                                    <p class="my-auto font-weight-bold text-dark">$1,119/night</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card" data-animation="true">
                                <div class="p-2 bg-transparent card-header position-relative z-index-2">
                                    <a class="d-block blur-shadow-image">
                                        <img src="https://images.unsplash.com/photo-1527246201253-ce566026066e?q=80&w=1200&auto=format&fit=crop"
                                            alt="img-blur-shadow" class="shadow img-fluid border-radius-lg">
                                    </a>
                                    <div class="colored-shadow"
                                        style="background-image: url(https://images.unsplash.com/photo-1527246201253-ce566026066e?q=80&w=1200&auto=format&fit=crop">
                                    </div>
                                </div>
                                <div class="text-left card-body">
                                    <div class="mx-auto d-flex mt-n6">
                                        <a class="border-0 btn btn-link text-primary ms-auto" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Refresh">
                                            <i class="text-lg material-symbols-rounded">refresh</i>
                                        </a>
                                        <button class="border-0 btn btn-link text-info me-auto" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Edit">
                                            <i class="text-lg material-symbols-rounded">edit</i>
                                        </button>
                                    </div>
                                    <h5 class="mt-3 font-weight-bold">
                                        <a href="javascript:;">Beautiful Castle</a>
                                    </h5>
                                    <p class="mb-0 text-sm">
                                        The place is close to Metro Station and bus stop just 2 min by walk and near to
                                        "Naviglio" where you can enjoy the main night life in Milan.
                                    </p>
                                </div>
                                <hr class="my-0 dark horizontal">
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="text-lg material-symbols-rounded me-1">place</i>
                                        <p class="my-auto text-sm">Milan, Italy</p>
                                    </div>
                                    <p class="my-auto font-weight-bold text-dark">$499/night</p>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="mt-4">
                        <div class="mb-4 card">
                            <div class="pb-0 card-header">
                                <h6 class="mb-0">Sales by Country</h6>
                                <p class="mb-2 text-sm">
                                    Check the sales, value and bounce rate by country.
                                </p>
                            </div>
                            <div class="p-3 card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-7">
                                        <div class="table-responsive">
                                            <table class="table align-items-center">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="p-2 text-sm text-left text-secondary font-weight-normal">
                                                            Country</th>
                                                        <th
                                                            class="p-2 text-sm text-left text-secondary font-weight-normal">
                                                            Sales</th>
                                                        <th
                                                            class="p-2 text-sm text-left text-secondary font-weight-normal">
                                                            Value</th>
                                                        <th
                                                            class="p-2 text-sm text-left text-secondary font-weight-normal">
                                                            Bounce</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="w-30">
                                                            <div class="px-2 py-1 d-flex align-items-center">
                                                                <div>
                                                                    <img src="../../assets/img/icons/flags/US.png"
                                                                        alt="Country flag">
                                                                </div>
                                                                <div class="ms-4">
                                                                    <h6 class="mb-0 text-sm font-weight-normal">United
                                                                        States</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h6 class="mb-0 text-sm font-weight-normal">2500</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="mb-0 text-sm font-weight-normal">$230,900</h6>
                                                        </td>
                                                        <td class="text-sm align-middle">
                                                            <h6 class="mb-0 text-sm font-weight-normal">29.9%</h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-30">
                                                            <div class="px-2 py-1 d-flex align-items-center">
                                                                <div>
                                                                    <img src="../../assets/img/icons/flags/DE.png"
                                                                        alt="Country flag">
                                                                </div>
                                                                <div class="ms-4">
                                                                    <h6 class="mb-0 text-sm font-weight-normal">Germany
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h6 class="mb-0 text-sm font-weight-normal">3.900</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="mb-0 text-sm font-weight-normal">$440,000</h6>
                                                        </td>
                                                        <td class="text-sm align-middle">
                                                            <h6 class="mb-0 text-sm font-weight-normal">40.22%</h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-30">
                                                            <div class="px-2 py-1 d-flex align-items-center">
                                                                <div>
                                                                    <img src="../../assets/img/icons/flags/GB.png"
                                                                        alt="Country flag">
                                                                </div>
                                                                <div class="ms-4">
                                                                    <h6 class="mb-0 text-sm font-weight-normal">Great
                                                                        Britain</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h6 class="mb-0 text-sm font-weight-normal">1.400</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="mb-0 text-sm font-weight-normal">$190,700</h6>
                                                        </td>
                                                        <td class="text-sm align-middle">
                                                            <h6 class="mb-0 text-sm font-weight-normal">23.44%</h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-30">
                                                            <div class="px-2 py-1 d-flex align-items-center">
                                                                <div>
                                                                    <img src="../../assets/img/icons/flags/BR.png"
                                                                        alt="Country flag">
                                                                </div>
                                                                <div class="ms-4">
                                                                    <h6 class="mb-0 text-sm font-weight-normal">Brasil</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h6 class="mb-0 text-sm font-weight-normal">562</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="mb-0 text-sm font-weight-normal">$143,960</h6>
                                                        </td>
                                                        <td class="text-sm align-middle">
                                                            <h6 class="mb-0 text-sm font-weight-normal">32.14%</h6>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-5">
                                        <div id="map" class="mt-0 mt-lg-n4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            {{-- <footer class="py-4 footer ">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="mb-4 col-lg-6 mb-lg-0">
                            <div class="text-sm text-center copyright text-muted text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                made with <i class="fa fa-heart"></i> by
                                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative
                                    Tim</a>
                                for a better web.
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com" class="nav-link text-muted"
                                        target="_blank">Creative Tim</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted"
                                        target="_blank">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/blog" class="nav-link text-muted"
                                        target="_blank">Blog</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                                        target="_blank">License</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer> --}}
        </div>
    </main>
@endsection

@section('script')
    <script>
        // Toggle Custom Range display on dropdown item click
        document.getElementById('customRangeTrigger').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the dropdown from closing
            event.stopPropagation(); // Prevent event bubbling

            // Toggle visibility of the custom range picker
            const customRangeDropdown = document.querySelector('.custom-range-dropdown');
            customRangeDropdown.style.display = customRangeDropdown.style.display === 'block' ? 'none' : 'block';
        });

        // Hide Custom Range on cancel
        document.getElementById('cancelCustomRange').addEventListener('click', function(event) {
            event.preventDefault();
            document.querySelector('.custom-range-dropdown').style.display = 'none';
        });

        // Apply custom date range
        document.getElementById('applyCustomRange').addEventListener('click', function() {
            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;

            // Update button text with selected date range
            document.getElementById('dateFilterDropdown').textContent = `${fromDate} - ${toDate} Report`;

            // Hide custom range dropdown
            document.querySelector('.custom-range-dropdown').style.display = 'none';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdownMenu = document.querySelector('.dropdown-menu');
            const customRangeDropdown = document.querySelector('.custom-range-dropdown');

            if (!dropdownMenu.contains(event.target) && customRangeDropdown.style.display === 'block') {
                customRangeDropdown.style.display = 'none';
            }
        });
    </script>
@endsection
