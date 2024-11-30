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
                </div>
            </div>
        </div>
        <div class="py-3 my-2 container-fluid">
            <div class="mb-2 row">
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
                        </div>
                    </div>

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
                </div>
            </div>


        </div>
    </main>
@endsection
