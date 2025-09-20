<div class="app-header d-flex align-items-center">

    <!-- Toggle buttons starts -->
    <div class="d-flex">
      <button type="button" class="toggle-sidebar">
        <i class="ri-menu-line"></i>
      </button>
      <button type="button" class="pin-sidebar">
        <i class="ri-menu-line"></i>
      </button>
    </div>
    <!-- Toggle buttons ends -->

    <!-- App brand starts -->
    <div class="app-brand ms-3">
      {{-- <a href="index-2.html" class="d-lg-block d-none">
        <img src="assets/images/logo.svg" class="logo" alt="">
      </a>
      <a href="index-2.html" class="d-lg-none d-md-block">
        <img src="assets/images/logo-sm.svg" class="logo" alt="">
      </a> --}}
    </div>
    <!-- App brand ends -->

    <!-- App header actions starts -->
    <div class="header-actions">
      <div class=" ms-2">
        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" fdprocessedid="3piwtt">{{Auth::user()->name}}</button>
        <ul class="dropdown-menu dropdown-menu-end" style="">
            <li><a class="dropdown-item" href="{{route('profile')}}">Profile</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="javaScript:void();" data-url="{{route('logout')}}" onclick="ajaxRequest(this)">Logout</a></li>
          </ul>
      </div>
    </div>
    <!-- App header actions ends -->
  </div>
