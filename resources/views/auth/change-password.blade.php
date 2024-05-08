@extends('auth.layout')
@section('content')
	<style>
		.login100-form-title {
			font-size: 24px;
		}
	</style>
	<form id="form" class="login100-form validate-form" method="POST">
		@csrf
		<center><img src="{{asset('images/logo.png')}}" alt="cvm"></center>
		<span class="login100-form-title p-b-10">
			Cambio de contraseña
		</span>
        <div style="display: none" class="alert alert-danger" id="alert_front">
           
        </div>

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
			<input required class="input100" value="{{$user->username}}" type="text" name="username" placeholder="Ingresa tu usuario" required>
			<span class="focus-input100" data-symbol="&#xf206;"></span>
		</div>

		<div class="wrap-input100 validate-input m-b-23" data-validate="Contraseña es obligatoria">
			<span class="label-input100">Nueva Contraseña</span>
			<input id="password" required class="input100" type="password" autocomplete="off" name="password" placeholder="Ingresa tu contraseña" required>
			<span class="focus-input100" data-symbol="&#xf190;"></span>
		</div>

        <div class="wrap-input100 validate-input" data-validate="Contraseña es obligatoria">
			<span class="label-input100">Confirmación contraseña</span>
			<input id="confirm_password" required class="input100" type="password" name="confirm_password" placeholder="Ingresa tu contraseña nuevamente" required>
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
            if($("#password").val() != $("#confirm_password").val()){
                $("#alert_front").html("Las contraseñas no coinciden")
                $("#alert_front").fadeIn()
				setTimeout(function(){ $("#alert_front").fadeOut(); }, 3000);
                return;
            }
            $("#alert_front").fadeOut()
			setLoadingFullScreen(true)
			setTimeout(() => {
				$("#form").submit()
			}, 500);
		}

		$('#confirm_password').keypress(function(e) {
			var keycode = (e.keyCode ? e.keyCode : e.which);
			if (keycode == '13') {
				validate()
			}
		});
	</script>
@endsection