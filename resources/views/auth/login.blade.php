<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>FormaCamp - Connexion</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="resources/assets/images/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="resources/assets/css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="resources/assets/css/typography.css">
</head>
<body>

<section class="sign-in-page">
    <div class="container bg-white mt-0 p-0">
        <div class="row no-gutters">
            <div class="col-lg-3 align-self-center" style="border-right: 1px solid #e8e8e8;">
                <div class="sign-in-from">
                  <!--  <h1 class="mb-0">S'identifier</h1> -->
				  <img src="resources/assets/images/logo.png" style="width: 77%; padding: 0 17px 0 17px; position: relative; display: block; margin: 0 auto; margin-top: -20%;"/>
                    <p style="text-align:center">Logiciel gestion de formation</p>
                    <form  method="POST" action="{{ route('login') }}" class="mt-4">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Adresse e-mail</label>
                            <input type="email" class="form-control mb-0" id="exampleInputEmail1" placeholder="Enter email" name="email" :value="old('email')" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mot de passe</label>
                            <a href="#" class="float-right">Mot de passe oublié?</a>
                            <input type="password" class="form-control mb-0" id="exampleInputPassword1" placeholder="Password" name="password" required>
                        </div>
						<div class="form-group">
							<div class="d-inline-block w-100">
								<button type="submit" class="btn btn-primary col-lg-12">{{ __('Connexion') }}</button>
							</div>
							<div class="d-inline-block w-100">
								<div class="text-grey-5" style="text-align:center">Vous êtes nouveau ? <a href="{{ route('register') }}" class="text-2">Inscription</a></div>
							</div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-9 text-white">
				<div class="sign-in-detail text-white"></div>
            </div>
        </div>
    </div>
</section>

<script src="resources/assets/js/jquery.min.js"></script>
<script src="resources/assets/js/bootstrap.min.js"></script>

</body>
<style>
.sign-in-detail.text-white {
    background: url(resources/assets/images/bg.webp) !important;
    background-size: cover !important;
    width: 100%;
    height: 100%;
    background-repeat: no-repeat !important;
    padding: 0;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
}
.col-lg-3.align-self-center {
    background: #ffffff;
    background-size: cover !important;
    width: 100%;
    height: 100%;
    background-repeat: no-repeat !important;
    padding-bottom: 52%;
}
.sign-in-from {
    position: absolute;
    margin: 0 auto;
    left: 0;
    right: 0;
    width: 100%;
    height: 100%;
    padding: 30% 7% 30% 7%;
}
button.btn.btn-primary.col-lg-12,
button.btn.btn-outline-primary.col-lg-12 {
    width: 100%;
    font-weight: bold;
    padding: 2.5%;
    margin-top: 0;
    margin-bottom: 5%;
}
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
textarea:-webkit-autofill,
textarea:-webkit-autofill:hover,
textarea:-webkit-autofill:focus,
select:-webkit-autofill,
select:-webkit-autofill:hover,
select:-webkit-autofill:focus {
    border: 1px solid rgb(130 122 243);
    -webkit-text-fill-color: #3f414d;
    -webkit-box-shadow: 0 0 0px 1000px #faf5ff inset;
    transition: background-color 5000s ease-in-out 0s;
}
.container.bg-white.mt-0.p-0 {
    width: 100%;
    padding: 0;
    max-width: 100%;
    top: 0;
    margin: 0 auto !important;
    height: 100%;
}
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}
</style>
</html>
