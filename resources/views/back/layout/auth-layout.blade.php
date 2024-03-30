<!DOCTYPE html>
<html>
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>@yield('pageTitle')</title>

    <!-- Site favicon -->
    <link
        rel="icon"
        type="image/png"
        sizes="16x16"
        href="/images/site/{{ get_settings()->site_favicon }}"
    />

    <!-- Mobile Specific Metas -->
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1"
    />

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/core.css" />
    <link
        rel="stylesheet"
        type="text/css"
        href="/back/vendors/styles/icon-font.min.css"
    />
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/style.css" />
    <link rel="stylesheet" href="/public/extra-assets/ijabo/ijabo.min.css">

    @livewireStyles
    @stack('stylesheets')
</head>
<body class="login-page">
<div class="login-header box-shadow">
    <div
        class="container-fluid d-flex justify-content-between align-items-center"
    >
        <div class="brand-logo">
            <a href="login.html">
                <img src="/images/site/{{ get_settings()->site_logo }}" alt="" />
            </a>
        </div>
        <div class="login-menu">
            <ul>
                @if(! \Illuminate\Support\Facades\Route::is('admin.*'))
                    <li><a href="register.html">Register</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>
<div
    class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="/back/vendors/images/login-page-img.png" alt="" />
            </div>
            <div class="col-md-6 col-lg-5">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<!-- js -->
<script src="/back/vendors/scripts/core.js"></script>
<script src="/back/vendors/scripts/script.min.js"></script>
<script src="/back/vendors/scripts/process.js"></script>
<script src="/back/vendors/scripts/layout-settings.js"></script>

<script>
    // Per impedire di tornare indietro dalla pagina di login
    if (navigator.userAgent.indexOf("Firefox") != -1) {
        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
            history.pushState(null, null, document.URL);
        });
    }
</script>

<script src="public/extra-assets/ijabo/ijabo.min.js"></script>
<script src="public/extra-assets/ijabo/jquery.ijaboViewer.min.js"></script>
<script>
    window.addEventListener('showToastr', function (event) {
        toastr.remove();
        if (event.detail.type === 'info') {
            toastr.info(event.detail.message);
        } else if (event.detail.type === 'success') {
            toastr.success(event.detail.message);
        } else if (event.detail.type === 'error') {
            toastr.error(event.detail.message);
        } else if (event.detail.type === 'warning') {
            toastr.warning(event.detail.message);
        } else {
            return false;
        }
    });
</script>

@livewireScripts
@stack('scripts')
</body>
</html>
