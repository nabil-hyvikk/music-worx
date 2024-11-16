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

@push('title')
    Admin | My Profile
@endpush
@extends('admin.layouts.applayouts')
@section('main')
    <main class="main-content max-height-vh-100 h-100">
        <nav class="px-0 mx-3 shadow-none navbar navbar-main navbar-expand-lg border-radius-xl ">
            <div class="px-3 py-1 container-fluid">
                <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none me-auto">
                    <a href="javascript:;" class="p-0 nav-link text-body">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </div>
                <nav aria-label="breadcrumb" class="ps-2">
                    <ol class="p-0 mb-0 bg-transparent breadcrumb me-sm-6 me-5">
                        <li class="text-sm breadcrumb-item"><a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                        </li>
                        <li class="text-sm breadcrumb-item"><a class="opacity-5 text-dark" href="javascript:;">Account</a>
                        </li>
                        <li class="text-sm breadcrumb-item text-dark active font-weight-bold" aria-current="page">My Profile
                        </li>
                    </ol>
                </nav>
                <div class="mt-2 collapse navbar-collapse me-md-0 me-sm-4 mt-sm-0" id="navbar">
                    <ul class="navbar-nav justify-content-end ms-auto">
                        <li class="nav-item d-xl-none ps-3 pe-0 d-flex align-items-center">
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
        <div class="mt-2 container-fluid">
            <div class="row align-items-start flex-column">
                <div class="col-lg-5 ms-3 col-sm-8">
                    <h3 class="mb-0 h4 font-weight-bolder">My Profile</h3>
                    {{-- <p class="mb-4">
                        Check the sales, value and bounce rate by country.
                    </p> --}}
                </div>
                {{-- <div class="col-lg-4 col-sm-8">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="p-1 nav nav-pills nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="px-0 py-1 mb-0 nav-link active " data-bs-toggle="tab"
                                    href="../../examples/pages/account/settings.html" role="tab" aria-selected="true">
                                    Messages
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="px-0 py-1 mb-0 nav-link " data-bs-toggle="tab"
                                    href="../../examples/pages/account/billing.html" role="tab" aria-selected="false">
                                    Social
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="px-0 py-1 mb-0 nav-link " data-bs-toggle="tab"
                                    href="../../examples/pages/account/invoice.html" role="tab" aria-selected="false">
                                    Notifications
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="px-0 py-1 mb-0 nav-link " data-bs-toggle="tab"
                                    href="../../examples/pages/account/security.html" role="tab" aria-selected="false">
                                    Backup
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="py-3 my-2 container-fluid">
            <div class="mb-2 row">
                {{-- <div class="col-lg-3">
                    <div class="card position-sticky top-1">
                        <ul class="p-3 bg-white nav flex-column border-radius-lg">
                            <li class="nav-item">
                                <a class="nav-link text-dark d-flex" data-scroll="" href="#profile">
                                    <i class="text-lg material-symbols-rounded me-2">person</i>
                                    <span class="text-sm">Profile</span>
                                </a>
                            </li>
                            <li class="pt-2 nav-item">
                                <a class="nav-link text-dark d-flex" data-scroll="" href="#basic-info">
                                    <i class="text-lg material-symbols-rounded me-2">receipt_long</i>
                                    <span class="text-sm">Basic Info</span>
                                </a>
                            </li>
                            <li class="pt-2 nav-item">
                                <a class="nav-link text-dark d-flex" data-scroll="" href="#password">
                                    <i class="text-lg material-symbols-rounded me-2">lock</i>
                                    <span class="text-sm">Change Password</span>
                                </a>
                            </li>
                            <li class="pt-2 nav-item">
                                <a class="nav-link text-dark d-flex" data-scroll="" href="#2fa">
                                    <i class="text-lg material-symbols-rounded me-2">security</i>
                                    <span class="text-sm">2FA</span>
                                </a>
                            </li>
                            <li class="pt-2 nav-item">
                                <a class="nav-link text-dark d-flex" data-scroll="" href="#accounts">
                                    <i class="text-lg material-symbols-rounded me-2">badge</i>
                                    <span class="text-sm">Accounts</span>
                                </a>
                            </li>
                            <li class="pt-2 nav-item">
                                <a class="nav-link text-dark d-flex" data-scroll="" href="#notifications">
                                    <i class="text-lg material-symbols-rounded me-2">campaign</i>
                                    <span class="text-sm">Notifications</span>
                                </a>
                            </li>
                            <li class="pt-2 nav-item">
                                <a class="nav-link text-dark d-flex" data-scroll="" href="#sessions">
                                    <i class="text-lg material-symbols-rounded me-2">settings_applications</i>
                                    <span class="text-sm">Sessions</span>
                                </a>
                            </li>
                            <li class="pt-2 nav-item">
                                <a class="nav-link text-dark d-flex" data-scroll="" href="#delete">
                                    <i class="text-lg material-symbols-rounded me-2">delete</i>
                                    <span class="text-sm">Delete Account</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> --}}
                <div class="mt-4 col-lg-12 mt-lg-0">
                    <!-- Card Profile -->
                    <div class="card card-body" id="profile">
                        <div class="row align-items-center">
                            <div class="col-sm-auto col-4">
                                <div class="avatar avatar-xl position-relative">
                                    <img src="../../assets/img/admin_profile.jpg" alt="bruce"
                                        class="shadow-sm w-100 rounded-circle">
                                </div>
                            </div>
                            <div class="my-auto col-sm-auto col-8">
                                <div class="h-100">
                                    <h5 class="mb-1 font-weight-bolder">
                                        {{ $admin->fname . ' ' . $admin->lname }}
                                    </h5>
                                    <p class="mb-0 text-sm font-weight-normal">
                                        {{ $admin->role == 'mainadmin' ? 'Main Admin' : '' }}
                                        {{ $admin->role == 'regional_partner' ? 'Regional Partner' : '' }}
                                        {{ $admin->role == 'reviewer' ? 'Reviewer' : '' }}
                                    </p>
                                </div>
                            </div>
                            {{-- <div class="mt-3 col-sm-auto ms-sm-auto mt-sm-0 d-flex">
                                <label class="mb-0 form-check-label">
                                    <small id="profileVisibility">
                                        Switch to invisible
                                    </small>
                                </label>
                                <div class="my-auto form-check form-switch ms-2">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault23" checked
                                        onchange="visible()">
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <!-- Card Basic Info -->
                    {{-- <div class="mt-4 card" id="basic-info">
                        <div class="card-header">
                            <h5>Basic Info</h5>
                        </div>
                        <div class="pt-0 card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group input-group-static">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" placeholder="Alec">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-static">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" placeholder="Thompson">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-6">
                                    <label class="mt-4 form-label ms-0">I'm</label>
                                    <select class="form-control" name="choices-gender" id="choices-gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-5 col-5">
                                            <label class="mt-4 form-label ms-0">Birth Date</label>
                                            <select class="form-control" name="choices-month"
                                                id="choices-month"></select>
                                        </div>
                                        <div class="col-sm-4 col-3">
                                            <label class="mt-4 form-label ms-0">&nbsp;</label>
                                            <select class="form-control" name="choices-day" id="choices-day"></select>
                                        </div>
                                        <div class="col-sm-3 col-4">
                                            <label class="mt-4 form-label">&nbsp;</label>
                                            <select class="form-control" name="choices-year" id="choices-year"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 row">
                                <div class="col-6">
                                    <div class="input-group input-group-static">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="example@email.com">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-static">
                                        <label>Confirm Email</label>
                                        <input type="email" class="form-control" placeholder="example@email.com">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 row">
                                <div class="col-6">
                                    <div class="input-group input-group-static">
                                        <label>Your location</label>
                                        <input type="text" class="form-control" placeholder="Sydney, A">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-static">
                                        <label>Phone Number</label>
                                        <input type="number" class="form-control" placeholder="+40 735 631 620">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 align-self-center">
                                    <label class="mt-4 form-label ms-0">Language</label>
                                    <select class="form-control" name="choices-language" id="choices-language">
                                        <option value="English">English</option>
                                        <option value="French">French</option>
                                        <option value="Spanish">Spanish</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="mt-4 form-label">Skills</label>
                                    <input class="form-control" id="choices-skills" type="text"
                                        value="vuejs, angular, react" placeholder="Enter something" />
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Card Change Password -->
                    <div class="mt-4 card" id="password">
                        <div class="card-header">
                            <h5>Change Password</h5>
                        </div>
                        <div class="pt-0 card-body">
                            <form action="{{ route('change_password') }}" method="POST">
                                @csrf
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Current password</label>
                                    <input type="password" class="form-control" name="current_password">
                                </div>
                                @error('current_password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="my-4 input-group input-group-outline">
                                    <label class="form-label">New password</label>
                                    <input type="password" class="form-control" name="new_password">
                                </div>
                                @error('new_password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Confirm New password</label>
                                    <input type="password" class="form-control" name="new_password_confirmation">
                                </div>
                                @error('new_password_confirmation')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <h5 class="mt-5">Password requirements</h5>
                                <p class="mb-2 text-muted">
                                    Please follow this guide for a strong password:
                                </p>
                                <ul class="mb-0 text-muted ps-4 float-start">
                                    <li>
                                        <span class="text-sm">One special characters</span>
                                    </li>
                                    <li>
                                        <span class="text-sm">Min 6 characters</span>
                                    </li>
                                    <li>
                                        <span class="text-sm">One number (2 are recommended)</span>
                                    </li>
                                    <li>
                                        <span class="text-sm">Change it often</span>
                                    </li>
                                </ul>
                                <button type="submit" class="mt-6 mb-0 btn bg-gradient-dark btn-sm float-end">Update
                                    password</button>
                            </form>
                        </div>
                    </div>
                    <!-- Card Change Password -->
                    {{-- <div class="mt-4 card" id="2fa">
                        <div class="card-header d-flex">
                            <h5 class="mb-0">Two-factor authentication</h5>
                            <span class="mb-auto badge badge-success ms-auto">Enabled</span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="my-auto">Security keys</p>
                                <p class="my-auto text-sm text-secondary ms-auto me-3">No Security Keys</p>
                                <button class="mb-0 btn btn-sm btn-outline-dark" type="button">Add</button>
                            </div>
                            <hr class="horizontal dark">
                            <div class="d-flex">
                                <p class="my-auto">SMS number</p>
                                <p class="my-auto text-sm text-secondary ms-auto me-3">+4012374423</p>
                                <button class="mb-0 btn btn-sm btn-outline-dark" type="button">Edit</button>
                            </div>
                            <hr class="horizontal dark">
                            <div class="d-flex">
                                <p class="my-auto">Authenticator app</p>
                                <p class="my-auto text-sm text-secondary ms-auto me-3">Not Configured</p>
                                <button class="mb-0 btn btn-sm btn-outline-dark" type="button">Set up</button>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Card Accounts -->
                    {{-- <div class="mt-4 card" id="accounts">
                        <div class="card-header">
                            <h5>Accounts</h5>
                            <p class="text-sm">Here you can setup and manage your integration settings.</p>
                        </div>
                        <div class="pt-0 card-body">
                            <div class="d-flex">
                                <img class="width-48-px" src="../../assets/img/small-logos/logo-slack.svg"
                                    alt="logo_slack">
                                <div class="my-auto ms-3">
                                    <div class="h-100">
                                        <h5 class="mb-0">Slack</h5>
                                        <a class="text-sm text-body" href="javascript:;">Show less <i
                                                class="text-xs fas fa-chevron-up ms-1" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <p class="my-auto text-sm text-secondary ms-auto me-3">Enabled</p>
                                <div class="my-auto form-check form-switch">
                                    <input class="form-check-input" checked type="checkbox" id="flexSwitchCheckDefault1">
                                </div>
                            </div>
                            <div class="pt-3 ps-5 ms-3">
                                <p class="mb-0 text-sm">You haven't added your Slack yet or you aren't authorized. Please
                                    add our Slack Bot to your account by clicking on <a href="javascript">here</a>. When
                                    you've added the bot, send your verification code that you have received.</p>
                                <div class="p-2 my-4 bg-gray-100 d-sm-flex border-radius-lg">
                                    <p class="my-auto text-sm font-weight-bold ps-sm-2">Verification Code</p>
                                    <input class="w-40 mt-2 form-control form-control-sm ms-sm-auto mt-sm-0 w-sm-15"
                                        type="text" value="1172913" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Copy!">
                                </div>
                                <div class="p-2 my-4 bg-gray-100 d-sm-flex border-radius-lg">
                                    <p class="my-auto text-sm font-weight-bold ps-sm-2">Connected account</p>
                                    <h6 class="my-auto text-sm ms-auto me-3">hello@creative-tim.com</h6>
                                    <button class="mt-2 mb-0 btn btn-sm bg-gradient-dark my-sm-auto" type="button"
                                        name="button">Delete</button>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <div class="d-flex">
                                <img class="width-48-px" src="../../assets/img/small-logos/logo-spotify.svg"
                                    alt="logo_spotify">
                                <div class="my-auto ms-3">
                                    <div class="h-100">
                                        <h5 class="mb-0">Spotify</h5>
                                        <p class="mb-0 text-sm">Music</p>
                                    </div>
                                </div>
                                <p class="my-auto text-sm text-secondary ms-auto me-3">Enabled</p>
                                <div class="my-auto form-check form-switch">
                                    <input class="form-check-input" checked type="checkbox" id="flexSwitchCheckDefault2">
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <div class="d-flex">
                                <img class="width-48-px" src="../../assets/img/small-logos/logo-atlassian.svg"
                                    alt="logo_atlassian">
                                <div class="my-auto ms-3">
                                    <div class="h-100">
                                        <h5 class="mb-0">Atlassian</h5>
                                        <p class="mb-0 text-sm">Payment vendor</p>
                                    </div>
                                </div>
                                <p class="my-auto text-sm text-secondary ms-auto me-3">Enabled</p>
                                <div class="my-auto form-check form-switch">
                                    <input class="form-check-input" checked type="checkbox" id="flexSwitchCheckDefault3">
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <div class="d-flex">
                                <img class="width-48-px" src="../../assets/img/small-logos/logo-asana.svg"
                                    alt="logo_asana">
                                <div class="my-auto ms-3">
                                    <div class="h-100">
                                        <h5 class="mb-0">Asana</h5>
                                        <p class="mb-0 text-sm">Organize your team</p>
                                    </div>
                                </div>
                                <div class="my-auto form-check form-switch ms-auto">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault4">
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Card Notifications -->
                    {{-- <div class="mt-4 card" id="notifications">
                        <div class="card-header">
                            <h5>Notifications</h5>
                            <p class="text-sm">Choose how you receive notifications. These notification settings apply to
                                the things you’re watching.</p>
                        </div>
                        <div class="pt-0 card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-1" colspan="4">
                                                <p class="mb-0">Activity</p>
                                            </th>
                                            <th class="text-center">
                                                <p class="mb-0">Email</p>
                                            </th>
                                            <th class="text-center">
                                                <p class="mb-0">Push</p>
                                            </th>
                                            <th class="text-center">
                                                <p class="mb-0">SMS</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="ps-1" colspan="4">
                                                <div class="my-auto">
                                                    <span class="text-sm text-dark d-block">Mentions</span>
                                                    <span class="text-xs font-weight-normal">Notify when another user
                                                        mentions you in a comment</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="mb-0 form-check form-switch d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input" checked type="checkbox"
                                                        id="flexSwitchCheckDefault11">
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="mb-0 form-check form-switch d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckDefault12">
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="mb-0 form-check form-switch d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckDefault13">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-1" colspan="4">
                                                <div class="my-auto">
                                                    <span class="text-sm text-dark d-block">Comments</span>
                                                    <span class="text-xs font-weight-normal">Notify when another user
                                                        comments your item.</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="mb-0 form-check form-switch d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input" checked type="checkbox"
                                                        id="flexSwitchCheckDefault14">
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="mb-0 form-check form-switch d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input" checked type="checkbox"
                                                        id="flexSwitchCheckDefault15">
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="mb-0 form-check form-switch d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckDefault16">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-1" colspan="4">
                                                <div class="my-auto">
                                                    <span class="text-sm text-dark d-block">Follows</span>
                                                    <span class="text-xs font-weight-normal">Notify when another user
                                                        follows you.</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="mb-0 form-check form-switch d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckDefault17">
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="mb-0 form-check form-switch d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input" checked type="checkbox"
                                                        id="flexSwitchCheckDefault18">
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="mb-0 form-check form-switch d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckDefault19">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-1" colspan="4">
                                                <div class="my-auto">
                                                    <p class="mb-0 text-sm">Log in from a new device</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="mb-0 form-check form-switch d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input" checked type="checkbox"
                                                        id="flexSwitchCheckDefault20">
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="mb-0 form-check form-switch d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input" checked type="checkbox"
                                                        id="flexSwitchCheckDefault21">
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="mb-0 form-check form-switch d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input" checked type="checkbox"
                                                        id="flexSwitchCheckDefault22">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Card Sessions -->
                    {{-- <div class="mt-4 card" id="sessions">
                        <div class="pb-3 card-header">
                            <h5>Sessions</h5>
                            <p class="text-sm">This is a list of devices that have logged into your account. Remove those
                                that you do not recognize.</p>
                        </div>
                        <div class="pt-0 card-body">
                            <div class="d-flex align-items-center">
                                <div class="w-5 text-center">
                                    <i class="text-lg fas fa-desktop opacity-6"></i>
                                </div>
                                <div class="my-auto ms-3">
                                    <div class="h-100">
                                        <p class="mb-1 text-sm">
                                            Bucharest 68.133.163.201
                                        </p>
                                        <p class="mb-0 text-xs">
                                            Your current session
                                        </p>
                                    </div>
                                </div>
                                <span class="my-auto badge badge-success badge-sm ms-auto me-3">Active</span>
                                <p class="my-auto text-sm text-secondary me-3">EU</p>
                                <a href="javascript:;" class="my-auto text-sm text-primary icon-move-right">See more
                                    <i class="text-xs fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                </a>
                            </div>
                            <hr class="horizontal dark">
                            <div class="d-flex align-items-center">
                                <div class="w-5 text-center">
                                    <i class="text-lg fas fa-desktop opacity-6"></i>
                                </div>
                                <p class="my-auto ms-3">Chrome on macOS</p>
                                <p class="my-auto text-sm text-secondary ms-auto me-3">US</p>
                                <a href="javascript:;" class="my-auto text-sm text-primary icon-move-right">See more
                                    <i class="text-xs fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                </a>
                            </div>
                            <hr class="horizontal dark">
                            <div class="d-flex align-items-center">
                                <div class="w-5 text-center">
                                    <i class="text-lg fas fa-mobile opacity-6"></i>
                                </div>
                                <p class="my-auto ms-3">Safari on iPhone</p>
                                <p class="my-auto text-sm text-secondary ms-auto me-3">US</p>
                                <a href="javascript:;" class="my-auto text-sm text-primary icon-move-right">See more
                                    <i class="text-xs fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Card Delete Account -->
                    {{-- <div class="mt-4 card" id="delete">
                        <div class="card-body">
                            <div class="mb-4 d-flex align-items-center mb-sm-0">
                                <div class="w-50">
                                    <h5>Delete Account</h5>
                                    <p class="mb-0 text-sm">Once you delete your account, there is no going back. Please be
                                        certain.</p>
                                </div>
                                <div class="w-50 text-end">
                                    <button class="mb-3 btn btn-outline-secondary mb-md-0 ms-auto" type="button"
                                        name="button">Deactivate</button>
                                    <button class="mb-0 btn bg-gradient-danger ms-2" type="button" name="button">Delete
                                        Account</button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            {{-- <footer class="py-4 footer" style="margin-bottom:0 !important;">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="mb-4 col-lg-12 mb-lg-0">
                            <div class="text-sm text-center copyright text-muted text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>
                                <a href="https://prostg.music-worx.com/" class="font-weight-bold" target="_blank">μ Music
                                    Worx</a>
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
