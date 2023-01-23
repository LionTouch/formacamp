<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" ng-app="app">

<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body>
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">
				<div class="lds-ripple"><div></div><div></div></div>
         </div>
      </div>

      <!-- loader END -->
      <!-- Wrapper Start -->
      <div class="wrapper">
         <!-- Sidebar  -->
      <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

      <script src="<?php echo e(asset('node_modules/angular/angular.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/angular-cookies/angular-cookies.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/angular-resource/angular-resource.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/ng-idle/angular-idle.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/angular-route/angular-route.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/angular-animate/angular-animate.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/angular-aria/angular-aria.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/angular-sanitize/angular-sanitize.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/angular-messages/angular-messages.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/angular-material/angular-material.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/ng-infinite-scroll/build/ng-infinite-scroll.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/ui-bootstrap4/dist/ui-bootstrap.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/ui-bootstrap4/dist/ui-bootstrap-tpls.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/angular-ui-notification/dist/angular-ui-notification.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/ui-select/dist/select.min.js')); ?>"></script>
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="<?php echo e(asset('resources/assets/js/jquery.min.js')); ?>"></script>
      <script src="<?php echo e(asset('resources/assets/js/popper.min.js')); ?>"></script>
      <script src="<?php echo e(asset('resources/assets/js/bootstrap.min.js')); ?>"></script>
      <!-- Appear JavaScript -->
      <script src="<?php echo e(asset('resources/assets/js/jquery.appear.js')); ?>"></script>
      <!-- Countdown JavaScript -->
      <script src="<?php echo e(asset('resources/assets/js/countdown.min.js')); ?>"></script>
      <!-- Counterup JavaScript -->
      <script src="<?php echo e(asset('resources/assets/js/waypoints.min.js')); ?>"></script>
      <script src="<?php echo e(asset('resources/assets/js/jquery.counterup.min.js')); ?>"></script>
      <!-- Wow JavaScript -->
      <script src="<?php echo e(asset('resources/assets/js/wow.min.js')); ?>"></script>
      <!-- Apexcharts JavaScript -->
      <script src="<?php echo e(asset('resources/assets/js/apexcharts.min.js')); ?>"></script>
      <!-- Slick JavaScript -->
      <script src="<?php echo e(asset('resources/assets/js/slick.min.js')); ?>"></script>
      <!-- Select2 JavaScript -->
      <script src="<?php echo e(asset('resources/assets/js/select2.min.js')); ?>"></script>
      <!-- Owl Carousel JavaScript -->
      <script src="<?php echo e(asset('resources/assets/js/owl.carousel.min.js')); ?>"></script>
      <!-- Magnific Popup JavaScript -->
      <script src="<?php echo e(asset('resources/assets/js/jquery.magnific-popup.min.js')); ?>"></script>
      <!-- Smooth Scrollbar JavaScript -->
      <script src="<?php echo e(asset('resources/assets/js/smooth-scrollbar.js')); ?>"></script>
      <!-- lottie JavaScript -->
      <script src="<?php echo e(asset('resources/assets/js/lottie.min.js')); ?>"></script>
      <!-- Flatpicker Js -->
      <script src="<?php echo e(asset('resources/assets/js/flatpickr.min.js')); ?>"></script>
      <!-- Chart Custom JavaScript -->
      <script src="<?php echo e(asset('resources/assets/js/chart-custom.js')); ?>"></script>
      <!-- Custom JavaScript -->
      <script src="<?php echo e(asset('resources/assets/js/custom.js')); ?>"></script>

      <script src='<?php echo e(asset('resources/assets/fullcalendar/core/main.min.js')); ?>'></script>
      <script src='<?php echo e(asset('resources/assets/fullcalendar/daygrid/main.min.js')); ?>'></script>
      <script src='<?php echo e(asset('resources/assets/fullcalendar/timegrid/main.min.js')); ?>'></script>
      <script src='<?php echo e(asset('resources/assets/fullcalendar/list/main.min.js')); ?>'></script>
      <script src='<?php echo e(asset('resources/assets/fullcalendar/interaction/main.min.js')); ?>'></script>
      <script src='<?php echo e(asset('resources/assets/fullcalendar/locales-all.js')); ?>'></script>


      <script src="<?php echo e(asset('node_modules/tui-code-snippet/dist/tui-code-snippet.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/tui-time-picker/dist/tui-time-picker.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/tui-date-picker/dist/tui-date-picker.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/tui-calendar/dist/tui-calendar.min.js')); ?>"></script>


      <script src="<?php echo e(asset('node_modules/animejs/lib/anime.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/bootstrap-sweetalert/dist/sweetalert.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/inputmask/dist/inputmask.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/moment/min/moment.min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/moment/locale/fr.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/underscore/underscore-min.js')); ?>"></script>
      <script src="<?php echo e(asset('node_modules/angular-drag-and-drop-lists/angular-drag-and-drop-lists.js')); ?>"></script>
      <script src="<?php echo e(asset('resources/assets/pickr/dist/pickr.min.js')); ?>"></script>


      <script src="<?php echo e(asset('resources/js/index.js')); ?>"></script>
      <script src="<?php echo e(asset('resources/js/SideBarController.js')); ?>"></script>
      <script src="<?php echo e(asset('resources/js/NavBarController.js')); ?>"></script>




      <script src="<?php echo e(asset_path('DashboardModule','js/DashboardController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('AgendaModule','js/AgendaController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('AdminsModule','js/ListeAdminsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('AdminsModule','js/CrudAdminsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('AdminsModule','js/CrudAccesAdminsController.js')); ?>"></script>

      <script src="<?php echo e(asset_path('ClientsModules','js/ListeClientsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('ClientsModules','js/CrudClientsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('FinanceursExternesModule','js/ListeFinanceursExternesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('FinanceursExternesModule','js/CrudFinanceursExternesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('FormateursModule','js/ListeFormateursController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('FormateursModule','js/CrudFormateursController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('LieuxFormationModule','js/ListeLieuxFormationController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('LieuxFormationModule','js/CrudLieuxFormationController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('OrganismesModule','js/ListeOrganismesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('OrganismesModule','js/CrudOrganismesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('StagiairesModule','js/ListeStagiairesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('StagiairesModule','js/CrudStagiairesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('CompteModule','js/ProfilController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('CompteModule','js/CrudProfilController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('CompteModule','js/CrudCompteAccesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SuiviModule','js/ListeSuiviController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SuiviModule','js/CrudSuiviController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SuiviModule','js/CrudSuiviPController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SallesModule','js/ListeSallesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('DomainesModule','js/ListeDomainesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('DiplomesModule','js/ListeDiplomesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('ActionsFormationModule','js/ListeActionsController.js')); ?>"></script>

      <script src="<?php echo e(asset_path('ProgrammesModule','js/ListeProgrammesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('ProgrammesModule','js/CrudProgrammesController.js')); ?>"></script>

      <script src="<?php echo e(asset_path('SessionsModule','js/ListeSessionsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudSessionsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/ListeModulesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudModulesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudPrixModulesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudDatesModulesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudSeancesModulesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudIntervenantsSessionsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudApprenantsSessionsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudProgrammesSessionsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudObjectifsSessionsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudProfilsApprenantsSessionsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudFormationsSessionsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudEvaluationsSessionsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudSuiviApprenantsSessionsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('SessionsModule','js/CrudEmargementSessionsController.js')); ?>"></script>

      <script src="<?php echo e(asset_path('RapportModule','js/SuiviActivitesController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('RapportModule','js/SuiviDevisController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('RapportModule','js/SuiviConventionsController.js')); ?>"></script>
      <script src="<?php echo e(asset_path('RapportModule','js/SuiviPedagogiqueController.js')); ?>"></script>
</body>

</html>
<?php /**PATH /var/www/html/formacamp/resources/views/app.blade.php ENDPATH**/ ?>