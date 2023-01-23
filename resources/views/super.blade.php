<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="app">

@include('layouts.head')
<body>
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">

         </div>
      </div>

      <!-- loader END -->
      <!-- Wrapper Start -->
      <div class="wrapper">
         <!-- Sidebar  -->
      @include('layouts.super-sidebar')
    <!-- Page Content  -->
         <div id="content-page" class="content-page">

            <div class="container-fluid" ng-view ng-cloak>

            </div>
         </div>
          <!-- Footer -->
          <footer class="bg-white iq-footer">
              <div class="container-fluid">
                  <div class="row">
                      <div class="col-lg-6">
                          <ul class="list-inline mb-0">
                              <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                              <li class="list-inline-item"><a href="#">Terms of Use</a></li>
                          </ul>
                      </div>
                      <div class="col-lg-6 text-right">
                          Copyright 2021 <a href="#">Formacamp</a> All Rights Reserved.
                      </div>
                  </div>
              </div>
          </footer>
          <!-- Footer END -->
      </div>

      <script src="{{asset('node_modules/angular/angular.min.js')}}"></script>
      <script src="{{asset('node_modules/angular-cookies/angular-cookies.min.js')}}"></script>
      <script src="{{asset('node_modules/angular-resource/angular-resource.min.js')}}"></script>
      <script src="{{asset('node_modules/ng-idle/angular-idle.js')}}"></script>
      <script src="{{asset('node_modules/angular-route/angular-route.min.js')}}"></script>
      <script src="{{asset('node_modules/angular-animate/angular-animate.min.js')}}"></script>
      <script src="{{asset('node_modules/angular-aria/angular-aria.min.js')}}"></script>
      <script src="{{asset('node_modules/angular-messages/angular-messages.min.js')}}"></script>
      <script src="{{asset('node_modules/angular-material/angular-material.min.js')}}"></script>
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
{{--      <script src="{{asset('resources/assets/js/core.js') }}"></script>--}}
{{--      <!-- am charts JavaScript -->--}}
{{--      <script src="{{asset('resources/assets/js/charts.js') }}"></script>--}}
{{--      <!-- am animated JavaScript -->--}}
{{--      <script src="{{asset('resources/assets/js/animated.js') }}"></script>--}}
{{--      <!-- am kelly JavaScript -->--}}
{{--      <script src="{{asset('resources/assets/js/kelly.js') }}"></script>--}}
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
      <script src="{{asset('node_modules/moment/locale/fr.js')}}"></script>
      <script src="{{asset('node_modules/underscore/underscore-min.js')}}"></script>
      <script src="{{asset('node_modules/angular-drag-and-drop-lists/angular-drag-and-drop-lists.js')}}"></script>
      <script src="{{asset('resources/assets/pickr/dist/pickr.min.js') }}"></script>
      <script src="{{asset('resources/js/kendo.all.min.js')}}"></script>


      <script src="{{asset('resources/js/index.js') }}"></script>
      <script src="{{asset('resources/js/SideBarController.js') }}"></script>
      <script src="{{asset('resources/js/NavBarController.js') }}"></script>




      <script src="{{asset_path('DashboardModule','js/DashboardController.js')}}"></script>

</body>

</html>
