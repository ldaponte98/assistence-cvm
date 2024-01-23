<!DOCTYPE html>
<html lang="en">
<head>
	<title>Asistencia | CVM</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{asset('images/logo.png')}}" sizes="32x32">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/login/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/login/fonts/iconic/css/material-design-iconic-font.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/login/vendor/animate/animate.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/login/vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/login/vendor/animsition/css/animsition.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/login/vendor/select2/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/login/vendor/daterangepicker/daterangepicker.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/login/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/login/css/main.css')}}">
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('template/login/images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                    <form class="login100-form validate-form" method="POST" action="user/login">
                    @csrf
                    <center>
                        <img src="{{asset('images/logo.png')}}" alt="cvm">
                    </center>
					<span class="login100-form-title p-b-49">
						Asistencia CVM
					</span>

					@if($errors->first('error') != "")
                        <div class="alert alert-danger" id="alert">
                            {{ $errors->first('error') }}
                        </div>
                        <script>
                          
                            setTimeout(function(){ $("#alert").fadeOut(); }, 3000);
                        </script>
                    @endif

					<div class="wrap-input100 validate-input m-b-23" data-validate = "Usuario es obligatorio">
						<span class="label-input100">Usuario</span>
						<input required class="input100" type="text" name="username" placeholder="Ingresa tu usuario">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Contraseña es obligatoria">
						<span class="label-input100">Contraseña</span>
						<input required class="input100" type="password" name="password" placeholder="Ingresa tu contraseña">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
                    <br>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Ingresar
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="dropDownSelect1"></div>
<!--===============================================================================================-->
	<script src="{{ asset('template/login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('template/login/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('template/login/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{ asset('template/login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('template/login/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('template/login/vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{ asset('template/login/vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('template/login/vendor/countdowntime/countdowntime.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('template/login/js/main.js')}}"></script>
</body>
</html>