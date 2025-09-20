<nav id="sidebar" class="sidebar-wrapper">

    <!-- Sidebar profile starts -->
    <div class="sidebar-profile">
      <img src="{{asset('assets/images/logo.png')}}" class="img-shadow img-3x me-3 rounded-5" alt="Logo">
      <div class="m-0">
        <h5 class="mb-1 profile-name text-nowrap text-truncate">{{Auth::user()->name}}</h5>
        <p class="m-0 small profile-name text-nowrap text-truncate">Dept Admin</p>
      </div>
    </div>
    <!-- Sidebar profile ends -->

    <!-- Sidebar menu starts -->
    <div class="sidebarMenuScroll">
      <ul class="sidebar-menu">
        <style>
            .sidebar-active {
                color: #000 !important;
                background: #e9f2ff !important;
                border-left: 3px solid #116aef !important;
            }
        </style>
        <li>
            <a href="{{route('dashboard')}}" class=" {{ (request()->routeIs('dashboard')) ? 'sidebar-active':'' }}">
                <i class="ri-home-6-line"></i>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="{{route('areas')}}" class=" {{ (request()->routeIs('areas')) ? 'sidebar-active':'' }}">
              <i class="ri-group-line"></i>
              <span class="menu-text">Areas</span>
            </a>
        </li>

        <li>
            <a href="{{route('users')}}" class=" {{ (request()->routeIs('users')) ? 'sidebar-active':'' }}">
              <i class="ri-group-line"></i>
              <span class="menu-text">Users</span>
            </a>
        </li>

        <li>
            <a href="{{route('live.locations')}}" class=" {{ (request()->routeIs('live.locations')) ? 'sidebar-active':'' }}">
              <i class="ri-group-line"></i>
              <span class="menu-text">Live Locations</span>
            </a>
        </li>

        @role('super-admin')
        <li>
            <a href="{{route('roles')}}" class=" {{ (request()->routeIs('roles')) ? 'sidebar-active':'' }}">
              <i class="ri-git-merge-line"></i>
              <span class="menu-text">Roles</span>
            </a>
        </li>
        <li>
            <a href="{{route('permissions')}}" class=" {{ (request()->routeIs('permissions')) ? 'sidebar-active':'' }}">
              <i class="ri-git-merge-line"></i>
              <span class="menu-text">Permissions</span>
            </a>
        </li>
        @endrole







      </ul>
    </div>
    <!-- Sidebar menu ends -->

    {{-- <!-- Sidebar contact starts -->
    <div class="sidebar-contact">
      <p class="fw-light mb-1 text-nowrap text-truncate">Emergency Contact</p>
      <h5 class="m-0 lh-1 text-nowrap text-truncate">0310-3730089</h5>
      <i class="ri-phone-line"></i>
    </div>
    <!-- Sidebar contact ends --> --}}

  </nav>
