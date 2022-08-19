<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  @if(Auth::guard('user')->user()->role_id == 2)
     <title>COD CONSOLE</title>
 @else
    <title>DEAN CONSOLE</title>
 @endif

  <meta name="description" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
  <meta name="author" content="pixelcave">
  <meta name="robots" content="noindex, nofollow">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('/media/favicons/favicon.png') }}">
  <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('/media/favicons/favicon-192x192.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/media/favicons/apple-touch-icon-180x180.png') }}">

  <!-- Fonts and Styles -->
  @yield('css_before')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" id="css-main" href="{{ url('/css/oneui.css') }}">

  <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
  <!-- <link rel="stylesheet" id="css-theme" href="{{ mix('/css/themes/amethyst.css') }}"> -->
  @yield('css_after')

  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
  </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

</head>

<body>
  <!-- Page Container -->
  <!--
    Available classes for #page-container:

    GENERIC

      'remember-theme'                            Remembers active color theme and dark mode between pages using localStorage when set through
                                                  - Theme helper buttons [data-toggle="theme"],
                                                  - Layout helper buttons [data-toggle="layout" data-action="dark_mode_[on/off/toggle]"]
                                                  - ..and/or One.layout('dark_mode_[on/off/toggle]')

    SIDEBAR & SIDE OVERLAY

      'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
      'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
      'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
      'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
      'sidebar-dark'                              Dark themed sidebar

      'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
      'side-overlay-o'                            Visible Side Overlay by default

      'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

      'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

    HEADER

      ''                                          Static Header if no class is added
      'page-header-fixed'                         Fixed Header

    HEADER STYLE

      ''                                          Light themed Header
      'page-header-dark'                          Dark themed Header

    MAIN CONTENT LAYOUT

      ''                                          Full width Main Content if no class is added
      'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
      'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)

    DARK MODE

      'sidebar-dark page-header-dark dark-mode'   Enable dark mode (light sidebar/header is not supported with dark mode)
    -->
  <div id="page-container" class="sidebar-o enable-page-overlay sidebar-dark side-scroll page-header-fixed main-content-narrow">
    <!-- Side Overlay-->
    <aside id="side-overlay" class="fs-sm">
      <!-- Side Header -->
      <div class="content-header border-bottom">

        <!-- User Info -->
        <div class="ms-2">
          <a class="text-dark fw-semibold fs-sm" href="javascript:void(0)">{{ auth()->guard('user')->user()->name }}</a>
        </div>
        <!-- END User Info -->

        <!-- Close Side Overlay -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
        <a class="ms-auto btn btn-sm btn-alt-danger" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
          <i class="fa fa-fw fa-times"></i>
        </a>
        <!-- END Close Side Overlay -->
      </div>
      <!-- END Side Header -->

      <!-- Side Content -->
      <div class="content-side">
        <p>
          Content..
        </p>
      </div>
      <!-- END Side Content -->
    </aside>
    <!-- END Side Overlay -->

    <!-- Sidebar -->
    <!--
        Sidebar Mini Mode - Display Helper classes

        Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
        Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
            If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

        Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
        Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
        Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
    -->
    <nav id="sidebar" aria-label="Main Navigation">
      <!-- Side Header -->
      <div class="content-header">
        <!-- Logo -->
        <a class="font-semibold text-dual" href="#">
          <span class="smini-visible">
            <i class="fa fa-circle-notch text-primary"></i>
          </span>
          <span>TUM SIMS</span>
        </a>

        <!-- Extra -->
        <div>
          <!-- Close Sidebar, Visible only on mobile screens -->
          <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
          <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
            <i class="fa fa-fw fa-times"></i>
          </a>
          <!-- END Close Sidebar -->
        </div>
        <!-- END Extra -->
      </div>
      <!-- END Side Header -->

      <!-- Sidebar Scrolling -->
      <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side">
          <ul class="nav-main">
            <li class="nav-main-item">
              <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="{{ route('dashboard') }}">
                <i class="nav-main-link-icon si si-cursor"></i>
                <span class="nav-main-link-name">
                    Home
                </span>
              </a>
            </li>
              <li class="nav-main-item{{ request()->is('approvals/*') ? ' open' : '' }}">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                      <i class="nav-main-link-icon si si-layers"></i>
                      <span class="nav-main-link-name">Approvals</span>
                  </a>
                  <ul class="nav-main-submenu">
                      <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('approvals/pending') ? ' active' : '' }}" href="{{ route('approval.pending') }}">
                              <span class="nav-main-link-name">Pending</span>
                          </a>
                      </li>
                      <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('approvals/approved') ? ' active' : '' }}" href="{{ route('approval.approved') }}">
                              <span class="nav-main-link-name">Approved</span>
                          </a>
                      </li>
                      <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('approvals/rejected') ? ' active' : '' }}" href="{{ route('approval.rejected') }}">
                              <span class="nav-main-link-name">Rejected</span>
                          </a>
                      </li>
                  </ul>
              </li>
              <li class="nav-main-item{{ request()->is('students/*') ? 'open' : '' }}">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                      <i class="nav-main-link-icon si si-layers"></i>
                      <span class="nav-main-link-name">Students</span>
                  </a>
                  <ul class="nav-main-submenu">
                      <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('students/search') ? 'active' : '' }}" href="{{ route('approval.search') }}">
                              <span class="nav-main-link-name">Search</span>
                          </a>
                      </li>
                  </ul>
              </li>
              <li class="nav-main-item{{ request()->is('students/*') ? 'open' : '' }}">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                      <i class="nav-main-link-icon si si-layers"></i>
                      <span class="nav-main-link-name">Intakes</span>
                  </a>
                  <ul class="nav-main-submenu">
                      <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('students/search') ? 'active' : '' }}" href="{{ route('approval.courses') }}">
                              <span class="nav-main-link-name">Add Courses</span>
                          </a>
                      </li>
                  </ul>
                  <ul class="nav-main-submenu">
                      <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('students/search') ? 'active' : '' }}" href="{{ route('approval.report') }}">
                              <span class="nav-main-link-name">Course Report</span>
                          </a>
                      </li>
                  </ul>
              </li>
          </ul>
        </div>
        <!-- END Side Navigation -->
      </div>
      <!-- END Sidebar Scrolling -->
    </nav>
    <!-- END Sidebar -->

    <!-- Header -->
    <header id="page-header" style = 'background-color:#d89837;'>
      <!-- Header Content -->
      <div class="content-header">
        <!-- Left Section -->
        <div class="d-flex align-items-center">
          <!-- Toggle Sidebar -->
          <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
          <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
            <i class="fa fa-fw fa-bars"></i>
          </button>
          <!-- END Toggle Sidebar -->

          <!-- Toggle Mini Sidebar -->
          <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
          <button type="button" style = 'background-color:#d89837;' class="btn btn-sm btn-alt-secondary me-2 d-none d-lg-inline-block" data-toggle="layout" data-action="sidebar_mini_toggle">
            <i class="fa fa-fw fa-list-ul fa-flip-horizontal"></i>
          </button>
          <!-- END Toggle Mini Sidebar -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="d-flex align-items-center">
          <!-- User Dropdown -->
          <div class="dropdown d-inline-block ms-2">
            <button type="button" style = 'background-color:#d89837;' class="btn btn-sm btn-alt-secondary d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="rounded-circle" src="{{ asset('media/avatars/avatar10.jpg') }}" alt="Header Avatar" style="width: 21px;">
              <span class="d-none d-sm-inline-block ms-2"> {{ auth()->guard('user')->user()->title }} {{ auth()->guard('user')->user()->name }}</span>
              <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block ms-1 mt-1"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0" aria-labelledby="page-header-user-dropdown">
              <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ asset('media/avatars/avatar10.jpg') }}" alt="">
                <p class="mt-2 mb-0 fw-medium">{{ auth()->guard('user')->user()->name }}</p>
              </div>
              <div class="p-2">
{{--                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">--}}
{{--                  <span class="fs-sm fw-medium">Inbox</span>--}}
{{--                  <span class="badge rounded-pill bg-primary ms-2">3</span>--}}
{{--                </a>--}}
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                  <span class="fs-sm fw-medium">Profile</span>
                  <span class="badge rounded-pill bg-primary ms-2">1</span>
                </a>
              </div>
              <div role="separator" class="dropdown-divider m-0"></div>
              <div class="p-2">
{{--                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">--}}
{{--                  <span class="fs-sm fw-medium">Lock Account</span>--}}
{{--                </a>--}}
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('application.logout') }}">
                  <span class="fs-sm fw-medium">Log Out</span>
                </a>
              </div>
            </div>
          </div>
          <!-- END User Dropdown -->

          <!-- Notifications Dropdown -->
{{--          <div class="dropdown d-inline-block ms-2">--}}
{{--            <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--              <i class="fa fa-fw fa-bell"></i>--}}
{{--              <span class="text-primary">•</span>--}}
{{--            </button>--}}
{{--            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 border-0 fs-sm" aria-labelledby="page-header-notifications-dropdown">--}}
{{--              <div class="p-2 bg-body-light border-bottom text-center rounded-top">--}}
{{--                <h5 class="dropdown-header text-uppercase">Notifications</h5>--}}
{{--              </div>--}}
{{--              <ul class="nav-items mb-0">--}}
{{--                <li>--}}
{{--                  <a class="text-dark d-flex py-2" href="javascript:void(0)">--}}
{{--                    <div class="flex-shrink-0 me-2 ms-3">--}}
{{--                      <i class="fa fa-fw fa-check-circle text-success"></i>--}}
{{--                    </div>--}}
{{--                    <div class="flex-grow-1 pe-2">--}}
{{--                      <div class="fw-semibold">You have a new follower</div>--}}
{{--                      <span class="fw-medium text-muted">15 min ago</span>--}}
{{--                    </div>--}}
{{--                  </a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                  <a class="text-dark d-flex py-2" href="javascript:void(0)">--}}
{{--                    <div class="flex-shrink-0 me-2 ms-3">--}}
{{--                      <i class="fa fa-fw fa-plus-circle text-primary"></i>--}}
{{--                    </div>--}}
{{--                    <div class="flex-grow-1 pe-2">--}}
{{--                      <div class="fw-semibold">1 new sale, keep it up</div>--}}
{{--                      <span class="fw-medium text-muted">22 min ago</span>--}}
{{--                    </div>--}}
{{--                  </a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                  <a class="text-dark d-flex py-2" href="javascript:void(0)">--}}
{{--                    <div class="flex-shrink-0 me-2 ms-3">--}}
{{--                      <i class="fa fa-fw fa-times-circle text-danger"></i>--}}
{{--                    </div>--}}
{{--                    <div class="flex-grow-1 pe-2">--}}
{{--                      <div class="fw-semibold">Update failed, restart server</div>--}}
{{--                      <span class="fw-medium text-muted">26 min ago</span>--}}
{{--                    </div>--}}
{{--                  </a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                  <a class="text-dark d-flex py-2" href="javascript:void(0)">--}}
{{--                    <div class="flex-shrink-0 me-2 ms-3">--}}
{{--                      <i class="fa fa-fw fa-plus-circle text-primary"></i>--}}
{{--                    </div>--}}
{{--                    <div class="flex-grow-1 pe-2">--}}
{{--                      <div class="fw-semibold">2 new sales, keep it up</div>--}}
{{--                      <span class="fw-medium text-muted">33 min ago</span>--}}
{{--                    </div>--}}
{{--                  </a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                  <a class="text-dark d-flex py-2" href="javascript:void(0)">--}}
{{--                    <div class="flex-shrink-0 me-2 ms-3">--}}
{{--                      <i class="fa fa-fw fa-user-plus text-success"></i>--}}
{{--                    </div>--}}
{{--                    <div class="flex-grow-1 pe-2">--}}
{{--                      <div class="fw-semibold">You have a new subscriber</div>--}}
{{--                      <span class="fw-medium text-muted">41 min ago</span>--}}
{{--                    </div>--}}
{{--                  </a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                  <a class="text-dark d-flex py-2" href="javascript:void(0)">--}}
{{--                    <div class="flex-shrink-0 me-2 ms-3">--}}
{{--                      <i class="fa fa-fw fa-check-circle text-success"></i>--}}
{{--                    </div>--}}
{{--                    <div class="flex-grow-1 pe-2">--}}
{{--                      <div class="fw-semibold">You have a new follower</div>--}}
{{--                      <span class="fw-medium text-muted">42 min ago</span>--}}
{{--                    </div>--}}
{{--                  </a>--}}
{{--                </li>--}}
{{--              </ul>--}}
{{--              <div class="p-2 border-top text-center">--}}
{{--                <a class="d-inline-block fw-medium" href="javascript:void(0)">--}}
{{--                  <i class="fa fa-fw fa-arrow-down me-1 opacity-50"></i> Load More..--}}
{{--                </a>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
          <!-- END Notifications Dropdown -->

          <!-- Toggle Side Overlay -->
          <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
{{--          <button type="button" class="btn btn-sm btn-alt-secondary ms-2" data-toggle="layout" data-action="side_overlay_toggle">--}}
{{--            <i class="fa fa-fw fa-list-ul fa-flip-horizontal"></i>--}}
{{--          </button>--}}
          <!-- END Toggle Side Overlay -->
        </div>
        <!-- END Right Section -->
      </div>
      <!-- END Header Content -->

      <!-- Header Search -->
      <div id="page-header-search" class="overlay-header bg-body-extra-light">
        <div class="content-header">
          <form class="w-100" action="/dashboard" method="POST">
            @csrf
            <div class="input-group">
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <button type="button" class="btn btn-alt-danger" data-toggle="layout" data-action="header_search_off">
                <i class="fa fa-fw fa-times-circle"></i>
              </button>
              <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
            </div>
          </form>
        </div>
      </div>
      <!-- END Header Search -->

      <!-- Header Loader -->
      <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
      <div id="page-header-loader" class="overlay-header bg-body-extra-light">
        <div class="content-header">
          <div class="w-100 text-center">
            <i class="fa fa-fw fa-circle-notch fa-spin"></i>
          </div>
        </div>
      </div>
      <!-- END Header Loader -->
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
      @yield('content')
        @include('application::messages.notification')
    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer" class="bg-body-light">
      <div class="content py-3">
        <div class="row fs-sm">
          <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
            Crafted with <i class="fa fa-heart text-danger"></i> by <a class="fw-semibold" href="https://support.tum.ac.ke/" target="_blank">TUM ICTs</a>
          </div>
          <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
            <a class="fw-semibold" href="https://www.tum.ac.ke/" target="_blank">Technical University of Mombasa</a> &copy; <span data-toggle="year-copy"></span>
          </div>
        </div>
      </div>
    </footer>
    <!-- END Footer -->
  </div>
  <!-- END Page Container -->

  <!-- OneUI Core JS -->
  <script src="{{ url('js/oneui.app.js') }}"></script>

  <!-- Laravel Scaffolding JS -->
  <!-- <script src="{{ mix('/js/laravel.app.js') }}"></script> -->

  @yield('js_after')
</body>

</html>
