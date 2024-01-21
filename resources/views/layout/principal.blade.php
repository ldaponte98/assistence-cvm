<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{asset('images/logo.png')}}" sizes="32x32">
    <link href="{{ asset('template/assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('template/assets/libs/dropzone/dist/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset('template/assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/assets/libs/prismjs/themes/prism-okaidia.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/theme.min.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    
    <title>Asistencia | CVM</title>
    <script src="{{ asset('template/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="{{ asset('template/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/assets/libs/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>
@php
    $user = \App\Models\User::find(session('id'));
    if($user == null){
        $url = env('APP_URL');
        header("Location: $url");
        die;
    }
@endphp
<body class="bg-light">
    <div id="db-wrapper">
        <!-- navbar vertical -->
        {{ view('layout.menu', compact(['user'])) }}
        <!-- Sidebar -->
        <!-- Page content -->
        <div id="page-content">
            <div class="header @@classList">
                <!-- navbar -->
                {{ view('layout.superior', compact(['user'])) }}
            </div>
            <!-- Container fluid -->
            @csrf
            @yield('content','')
        </div>
    </div>
    <script src="{{ asset('template/assets/libs/feather-icons/dist/feather.min.js') }}"></script>
    <script src="{{ asset('template/assets/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('template/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('template/assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('template/assets/libs/prismjs/plugins/toolbar/prism-toolbar.min.js') }}"></script>
    <script src="{{ asset('template/assets/libs/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/theme.min.js') }}"></script>
    <script src="{{ asset('general.js') }}"></script>
</body>
</html>
