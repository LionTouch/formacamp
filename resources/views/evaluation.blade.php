<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="app">

@include('layouts.head')
<body>
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">

         </div>
      </div>
      <section class="sign-in-page" ng-view ng-cloak>

      </section>

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

      <!-- Flatpicker Js -->
      <script src="{{asset('https://cdn.jsdelivr.net/npm/flatpickr') }}"></script>
      <!-- Chart Custom JavaScript -->
      <script src="{{asset('resources/assets/js/chart-custom.js') }}"></script>
      <!-- Custom JavaScript -->
      <script src="{{asset('resources/assets/js/custom.js') }}"></script>

      <script src="{{asset('node_modules/angular-drag-and-drop-lists/angular-drag-and-drop-lists.js')}}"></script>
      <script src="{{asset('resources/assets/pickr/dist/pickr.min.js') }}"></script>


      <script src="{{asset('resources/js/index.js') }}"></script>
      <script src="{{asset_path('Evaluations','js/EvaluationController.js')}}"></script>

</body>

</html>
