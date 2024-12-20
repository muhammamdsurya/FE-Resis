<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />

    <title>Aku Analis</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>


</head>

<body>
     <!-- overlay -->
        <script src="{{ asset('assets/js/overlay/iosOverlay.js') }}"></script>
            <script src="{{ asset('assets/js/overlay/spin.min.js') }}"></script>
            <link rel="stylesheet" href="{{ asset('assets/js/overlay/iosOverlay.css') }}">
            <script src="{{ asset('assets/js/overlay/modernizr-2.0.6.min.js') }}"></script>
            <script type="text/javascript">
                function createOverlay(screenText) {
                    var target = document.createElement("div");
                    document.body.appendChild(target);
                    var opts = {
                        lines: 13, // The number of lines to draw
                        length: 11, // The length of each line
                        width: 5, // The line thickness
                        radius: 17, // The radius of the inner circle
                        corners: 1, // Corner roundness (0..1)
                        rotate: 0, // The rotation offset
                        color: '#FFF', // #rgb or #rrggbb
                        speed: 1, // Rounds per second
                        trail: 60, // Afterglow percentage
                        shadow: false, // Whether to render a shadow
                        hwaccel: false, // Whether to use hardware acceleration
                        className: 'spinner', // The CSS class to assign to the spinner
                        zIndex: 2e9, // The z-index (defaults to 2000000000)
                        top: 'auto', // Top position relative to parent in px
                        left: 'auto' // Left position relative to parent in px
                    };
                    var spinner = new Spinner(opts).spin(target);
                    gOverlay = iosOverlay({
                        text: screenText,
                        /*duration: 2e3,*/
                        spinner: spinner
                    });
                }
                var gOverlay;
            </script>
            <!-- END OVERLAY  -->


    @yield('content')
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
