@extends('auth.layout')
@section('content')
	<form id="form" class="login100-form validate-form" method="POST" action="{{ route('user/login') }}">
		@csrf
		<center>
			<img src="{{asset('images/logo.png')}}" alt="cvm">
		</center>
		<span class="login100-form-title p-b-10">
			Bienvenido
		</span>

		@if($errors->first('error') != "")
			<div class="alert alert-danger" id="alert">
				{{ $errors->first('error') }}
			</div>
			<script>
				setTimeout(function(){ $("#alert").fadeOut(); }, 3000);
			</script>
		@endif
		
		<input type="hidden" name="key" value="{{ $key }}">

		<div class="wrap-input100 validate-input m-b-23" data-validate = "Usuario es obligatorio">
			<span class="label-input100">Usuario</span>
			<input required class="input100" type="text" name="username" placeholder="Ingresa tu usuario" required>
			<span class="focus-input100" data-symbol="&#xf206;"></span>
		</div>

		<div class="wrap-input100 validate-input" data-validate="Contraseña es obligatoria">
			<span class="label-input100">Contraseña</span>
			<input id="password" required class="input100" type="password" name="password" placeholder="Ingresa tu contraseña" required>
			<span class="focus-input100" data-symbol="&#xf190;"></span>
		</div>
		<br>
		<div class="container-login100-form-btn">
			<div class="wrap-login100-form-btn">
				<div class="login100-form-bgbtn"></div>
				<button type="button" onclick="validate()" class="login100-form-btn">
					Ingresar
				</button>
			</div>
		</div>
	</form>
	<script>
		function validate() {
			setLoadingFullScreen(true)
			setTimeout(() => {
				$("#form").submit()
			}, 500);
		}

		$('#password').keypress(function(e) {
			var keycode = (e.keyCode ? e.keyCode : e.which);
			if (keycode == '13') {
				validate()
			}
		});
	</script>
@endsection