<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.ico">
    <title>
        @stack('title')
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />

    @yield('css')
</head>

<body class="bg-gray-100 g-sidenav-show">
    <aside class="my-2 bg-white sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="top-0 p-3 cursor-pointer fas fa-times text-dark opacity-5 position-absolute end-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="px-4 ms-0 pxpy-3 navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/img/logos/mw-logo-blue-dark.png') }}" class="navbar-brand-img" width="100% "
                    height="auto" alt="main_logo">
                {{-- <span class="text-sm ms-1 text-dark">Creative Tim</span> --}}
            </a>
        </div>
        <hr class="mt-0 mb-2 horizontal dark">
        <div class="w-auto h-auto collapse navbar-collapse" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="mt-0 mb-2 nav-item">
                    <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-dark"
                        aria-controls="ProfileNav" role="button" aria-expanded="false">
                        <img src="../../assets/img/admin_profile.jpg" class="avatar">
                        @php
                            $admin = Auth::guard('admin')->user();
                            $fullName = $admin->fname . ' ' . $admin->lname;
                        @endphp
                        <span class="nav-link-text ms-2 ps-1">{{ $fullName }}</span>
                    </a>
                    <div class="collapse" id="ProfileNav" style="">
                        <ul class="nav ">
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="{{ route('profile') }}">
                                    <span class="sidenav-mini-icon"> MP </span>
                                    <span class="sidenav-normal ms-3 ps-1"> My Profile </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark " href="../../pages/pages/account/settings.html">
                                    <span class="sidenav-mini-icon"> S </span>
                                    <span class="sidenav-normal ms-3 ps-1"> Settings </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark " href="{{ route('logout') }}">
                                    <span class="sidenav-mini-icon"> L </span>
                                    <span class="sidenav-normal ms-3 ps-1"> Logout </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <hr class="mt-0 horizontal dark">
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#dashboardsExamples" class="nav-link text-dark active"
                        aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                        <i class="material-symbols-rounded opacity-5">space_dashboard</i>
                        <span class="nav-link-text ms-1 ps-1">Dashboards</span>
                    </a>
                    <div class="collapse show " id="dashboardsExamples">
                        <ul class="nav ">
                            <li class="nav-item active">
                                <a class="nav-link text-dark active" href="{{ route('dashboard') }}">
                                    <span class="sidenav-mini-icon"> A </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Statistics </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/dashboards/discover.html">
                                    <span class="sidenav-mini-icon"> D </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Charts </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/dashboards/sales.html">
                                    <span class="sidenav-mini-icon"> S </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Server Status </span>
                                </a>
                            </li>
                            {{-- <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/dashboards/automotive.html">
                                    <span class="sidenav-mini-icon"> A </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Automotive </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/dashboards/smart-home.html">
                                    <span class="sidenav-mini-icon"> S </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Smart Home </span>
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </li>
                <li class="mt-3 nav-item">
                    <h6 class="text-xs ps-3 ms-2 text-uppercase font-weight-bolder text-dark">PAGES</h6>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#pagesExamples" class="nav-link text-dark "
                        aria-controls="pagesExamples" role="button" aria-expanded="false">
                        <i
                            class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">contract</i>
                        <span class="nav-link-text ms-1 ps-1">Pages</span>
                    </a>
                    <div class="collapse " id="pagesExamples">
                        <ul class="nav ">
                            <li class="nav-item ">
                                <a class="nav-link text-dark " data-bs-toggle="collapse" aria-expanded="false"
                                    href="#vrExamples">
                                    <span class="sidenav-mini-icon"> V </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Virtual Reality <b
                                            class="caret"></b></span>
                                </a>
                                <div class="collapse " id="vrExamples">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/pages/vr/vr-default.html">
                                                <span class="sidenav-mini-icon"> V </span>
                                                <span class="sidenav-normal ms-1 ps-1"> VR Default </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark " href="../../pages/pages/vr/vr-info.html">
                                                <span class="sidenav-mini-icon"> V </span>
                                                <span class="sidenav-normal ms-1 ps-1"> VR Info </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/pages/pricing-page.html">
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Pricing Page </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/pages/rtl-page.html">
                                    <span class="sidenav-mini-icon"> R </span>
                                    <span class="sidenav-normal ms-1 ps-1"> RTL </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/pages/widgets.html">
                                    <span class="sidenav-mini-icon"> W </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Widgets </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/pages/charts.html">
                                    <span class="sidenav-mini-icon"> C </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Charts </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/pages/sweet-alerts.html">
                                    <span class="sidenav-mini-icon"> S </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Sweet Alerts </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/pages/notifications.html">
                                    <span class="sidenav-mini-icon"> N </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Notifications </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#accountExamples" class="nav-link text-dark "
                        aria-controls="accountExamples" role="button" aria-expanded="false">
                        <i
                            class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">account_circle</i>
                        <span class="nav-link-text ms-1 ps-1">Account</span>
                    </a>
                    <div class="collapse " id="accountExamples">
                        <ul class="nav ">
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/account/settings.html">
                                    <span class="sidenav-mini-icon"> S </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Settings </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/account/billing.html">
                                    <span class="sidenav-mini-icon"> B </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Billing </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/account/invoice.html">
                                    <span class="sidenav-mini-icon"> I </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Invoice </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/account/security.html">
                                    <span class="sidenav-mini-icon"> S </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Security </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#applicationsExamples" class="nav-link text-dark "
                        aria-controls="applicationsExamples" role="button" aria-expanded="false">
                        <i
                            class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">apps</i>
                        <span class="nav-link-text ms-1 ps-1">Applications</span>
                    </a>
                    <div class="collapse " id="applicationsExamples">
                        <ul class="nav ">
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/applications/crm.html">
                                    <span class="sidenav-mini-icon"> C </span>
                                    <span class="sidenav-normal ms-1 ps-1"> CRM </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/applications/kanban.html">
                                    <span class="sidenav-mini-icon"> K </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Kanban </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/applications/wizard.html">
                                    <span class="sidenav-mini-icon"> W </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Wizard </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/applications/datatables.html">
                                    <span class="sidenav-mini-icon"> D </span>
                                    <span class="sidenav-normal ms-1 ps-1"> DataTables </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/applications/calendar.html">
                                    <span class="sidenav-mini-icon"> C </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Calendar </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/applications/stats.html">
                                    <span class="sidenav-mini-icon"> S </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Stats </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/applications/validation.html">
                                    <span class="sidenav-mini-icon"> V </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Validation </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#ecommerceExamples" class="nav-link text-dark "
                        aria-controls="ecommerceExamples" role="button" aria-expanded="false">
                        <i
                            class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">storefront</i>
                        <span class="nav-link-text ms-1 ps-1">Ecommerce</span>
                    </a>
                    <div class="collapse " id="ecommerceExamples">
                        <ul class="nav ">
                            <li class="nav-item ">
                                <a class="nav-link text-dark " data-bs-toggle="collapse" aria-expanded="false"
                                    href="#productsExample">
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Products <b class="caret"></b></span>
                                </a>
                                <div class="collapse " id="productsExample">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/ecommerce/products/new-product.html">
                                                <span class="sidenav-mini-icon"> N </span>
                                                <span class="sidenav-normal ms-1 ps-1"> New Product </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/ecommerce/products/edit-product.html">
                                                <span class="sidenav-mini-icon"> E </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Edit Product </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/ecommerce/products/product-page.html">
                                                <span class="sidenav-mini-icon"> P </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Product Page </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/ecommerce/products/products-list.html">
                                                <span class="sidenav-mini-icon"> P </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Products List </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " data-bs-toggle="collapse" aria-expanded="false"
                                    href="#ordersExample">
                                    <span class="sidenav-mini-icon"> O </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Orders <b class="caret"></b></span>
                                </a>
                                <div class="collapse " id="ordersExample">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/ecommerce/orders/list.html">
                                                <span class="sidenav-mini-icon"> O </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Order List </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/ecommerce/orders/details.html">
                                                <span class="sidenav-mini-icon"> O </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Order Details </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/ecommerce/referral.html">
                                    <span class="sidenav-mini-icon"> R </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Referral </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#profileExamples" class="nav-link text-dark "
                        aria-controls="profileExamples" role="button" aria-expanded="false">
                        <i
                            class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">group</i>
                        <span class="nav-link-text ms-1 ps-1">Team</span>
                    </a>
                    <div class="collapse " id="profileExamples">
                        <ul class="nav ">
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/team/all-projects.html">
                                    <span class="sidenav-mini-icon"> A </span>
                                    <span class="sidenav-normal ms-1 ps-1"> All Projects </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/team/messages.html">
                                    <span class="sidenav-mini-icon"> M </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Messages </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/team/new-user.html">
                                    <span class="sidenav-mini-icon"> N </span>
                                    <span class="sidenav-normal ms-1 ps-1"> New User </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/team/profile-overview.html">
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Profile Overview </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/team/reports.html">
                                    <span class="sidenav-mini-icon"> R </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Reports </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#projectsExamples" class="nav-link text-dark "
                        aria-controls="projectsExamples" role="button" aria-expanded="false">
                        <i
                            class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">widgets</i>
                        <span class="nav-link-text ms-1 ps-1">Projects</span>
                    </a>
                    <div class="collapse " id="projectsExamples">
                        <ul class="nav ">
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/projects/general.html">
                                    <span class="sidenav-mini-icon"> G </span>
                                    <span class="sidenav-normal ms-1 ps-1"> General </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/projects/timeline.html">
                                    <span class="sidenav-mini-icon"> T </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Timeline </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " href="../../pages/projects/new-project.html">
                                    <span class="sidenav-mini-icon"> N </span>
                                    <span class="sidenav-normal ms-1 ps-1"> New Project </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#authExamples" class="nav-link text-dark "
                        aria-controls="authExamples" role="button" aria-expanded="false">
                        <i
                            class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">tv_signin</i>
                        <span class="nav-link-text ms-1 ps-1">Authentication</span>
                    </a>
                    <div class="collapse " id="authExamples">
                        <ul class="nav ">
                            <li class="nav-item ">
                                <a class="nav-link text-dark " data-bs-toggle="collapse" aria-expanded="false"
                                    href="#signinExample">
                                    <span class="sidenav-mini-icon"> S </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Sign In <b class="caret"></b></span>
                                </a>
                                <div class="collapse " id="signinExample">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/signin/basic.html">
                                                <span class="sidenav-mini-icon"> B </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Basic </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/signin/cover.html">
                                                <span class="sidenav-mini-icon"> C </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Cover </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/signin/illustration.html">
                                                <span class="sidenav-mini-icon"> I </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Illustration </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " data-bs-toggle="collapse" aria-expanded="false"
                                    href="#signupExample">
                                    <span class="sidenav-mini-icon"> S </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Sign Up <b class="caret"></b></span>
                                </a>
                                <div class="collapse " id="signupExample">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/signup/basic.html">
                                                <span class="sidenav-mini-icon"> B </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Basic </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/signup/cover.html">
                                                <span class="sidenav-mini-icon"> C </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Cover </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/signup/illustration.html">
                                                <span class="sidenav-mini-icon"> I </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Illustration </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " data-bs-toggle="collapse" aria-expanded="false"
                                    href="#resetExample">
                                    <span class="sidenav-mini-icon"> R </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Reset Password <b
                                            class="caret"></b></span>
                                </a>
                                <div class="collapse " id="resetExample">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/reset/basic.html">
                                                <span class="sidenav-mini-icon"> B </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Basic </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/reset/cover.html">
                                                <span class="sidenav-mini-icon"> C </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Cover </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/reset/illustration.html">
                                                <span class="sidenav-mini-icon"> I </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Illustration </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " data-bs-toggle="collapse" aria-expanded="false"
                                    href="#lockExample">
                                    <span class="sidenav-mini-icon"> L </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Lock <b class="caret"></b></span>
                                </a>
                                <div class="collapse " id="lockExample">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/lock/basic.html">
                                                <span class="sidenav-mini-icon"> B </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Basic </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/lock/cover.html">
                                                <span class="sidenav-mini-icon"> C </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Cover </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/lock/illustration.html">
                                                <span class="sidenav-mini-icon"> I </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Illustration </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " data-bs-toggle="collapse" aria-expanded="false"
                                    href="#StepExample">
                                    <span class="sidenav-mini-icon"> 2 </span>
                                    <span class="sidenav-normal ms-1 ps-1"> 2-Step Verification <b
                                            class="caret"></b></span>
                                </a>
                                <div class="collapse " id="StepExample">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/verification/basic.html">
                                                <span class="sidenav-mini-icon"> B </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Basic </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/verification/cover.html">
                                                <span class="sidenav-mini-icon"> C </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Cover </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/verification/illustration.html">
                                                <span class="sidenav-mini-icon"> I </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Illustration </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " data-bs-toggle="collapse" aria-expanded="false"
                                    href="#errorExample">
                                    <span class="sidenav-mini-icon"> E </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Error <b class="caret"></b></span>
                                </a>
                                <div class="collapse " id="errorExample">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/error/404.html">
                                                <span class="sidenav-mini-icon"> E </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Error 404 </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="../../pages/authentication/error/500.html">
                                                <span class="sidenav-mini-icon"> E </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Error 500 </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <hr class="horizontal dark" />
                    <h6 class="text-xs ps-3 ms-2 text-uppercase font-weight-bolder text-dark">DOCS</h6>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#basicExamples" class="nav-link text-dark "
                        aria-controls="basicExamples" role="button" aria-expanded="false">
                        <i
                            class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">upcoming</i>
                        <span class="nav-link-text ms-1 ps-1">Basic</span>
                    </a>
                    <div class="collapse " id="basicExamples">
                        <ul class="nav ">
                            <li class="nav-item ">
                                <a class="nav-link text-dark " data-bs-toggle="collapse" aria-expanded="false"
                                    href="#gettingStartedExample">
                                    <span class="sidenav-mini-icon"> G </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Getting Started <b
                                            class="caret"></b></span>
                                </a>
                                <div class="collapse " id="gettingStartedExample">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="https://www.creative-tim.com/learning-lab/bootstrap/quick-start/material-dashboard"
                                                target="_blank">
                                                <span class="sidenav-mini-icon"> Q </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Quick Start </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="https://www.creative-tim.com/learning-lab/bootstrap/license/material-dashboard"
                                                target="_blank">
                                                <span class="sidenav-mini-icon"> L </span>
                                                <span class="sidenav-normal ms-1 ps-1"> License </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard"
                                                target="_blank">
                                                <span class="sidenav-mini-icon"> C </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Contents </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="https://www.creative-tim.com/learning-lab/bootstrap/build-tools/material-dashboard"
                                                target="_blank">
                                                <span class="sidenav-mini-icon"> B </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Build Tools </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark " data-bs-toggle="collapse" aria-expanded="false"
                                    href="#foundationExample">
                                    <span class="sidenav-mini-icon"> F </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Foundation <b class="caret"></b></span>
                                </a>
                                <div class="collapse " id="foundationExample">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="https://www.creative-tim.com/learning-lab/bootstrap/colors/material-dashboard"
                                                target="_blank">
                                                <span class="sidenav-mini-icon"> C </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Colors </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="https://www.creative-tim.com/learning-lab/bootstrap/grid/material-dashboard"
                                                target="_blank">
                                                <span class="sidenav-mini-icon"> G </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Grid </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="https://www.creative-tim.com/learning-lab/bootstrap/typography/material-dashboard"
                                                target="_blank">
                                                <span class="sidenav-mini-icon"> T </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Typography </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark "
                                                href="https://www.creative-tim.com/learning-lab/bootstrap/icons/material-dashboard"
                                                target="_blank">
                                                <span class="sidenav-mini-icon"> I </span>
                                                <span class="sidenav-normal ms-1 ps-1"> Icons </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#componentsExamples" class="nav-link text-dark "
                        aria-controls="componentsExamples" role="button" aria-expanded="false">
                        <i
                            class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">view_in_ar</i>
                        <span class="nav-link-text ms-1 ps-1">Components</span>
                    </a>
                    <div class="collapse " id="componentsExamples">
                        <ul class="nav ">
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/alerts/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> A </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Alerts </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/badge/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> B </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Badge </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/buttons/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> B </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Buttons </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/cards/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> C </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Card </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/carousel/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> C </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Carousel </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/collapse/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> C </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Collapse </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/dropdowns/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> D </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Dropdowns </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/forms/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> F </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Forms </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/modal/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> M </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Modal </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/navs/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> N </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Navs </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/navbar/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> N </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Navbar </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/pagination/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Pagination </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/popovers/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Popovers </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/progress/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Progress </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/spinners/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> S </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Spinners </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/tables/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> T </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Tables </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-dark "
                                    href="https://www.creative-tim.com/learning-lab/bootstrap/tooltips/material-dashboard"
                                    target="_blank">
                                    <span class="sidenav-mini-icon"> T </span>
                                    <span class="sidenav-normal ms-1 ps-1"> Tooltips </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark"
                        href="https://github.com/creativetimofficial/ct-material-dashboard-pro/blob/master/CHANGELOG.md"
                        target="_blank">
                        <i
                            class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">receipt_long</i>
                        <span class="nav-link-text ms-1 ps-1">Changelog</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    @yield('main')

    <div class="fixed-plugin">
        <a class="px-3 py-2 fixed-plugin-button text-dark position-fixed">
            <i class="py-2 material-symbols-rounded">settings</i>
        </a>
        <div class="shadow-lg card">
            <div class="pt-3 pb-0 card-header">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Music Worx</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="mt-4 float-end">
                    <button class="p-0 btn btn-link text-dark fixed-plugin-close-button">
                        <i class="material-symbols-rounded">clear</i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="my-1 horizontal dark">
            <div class="pt-0 card-body pt-sm-3">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="my-2 badge-colors text-start">
                        <span class="badge filter bg-gradient-primary" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark active" data-color="dark"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between different sidenav types.</p>
                </div>
                <div class="d-flex">
                    <button class="px-3 mb-2 btn bg-gradient-dark" data-class="bg-gradient-dark"
                        onclick="sidebarType(this)">Dark</button>
                    <button class="px-3 mb-2 btn bg-gradient-dark ms-2" data-class="bg-transparent"
                        onclick="sidebarType(this)">Transparent</button>
                    <button class="px-3 mb-2 btn bg-gradient-dark active ms-2" data-class="bg-white"
                        onclick="sidebarType(this)">White</button>
                </div>
                <p class="mt-2 text-sm d-xl-none d-block">You can change the sidenav type just on desktop view.</p>
                <!-- Navbar Fixed -->
                <div class="mt-3 d-flex">
                    <h6 class="mb-0">Navbar Fixed</h6>
                    <div class="my-auto form-check form-switch ps-0 ms-auto">
                        <input class="mt-1 form-check-input ms-auto" type="checkbox" id="navbarFixed"
                            onclick="navbarFixed(this)">
                    </div>
                </div>
                <hr class="my-3 horizontal dark">
                <div class="mt-2 d-flex">
                    <h6 class="mb-0">Sidenav Mini</h6>
                    <div class="my-auto form-check form-switch ps-0 ms-auto">
                        <input class="mt-1 form-check-input ms-auto" type="checkbox" id="navbarMinimize"
                            onclick="navbarMinimize(this)">
                    </div>
                </div>
                <hr class="my-3 horizontal dark">
                <div class="mt-2 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="my-auto form-check form-switch ps-0 ms-auto">
                        <input class="mt-1 form-check-input ms-auto" type="checkbox" id="dark-version"
                            onclick="darkMode(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-sm-4">
                {{-- <a class="btn bg-gradient-primary w-100"
                    href="https://www.creative-tim.com/product/material-dashboard-pro">Buy now</a>
                <a class="btn bg-gradient-info w-100"
                    href="https://www.creative-tim.com/product/material-dashboard">Free demo</a>
                <a class="btn btn-outline-dark w-100"
                    href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View
                    documentation</a>
                <div class="text-center w-100">
                    <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard"
                        data-icon="octicon-star" data-size="large" data-show-count="true"
                        aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
                    <h6 class="mt-3">Thank you for sharing!</h6>
                    <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20PRO%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard-pro"
                        class="mb-0 btn btn-dark me-2" target="_blank">
                        <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard-pro"
                        class="mb-0 btn btn-dark me-2" target="_blank">
                        <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
                    </a>
                </div> --}}
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="../../assets/js/core/popper.min.js"></script>
    <script src="../../assets/js/core/bootstrap.min.js"></script>
    <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <!-- Kanban scripts -->
    <script src="../../assets/js/plugins/dragula/dragula.min.js"></script>
    <script src="../../assets/js/plugins/jkanban/jkanban.min.js"></script>
    <script src="../../assets/js/plugins/chartjs.min.js"></script>
    <script src="../../assets/js/plugins/world.js"></script>
    <script>
        var ctx = document.getElementById("chart-bars").getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["M", "T", "W", "T", "F", "S", "S"],
                datasets: [{
                    label: "Sales",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: "#43A047",
                    data: [50, 45, 22, 28, 50, 60, 76],
                    barThickness: 'flex'
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: '#e5e5e5'
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 10,
                            font: {
                                size: 14,
                                lineHeight: 2
                            },
                            color: "#737373"
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#737373',
                            padding: 10,
                            font: {
                                size: 14,
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });


        var ctx2 = document.getElementById("chart-line").getContext("2d");

        new Chart(ctx2, {
            type: "line",
            data: {
                labels: ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: "#43A047",
                    pointBorderColor: "transparent",
                    borderColor: "#43A047",
                    backgroundColor: "transparent",
                    fill: true,
                    data: [120, 230, 130, 440, 250, 360, 270, 180, 90, 300, 310, 220],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                const fullMonths = ["January", "February", "March", "April", "May", "June",
                                    "July", "August", "September", "October", "November", "December"
                                ];
                                return fullMonths[context[0].dataIndex];
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [4, 4],
                            color: '#e5e5e5'
                        },
                        ticks: {
                            display: true,
                            color: '#737373',
                            padding: 10,
                            font: {
                                size: 12,
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#737373',
                            padding: 10,
                            font: {
                                size: 12,
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

        new Chart(ctx3, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: "#43A047",
                    pointBorderColor: "transparent",
                    borderColor: "#43A047",
                    backgroundColor: "transparent",
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [4, 4],
                            color: '#e5e5e5'
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#737373',
                            font: {
                                size: 14,
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [4, 4]
                        },
                        ticks: {
                            display: true,
                            color: '#737373',
                            padding: 10,
                            font: {
                                size: 14,
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        // Initialize the vector map
        var map = new jsVectorMap({
            selector: "#map",
            map: "world_merc",
            zoomOnScroll: false,
            zoomButtons: false,
            selectedMarkers: [1, 3],
            markersSelectable: true,
            markers: [{
                    name: "USA",
                    coords: [40.71296415909766, -74.00437720027804]
                },
                {
                    name: "Germany",
                    coords: [51.17661451970939, 10.97947735117339]
                },
                {
                    name: "Brazil",
                    coords: [-7.596735421549542, -54.781694323779185]
                },
                {
                    name: "Russia",
                    coords: [62.318222797104276, 89.81564777631716]
                },
                {
                    name: "China",
                    coords: [22.320178999475512, 114.17161225541399],
                    style: {
                        fill: '#4CAF50'
                    }
                }
            ],
            markerStyle: {
                initial: {
                    fill: "#333333"
                },
                hover: {
                    fill: "#333333"
                },
                selected: {
                    fill: "#333333"
                }
            },


        });
    </script>
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
    <script src="../../assets/js/material-dashboard.min.js?v=3.1.0"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @yield('script')
</body>

</html>
