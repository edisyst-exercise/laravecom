
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('pageTitle')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="front/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="front/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="front/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="front/css/style.css" rel="stylesheet">


    @livewireStyles
    @stack('stylesheets')
</head>

<body>
<!-- Header Start -->
@include('front.layout.inc.header')
<!-- Header End -->

<!-- Hero Start -->
{{--@include('front.layout.inc.hero')--}}
<!-- Hero End -->


@yield('content')


<!-- Featurs Section Start -->
{{--@include('front.layout.inc.featurs')--}}
<!-- Featurs Section End -->


<!-- Fruits Shop Start-->
{{--@include('front.layout.inc.fruits-shop')--}}
<!-- Fruits Shop End-->


<!-- Service Start -->
{{--@include('front.layout.inc.service')--}}
<!-- Service End -->


<!-- Vesitable Shop Start-->
{{--@include('front.layout.inc.vesitable')--}}
<!-- Vesitable Shop End -->


<!-- Banner Section Start-->
{{--@include('front.layout.inc.banner')--}}
<!-- Banner Section End -->


<!-- Bestsaler Product Start -->
{{--@include('front.layout.inc.bestsaler')--}}
<!-- Bestsaler Product End -->


<!-- Fact Start -->
{{--@include('front.layout.inc.fact')--}}
<!-- Fact Start -->


<!-- Tastimonial Start -->
{{--@include('front.layout.inc.tastimonial')--}}
<!-- Tastimonial End -->


@include('front.layout.inc.footer')



<!-- Back to Top -->
<a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="front/lib/easing/easing.min.js"></script>
<script src="front/lib/waypoints/waypoints.min.js"></script>
<script src="front/lib/lightbox/js/lightbox.min.js"></script>
<script src="front/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="front/js/main.js"></script>


@livewireScripts
@stack('scripts')
</body>

</html>
