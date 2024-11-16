<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign In | Extras</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="Thu, 19 Nov 1900 08:52:00 GMT">
    <!--Loading bootstrap css-->
    <link type="text/css"
        href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,700,300">

    <link type="text/css" rel="stylesheet"
        href="{{ asset('static/admin/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('static/admin/vendors/bootstrap/css/bootstrap.min.css') }}">
    <!--Loading style vendors-->
    <link type="text/css" rel="stylesheet" href="{{ asset('static/admin/vendors/animate.css/animate.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('static/admin/vendors/iCheck/skins/all.css') }}">
    <!--Loading style-->
    <link type="text/css" rel="stylesheet"
        href="{{ asset('static/admin/css/themes/style1/pink-blue.css" class="default-style') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('static/admin/css/themes/style1/pink-blue.css') }}"
        id="theme-change" class="style-change color-change">
    <link type="text/css" rel="stylesheet" href="{{ asset('static/admin/css/style-responsive.css') }}">
    <link rel="shortcut icon" href="https://prostg.music-worx.com/static/admin/images/favicon.ico">
</head>

<body id="signin-page">
    <div class="page-form">
        <form class="border rounded form P-4" method="post" action="{{ route('login') }}"
            style="width: 400px;height: 300px;">
            @csrf
            <div class="header-content">
                <h1><img src="{{ asset('static/admin/images/logo/mw-logo-blue-dark.png') }}" alt="Music Worx" /></h1>
                <h1>Log In</h1>
            </div>
            <div class="p-4 body-content">
                @if ($errors->any())
                    <div class="mb-2 text-danger">{{ $errors->first('data') }}</div>
                @endif
                <div class="mb-3 form-group">
                    <div class="input-icon right"><i class="fa fa-user"></i>
                        <input type="text" placeholder="Username" name="username" class="form-control" required>
                    </div>

                </div>
                <div class="mb-4 form-group">
                    <div class="input-icon right"><i class="fa fa-key"></i>
                        <input type="password" placeholder="Password" name="password" class="form-control" required>
                    </div>
                   
                </div>
                <div class=" form-group pull-left">
                    <div class="checkbox-list"><label><input type="checkbox" name="remember">&nbsp; Keep me signed
                            in</label></div>
                </div>
                <div class="form-group pull-right">
                    <button type="submit" class="btn btn-success btn-lg" name="submit">Log In &nbsp;<i
                            class="fa fa-chevron-circle-right"></i></button>
                </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('static/admin/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('static/admin/js/jquery-migrate-1.2.1.min.js') }}"></script>
    <script src="{{ asset('static/admin/js/jquery-ui.js') }}"></script>
    <!--loading bootstrap js-->
    <script src="{{ asset('static/admin/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('static/admin/vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js') }}"></script>
    <script src="{{ asset('static/admin/js/html5shiv.js') }}"></script>
    <script src="{{ asset('static/admin/js/respond.min.js') }}"></script>
    <script src="{{ asset('static/admin/vendors/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('static/admin/vendors/iCheck/custom.min.js') }}"></script>
    <script>
        //BEGIN CHECKBOX & RADIO
        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_minimal-grey',
            increaseArea: '20%'
        });
    </script>
</body>

</html>
