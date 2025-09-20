<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo</title>
    {{-- {{env('APP_NAME')}} --}}
    <!-- ******************** CSS Files ********************* -->
    <link rel="stylesheet" href="{{asset('')}}assets/fonts/remix/remixicon.css">
    <link rel="stylesheet" href="{{asset('')}}assets/css/main.min.css">
    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="{{asset('')}}assets/vendor/overlay-scroll/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="{{asset('')}}assets/plugins/sweetalert2/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')
    <style>
        nav .pagination{
            margin-top: 1%;
            float: right;
            margin-right: 1%;
        }
    </style>
</head>
  <body>

    <!-- Loading starts -->
    <div id="loading-wrapper">
      <div class='spin-wrapper'>
        <div class='spin'>
          <div class='inner'></div>
        </div>
        <div class='spin'>
          <div class='inner'></div>
        </div>
        <div class='spin'>
          <div class='inner'></div>
        </div>
        <div class='spin'>
          <div class='inner'></div>
        </div>
        <div class='spin'>
          <div class='inner'></div>
        </div>
        <div class='spin'>
          <div class='inner'></div>
        </div>
      </div>
    </div>
    <!-- Loading ends -->

    <!-- Page wrapper starts -->
    <div class="page-wrapper">
      <!-- App header starts -->
      @include('layouts.navbar')
      <!-- App header ends -->
      <!-- Main container starts -->
      <div class="main-container">
        <!-- Sidebar wrapper starts -->
       @include('layouts.sidebar')
        <!-- Sidebar wrapper ends -->
        <!-- App container starts -->
        <div class="app-container">
          @yield('content')
          <!-- App footer starts -->
          <div class="app-footer bg-white">
            <span>© Digital Systematic 2025</span>
          </div>
          <!-- App footer ends -->
        </div>
        <!-- App container ends -->
      </div>
      <!-- Main container ends -->
    </div>
    <!-- Page wrapper ends -->

    <!-- *************
			************ JavaScript Files *************
		************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="{{asset('')}}assets/js/jquery.min.js"></script>
    <script src="{{asset('')}}assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('')}}assets/js/moment.min.js"></script>
    <!-- Overlay Scroll JS -->
    <script src="{{asset('')}}assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
    <script src="{{asset('')}}assets/vendor/overlay-scroll/custom-scrollbar.js"></script>
    <!-- Custom JS files -->
    <script src="{{asset('')}}assets/js/custom.js"></script>
    <script src="{{asset('')}}assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{asset('')}}assets/js/myhelper-script.js"></script>
    <script>
        $('.ajaxForm').submit(function(e) {
            e.preventDefault();
            $('.ajaxForm button[type="submit"]').prop('disabled', true);
            var url = $(this).attr('action');
            var formData = new FormData(this);
            my_ajax(url, formData, 'post', function(res) {}, true);
            $('.ajaxForm button[type="submit"]').prop('disabled', true);
        });
    </script>
    @yield('JScript')
  </body>
</html>
