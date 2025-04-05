@extends('layout.form-external')
@section('content')
	<form id="form" class="login100-form validate-form">
		<center>
			<img src="{{asset('images/logo.png')}}" alt="cvm">
		</center>
		<span class="login100-form-title p-b-10">
			Felicitaciones
		</span>
        <center>
            <p>Tus datos se han registrado exitosamente, gracias por tu tiempo, ya puedes cerrar esta ventana.</p>
        </center>

        <div class="container-login100-form-btn m-t-23">
			<div class="wrap-login100-form-btn">
				<div class="login100-form-bgbtn"></div>
				<button type="button" onclick="location.href='{{route('event/autoregister', $id)}}'" class="login100-form-btn">
					Volver
				</button>
			</div>
		</div>
	</form>
@endsection