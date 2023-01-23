<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="app">

<head>
    <base href="/">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title ng-bind="page_title">FormaCamp</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="resources/assets/images/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="resources/assets/css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="resources/assets/css/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="resources/assets/css/style.css">
    <link rel="stylesheet" href="resources/css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="resources/assets/css/responsive.css">
    <link rel="stylesheet" href="resources/assets/css/style2.css">

    <style>
        .download{
            position: fixed;
            right: 100px;
            top: 50px;
        }
        .print{
            position: fixed;
            right: 100px;
        }
        .k-loading.show{
            display: block;
        }
        .k-loading{
            display: none;
            background: rgba(0, 0, 0, 0.5);
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            background-size: 10%;
            position: fixed;
            overflow: hidden !important;
            z-index: 999999;
        }
        .k-spinner{
            position: absolute;
            left: 50%;
            top: 50%;
        }
        .spinner-border {
            display: inline-block;
            width: 6rem;
            height: 6rem;
            vertical-align: text-bottom;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            -webkit-animation: spinner-border .75s linear infinite;
            animation: spinner-border .75s linear infinite;
        }
        body {
            font-family: "DejaVu Serif";
            font-size: 12px;
        }


        .page-template {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .page-template .header {
            position: absolute;
            top: 30px;
            left: 30px;
            right: 30px;

            border-bottom: 1px solid #888;

            text-align: center;
            font-size: 18px;
        }

        .page-template .footer {
            position: absolute;
            bottom: 30px;
            left: 30px;
            right: 30px;
        }


    </style>

</head>

<body>
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">

         </div>
      </div>
      <!-- loader END -->
      <div class="wrapper">

          <div id="content-page" class="content-page" style="margin-right: 260px">
              <h1> {!! $title !!}</h1>
              <div class="container-fluid" ng-view ng-cloak>

              </div>
          </div>


      </div>

      <script src="{{asset('node_modules/angular/angular.min.js')}}"></script>
      <script src="{{asset('node_modules/angular-cookies/angular-cookies.min.js')}}"></script>
      <script src="{{asset('node_modules/angular-resource/angular-resource.min.js')}}"></script>
      <script src="{{asset('node_modules/ng-idle/angular-idle.js')}}"></script>
      <script src="{{asset('node_modules/angular-route/angular-route.min.js')}}"></script>
      <script src="{{asset('node_modules/angular-animate/angular-animate.min.js')}}"></script>
      <script src="{{asset('node_modules/angular-sanitize/angular-sanitize.min.js')}}"></script>
      <script src="{{asset('node_modules/ng-infinite-scroll/build/ng-infinite-scroll.min.js')}}"></script>
      <script src="{{asset('node_modules/ui-bootstrap4/dist/ui-bootstrap.js')}}"></script>
      <script src="{{asset('node_modules/ui-bootstrap4/dist/ui-bootstrap-tpls.js')}}"></script>
      <script src="{{asset('node_modules/angular-ui-notification/dist/angular-ui-notification.js')}}"></script>
      <script src="{{asset('node_modules/ui-select/dist/select.min.js')}}"></script>
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="{{asset('resources/assets/js/jquery.min.js') }}"></script>
      <script src="{{asset('resources/assets/js/popper.min.js') }}"></script>
      <script src="{{asset('resources/assets/js/bootstrap.min.js') }}"></script>
      <!-- Appear JavaScript -->
      <script src="{{asset('resources/assets/js/jquery.appear.js') }}"></script>
      <!-- Countdown JavaScript -->
      <script src="{{asset('resources/assets/js/countdown.min.js') }}"></script>
      <!-- Counterup JavaScript -->
      <script src="{{asset('resources/assets/js/waypoints.min.js') }}"></script>
      <script src="{{asset('resources/assets/js/jquery.counterup.min.js') }}"></script>
      <!-- Wow JavaScript -->
      <script src="{{asset('resources/assets/js/wow.min.js') }}"></script>
      <!-- Apexcharts JavaScript -->
      <script src="{{asset('resources/assets/js/apexcharts.js') }}"></script>
      <!-- Slick JavaScript -->
      <script src="{{asset('resources/assets/js/slick.min.js') }}"></script>
      <!-- Select2 JavaScript -->
      <script src="{{asset('resources/assets/js/select2.min.js') }}"></script>
      <!-- Owl Carousel JavaScript -->
      <script src="{{asset('resources/assets/js/owl.carousel.min.js') }}"></script>
      <!-- Magnific Popup JavaScript -->
      <script src="{{asset('resources/assets/js/jquery.magnific-popup.min.js') }}"></script>
      <!-- Smooth Scrollbar JavaScript -->
      <script src="{{asset('resources/assets/js/smooth-scrollbar.js') }}"></script>
      <!-- lottie JavaScript -->
      <script src="{{asset('resources/assets/js/lottie.js') }}"></script>
      <!-- am core JavaScript -->
      <script src="{{asset('resources/assets/js/core.js') }}"></script>
      <!-- am charts JavaScript -->
      <script src="{{asset('resources/assets/js/charts.js') }}"></script>
      <!-- am animated JavaScript -->
      <script src="{{asset('resources/assets/js/animated.js') }}"></script>
      <!-- am kelly JavaScript -->
      <script src="{{asset('resources/assets/js/kelly.js') }}"></script>
      <!-- Flatpicker Js -->
      <script src="{{asset('https://cdn.jsdelivr.net/npm/flatpickr') }}"></script>
      <!-- Chart Custom JavaScript -->
      <script src="{{asset('resources/assets/js/chart-custom.js') }}"></script>
      <!-- Custom JavaScript -->
      <script src="{{asset('resources/assets/js/custom.js') }}"></script>
      <!-- ckEditor JavaScript -->
      <script src="{{asset('node_modules/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

      <script src='{{asset('resources/assets/fullcalendar/core/main.min.js')}}'></script>
      <script src='{{asset('resources/assets/fullcalendar/daygrid/main.min.js')}}'></script>
      <script src='{{asset('resources/assets/fullcalendar/timegrid/main.min.js')}}'></script>
      <script src='{{asset('resources/assets/fullcalendar/list/main.min.js')}}'></script>
      <script src='{{asset('resources/assets/fullcalendar/interaction/main.min.js')}}'></script>
      <script src='{{asset('resources/assets/fullcalendar/locales-all.js')}}'></script>

      <script src="{{asset('node_modules/animejs/lib/anime.min.js')}}"></script>
      <script src="{{asset('node_modules/bootstrap-sweetalert/dist/sweetalert.min.js')}}"></script>
      <script src="{{asset('node_modules/inputmask/dist/inputmask.min.js')}}"></script>
      <script src="{{asset('node_modules/moment/min/moment.min.js')}}"></script>
      <script src="{{asset('node_modules/underscore/underscore-min.js')}}"></script>
      <script src="{{asset('node_modules/angular-drag-and-drop-lists/angular-drag-and-drop-lists.js')}}"></script>
      <script src="{{asset('resources/assets/pickr/dist/pickr.min.js') }}"></script>
      <script src="{{asset('resources/js/kendo.all.min.js')}}"></script>



      <script src="{{asset('resources/js/index.js') }}"></script>
      <script src="{{asset_path('SessionsModule','js/DevisController.js')}}"></script>
      <script src="{{asset_path('SessionsModule','js/ContratsController.js')}}"></script>

</body>

</html>
