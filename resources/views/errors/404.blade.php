<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon icon-->
    <link rel="icon" href="https://www.iglesiacvm.com/wp-content/uploads/2021/02/cropped-favicon-32x32.png"
        sizes="32x32">
    <link rel="icon" href="https://www.iglesiacvm.com/wp-content/uploads/2021/02/cropped-favicon-192x192.png"
        sizes="192x192">
    <link rel="apple-touch-icon"
        href="https://www.iglesiacvm.com/wp-content/uploads/2021/02/cropped-favicon-180x180.png">
    <!-- Libs CSS -->
    <link href="{{ asset('template/assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('template/assets/libs/dropzone/dist/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset('template/assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/assets/libs/prismjs/themes/prism-okaidia.min.css') }}" rel="stylesheet">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('template/assets/css/theme.min.css') }}">
    <title>Asistencia | CVM</title>
</head>

<body class="bg-white">
    <!-- Error page -->
    <div class="container min-vh-100 d-flex justify-content-center
      align-items-center">
        <!-- row -->
        <div class="row">
            <!-- col -->
            <div class="col-12">
                <!-- content -->
                <div class="text-center">
                    <div class="mb-3">
                        <!-- img -->
                        <img src="{{ asset('template/assets/images/error/404-error-img.png')}}" alt="" class="img-fluid">
                    </div>
                    <!-- text -->
                    <h1 class="display-4 fw-bold">Oops! the page not found.</h1>
                    <p class="mb-4">Or simply leverage the expertise of our consultation
                        team.</p>
                    <!-- button -->
                    <a href="{{ route('/') }}" class="btn btn-primary">Go Home</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
