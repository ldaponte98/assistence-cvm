@extends('layout.form-external')
@section('content')
	<form id="form" class="login100-form validate-form" method="POST" action="{{ route('event/autoregister/save', $event->id) }}">
		@csrf
		<center>
			<img src="{{asset('images/logo.png')}}" alt="cvm">
		</center>
		<span class="login100-form-title p-b-10">
			Ingresa los datos
		</span>

		<div class="alert alert-danger hide" id="alert-tmp">
			
		</div>

		@if($errors->first('error') != "")
			<div class="alert alert-danger" id="alert">
				{{ $errors->first('error') }}
			</div>
			<script>
				setTimeout(function(){ $("#alert").fadeOut(); }, 3000);
			</script>
		@endif

		<div class="wrap-input100 validate-input m-b-23" data-validate = "Los nombres son obligatorios">
			<span class="label-input100">Nombres<span class="required">*</span></span>
			<input required class="input100" type="text" name="fullname" required>
			<span class="focus-input100" data-symbol="&#xf206;"></span>
		</div>

		<div class="wrap-input100 validate-input m-b-23" data-validate = "Los apellidos son obligatorios">
			<span class="label-input100">Apellidos<span class="required">*</span></span>
			<input required class="input100" type="text" name="lastname" required>
			<span class="focus-input100" data-symbol="&#xf206;"></span>
		</div>

		<div class="wrap-input100 validate-input m-b-23" data-validate="Contraseña es obligatoria">
			<span class="label-input100">Número de telefono<span class="required">*</span></span>
			<input required class="input100" type="number" name="phone" required>
			<span class="focus-input100" data-symbol="&#xf206;"></span>
		</div>

		<div class="wrap-input100 validate-input m-b-23" data-validate="Contraseña es obligatoria">
			<span class="label-input100">Genero<span class="required">*</span></span>
			<select class="form-control" name="gender" required>
				<option value="M">Maculino</option>
				<option value="F">Femenino</option>
				<option value="O">Otro</option>
			</select>
		</div>
		
		<div class="wrap-input100 validate-input" data-validate="Contraseña es obligatoria">
			<span class="label-input100">Fecha de nacimiento<span class="required">*</span></span>
			<div class="row mt-2">
				<div class="col-4 col-sm-4">
					<select class="form-control" name="birthday-day" required>
						<option selected disabled value="">Día</option>
						<option value="01">1</option>
						<option value="02">2</option>
						<option value="03">3</option>
						<option value="04">4</option>
						<option value="05">5</option>
						<option value="06">6</option>
						<option value="07">7</option>
						<option value="08">8</option>
						<option value="09">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
						<option value="21">21</option>
						<option value="22">22</option>
						<option value="23">23</option>
						<option value="24">24</option>
						<option value="25">25</option>
						<option value="26">26</option>
						<option value="27">27</option>
						<option value="28">28</option>
						<option value="29">29</option>
						<option value="30">30</option>
						<option value="31">31</option>

					</select>
				</div>
				<div class="col-4 col-sm-4">
					<select class="form-control" name="birthday-month" required>
						<option selected disabled value="">Mes</option>
						<option value="01">Enero</option>
						<option value="02">Febrero</option>
						<option value="03">Marzo</option>
						<option value="04">Abril</option>
						<option value="05">Mayo</option>
						<option value="06">Junio</option>
						<option value="07">Julio</option>
						<option value="08">Agosto</option>
						<option value="09">Septiembre</option>
						<option value="10">Octubre</option>
						<option value="11">Noviembre</option>
						<option value="12">Diciembre</option>
					</select>
				</div>
				<div class="col-4 col-sm-4">
					<select class="form-control" id="select-year" name="birthday-year" required>
					</select>
				</div>
			</div>
		</div>
		<br>
		<div class="container-login100-form-btn">
			<div class="wrap-login100-form-btn">
				<div class="login100-form-bgbtn"></div>
				<button type="button" onclick="validate()" class="login100-form-btn">
					Continuar
				</button>
			</div>
		</div>
	</form>
    {{ view('event.external.event-external-script') }}
@endsection