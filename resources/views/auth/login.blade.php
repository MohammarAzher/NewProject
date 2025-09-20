<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('TITLE_NAME')}}</title>
    <link rel="shortcut icon" href="assets/images/favicon.svg">
    <link rel="stylesheet" href="assets/fonts/remix/remixicon.css">
    <link rel="stylesheet" href="assets/css/main.min.css">
    <link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
  <body class="login-bg">
    <!-- Container starts -->
    <div class="container">
      <!-- Auth wrapper starts -->
      <div class="auth-wrapper" style="justify-content: center;">
        <!-- Form starts -->
        <form method="post" action="{{route('login')}}" class="ajaxForm">
            @csrf
          <div class="auth-box" style="min-width: 400px">
            <a href="" class="auth-logo mb-4" style="display:flex;margin:0 !important;    justify-content: center;">
              <img src="assets/logo.png"  style="    max-height: 150px; max-width: 250px; margin-bottom: 5%;">
            </a>
            <div class="mb-3">
              <label class="form-label" for="email">Your email <span class="text-danger">*</span></label>
              <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email">
            </div>

            <div class="mb-2">
              <label class="form-label" for="password">Your password <span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
                <button class="btn btn-outline-secondary toggle-password" type="button">
                  <i class="ri-eye-line text-primary"></i>
                </button>
              </div>
            </div>
            <div class="mb-2">
                <div class="input-group">
                    <input type="checkbox" id="user-checkbox" checked="" />
                    <label for="user-checkbox"> &nbsp; Remember me</label>
                </div>
            </div>
            {{-- <div class="d-flex justify-content-end mb-3">
              <a href="forgot-password.html" class="text-decoration-underline">Forgot password?</a>
            </div> --}}
            <div class="mb-3 d-grid gap-2">
              <button type="submit" class="btn btn-primary">Login</button>
              {{-- <a href="signup.html" class="btn btn-secondary">Not registered? Signup</a> --}}
            </div>
          </div>
        </form>
        <!-- Form ends -->
      </div>
      <!-- Auth wrapper ends -->
    </div>
    <!-- Container ends -->
  </body>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="assets/js/myhelper-script.js"></script>
  <script>
     $('.ajaxForm').submit(function(e) {
         e.preventDefault();
        $('.ajaxForm button[type="submit"]').prop('disabled', true);
        var url = $(this).attr('action');
        var formData = new FormData(this);
        my_ajax(url, formData, 'post', function(res) {
        },true);
        $('.ajaxForm button[type="submit"]').prop('disabled', true);
    });

    $(document).ready(function() {

        $(document).on('click', '.toggle-password', function () {
            const $button = $(this);
            const $input = $button.siblings('input');
            const $icon = $button.find('i');

            if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $icon.removeClass('ri-eye-line').addClass('ri-eye-off-line');
            } else {
            $input.attr('type', 'password');
            $icon.removeClass('ri-eye-off-line').addClass('ri-eye-line');
            }
        });

        var email = localStorage.getItem('rememberedEmail');
        if (email) {
            $('#email').val(email);
            $('#user-checkbox').prop('checked', true);
        }else{
            $('#user-checkbox').prop('checked', false);
        }
        if ($('#user-checkbox').prop('checked') && localStorage.getItem('rememberedEmail')) {
            $('#email').val(localStorage.getItem('rememberedEmail'));
        }
        // Update rememberedEmail on "Remember Me" checkbox change
        $('#user-checkbox').change(function() {
            if ($(this).is(':checked')) {
                localStorage.setItem('rememberedEmail', $('#email').val());
            } else {
                localStorage.removeItem('rememberedEmail');
            }
        });
    });
  </script>
</html>

