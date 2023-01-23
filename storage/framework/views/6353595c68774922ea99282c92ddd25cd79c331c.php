<!doctype html>
<html lang="en">

<!-- Mirrored from iqonic.design/themes/vito/html/sign-up.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 12 Apr 2020 21:56:15 GMT -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Vito - Responsive Bootstrap 4 Admin Dashboard Template</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="resources/assets/images/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="resources/assets/css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="resources/assets/css/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="resources/assets/css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="resources/assets/css/responsive.css">
</head>
<body>
<!-- loader Start -->
<div id="loading">
    <div id="loading-center">
    </div>
</div>
<!-- loader END -->
<!-- Sign in Start -->
<section class="sign-in-">
    <div class="container mt-5 p-0 bg-white">
        <div class="row no-gutters">
            <div class="col-sm-6 align-self-center">
                <div class="sign-in-from">
                    <h1 class="mb-0">S'inscrire</h1>
                    <p>Entrez votre adresse e-mail et votre mot de passe pour accéder au panneau d'administration.</p>
                    <form class="mt-4" method="POST" action="<?php echo e(route('register')); ?>">
                            <?php echo csrf_field(); ?>

                        <div class="form-group">
                            <label for="exampleInputEmail2">Adresse e-mail</label>
                            <input type="email" class="form-control mb-0" id="exampleInputEmail2" placeholder="Entrer l'adresse e-mail"  :value="__('Email')" name="email" :value="old('email')" required >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mot de passe</label>
                            <input type="password" class="form-control mb-0" id="exampleInputPassword1" placeholder="Mot de passe"  name="password"
                                   required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Confirmez le mot de passe</label>
                            <input type="password" class="form-control mb-0" id="exampleInputPassword1" placeholder="Confirmez le mot de passe"   name="password_confirmation" required>
                        </div>
                        <div class="d-inline-block w-100">
                            <button type="submit" class="btn btn-primary float-right">S'inscrire</button>
                        </div>
                        <div class="sign-info">
                            <span class="dark-color d-inline-block line-height-2">Vous avez déjà un compte ? <a href="<?php echo e(route('login')); ?>">Connexion</a></span>
                            <ul class="iq-social-media">
                                <li><a href="#"><i class="ri-facebook-box-line"></i></a></li>
                                <li><a href="#"><i class="ri-twitter-line"></i></a></li>
                                <li><a href="#"><i class="ri-instagram-line"></i></a></li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 text-center">
                <div class="sign-in-detail text-white">
                    <a class="sign-in-logo mb-5" href="#"><img src="resources/assets/images/logo-white.png" class="img-fluid" alt="logo"></a>
                    <div class="owl-carousel" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="0">
                        <div class="item">
                            <img src="resources/assets/images/login/1.png" class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Manage your orders</h4>
                            <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                        </div>
                        <div class="item">
                            <img src="resources/assets/images/login/1.png" class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Manage your orders</h4>
                            <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                        </div>
                        <div class="item">
                            <img src="resources/assets/images/login/1.png" class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Manage your orders</h4>
                            <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Sign in END -->
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="resources/assets/js/jquery.min.js"></script>
<script src="resources/assets/js/popper.min.js"></script>
<script src="resources/assets/js/bootstrap.min.js"></script>
<!-- Appear JavaScript -->
<script src="resources/assets/js/jquery.appear.js"></script>
<!-- Countdown JavaScript -->
<script src="resources/assets/js/countdown.min.js"></script>
<!-- Counterup JavaScript -->
<script src="resources/assets/js/waypoints.min.js"></script>
<script src="resources/assets/js/jquery.counterup.min.js"></script>
<!-- Wow JavaScript -->
<script src="resources/assets/js/wow.min.js"></script>
<!-- Apexcharts JavaScript -->
<script src="resources/assets/js/apexcharts.js"></script>
<!-- Slick JavaScript -->
<script src="resources/assets/js/slick.min.js"></script>
<!-- Select2 JavaScript -->
<script src="resources/assets/js/select2.min.js"></script>
<!-- Owl Carousel JavaScript -->
<script src="resources/assets/js/owl.carousel.min.js"></script>
<!-- Magnific Popup JavaScript -->
<script src="resources/assets/js/jquery.magnific-popup.min.js"></script>
<!-- Smooth Scrollbar JavaScript -->
<script src="resources/assets/js/smooth-scrollbar.js"></script>
<!-- Chart Custom JavaScript -->
<script src="resources/assets/js/chart-custom.js"></script>
<!-- Custom JavaScript -->
<script src="resources/assets/js/custom.js"></script>
</body>

<!-- Mirrored from iqonic.design/themes/vito/html/sign-up.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 12 Apr 2020 21:56:15 GMT -->
</html>
<?php /**PATH /var/www/html/formacamp/resources/views/auth/register.blade.php ENDPATH**/ ?>