<!DOCTYPE html>
<html lang="en">
<head>
	<title>Iglesia CVM</title>
	<link rel="manifest" href="{{ asset('manifest.json') }}">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{asset('images/logo.png')}}" sizes="32x32">
	<link rel="apple-touch-icon" href="{{asset('images/logo.png')}}">
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
	<script src="{{ asset('template/login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{ asset('template/login/vendor/animsition/js/animsition.min.js')}}"></script>
	<script src="{{ asset('template/login/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{ asset('template/login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{ asset('template/login/vendor/select2/select2.min.js')}}"></script>
	<script src="{{ asset('template/login/vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{ asset('template/login/vendor/daterangepicker/daterangepicker.js')}}"></script>
	<script src="{{ asset('template/login/vendor/countdowntime/countdowntime.js')}}"></script>
	<script src="{{ asset('template/login/js/main.js')}}"></script>
	<link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="{{ asset('blockUI.js') }}"></script>
    <style>
        .form-check-input {
            margin-left: 0rem;
        }
        .counter-lb{
            font-size: 60px !important;
        }
    </style>
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-color: #f8f9fa;">
			<div class="wrap-login100-l p-l-55 p-r-55 p-t-65 p-b-54" style="box-shadow: rgba(0 0 0 / 31%) 0px 0px 40px 0px;">
                @yield('content','')
			</div>
		</div>
	</div>
	<div id="dropDownSelect1"></div>
	<script src="{{ asset('general.js') }}?v=2"></script>
	<script>
		if ('serviceWorker' in navigator) {
			navigator.serviceWorker.register("/sw.js")
		}
	</script>
</body>
</html>