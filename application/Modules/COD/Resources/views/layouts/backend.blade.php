<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  <title>{{ config('app.name') }}</title>

  <meta name="description" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
  <meta name="author" content="pixelcave">
  <meta name="robots" content="noindex, nofollow">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="oneui-route" content="{{ route('raw.route') }}">

  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
  <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

  <!-- Fonts and Styles -->
  @yield('css_before')
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js" integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" id="css-main" href="{{ url('/css/oneui.css') }}">
  <link rel="stylesheet" id="css-main" href="{{ url('/css/index.css') }}">
  <link rel="stylesheet" id="css-main" href="{{ url('/css/admissions.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


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

    <script src="{{ url("js/build/build.js") }}" async></script>

</head>

<body>

  <div id="page-container" class="sidebar-o enable-page-overlay sidebar-dark side-scroll page-header-fixed main-content-narrow">

    <nav id="sidebar" aria-label="Main Navigation">
      <!-- Side Header -->
      <div class="content-header">
        <!-- Logo -->
        <a class="font-semibold text-dual" href="#">
          <span class="smini-visible">
            <i class="fa fa-circle-notch text-primary"></i>
          </span>
          <span class="smini-hide fs-5 tracking-wider"><span class="fw-normal">{{ config('app.name') }}</span></span>
        </a>
        <!-- END Logo -->

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
                    @if(auth()->guard('user')->user()->role_id == 2)

                        {{ auth()->guard('user')->user()->getDept->dept_code }}

                    @endif
                </span>

              </a>
            </li>

              <li class="nav-main-item{{ request()->is('intakes/*') ? ' open' : '' }}">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                      <i class="nav-main-link-icon si si-graduation"></i>
                      <span class="nav-main-link-name">Academics</span>
                  </a>
                  <ul class="nav-main-submenu">
                     <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('courses/showCourse') ? ' active' : '' }}" href="{{  route('department.courses') }}">
                              <i class="nav-main-link-icon si si-layers"></i>
                              <span class="nav-main-link-name">Courses</span>
                          </a>
                      </li>

                      <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('intake/showIntake') ? ' active' : '' }}" href="{{ route('department.intakes') }}">
                              <i class="nav-main-link-icon si si-calendar"></i>
                              <span class="nav-main-link-name">Intakes</span>
                          </a>
                      </li>
                      <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('classes/index') ? ' active' : '' }}" href="{{ route('department.classes')}}">
                              <i class="nav-main-link-icon si si-layers"></i>
                              <span class="nav-main-link-name">Classes</span>
                          </a>
                      </li>

                      <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('classes/index') ? ' active' : '' }}" href="{{ route('department.examResults')}}">
                              <i class="nav-main-link-icon si si-layers"></i>
                              <span class="nav-main-link-name">Exam Results</span>
                          </a>
                      </li>
                  </ul>
              </li>

            <li class="nav-main-item{{ request()->is('intakes/*') ? ' open' : '' }}">
              <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="{{ route('cod.applications') }}">
                <i class="nav-main-link-icon si si-graduation"></i>
                <span class="nav-main-link-name">Applications</span>
              </a>
              <ul class="nav-main-submenu">
                  <li class="nav-main-item">
                      <a class="nav-main-link{{ request()->is('intake/showIntake') ? ' active' : '' }}" href="{{ route('cod.applications') }}">
                          <i class="nav-main-link-icon si si-calendar"></i>
                          <span class="nav-main-link-name">All applications</span>
                      </a>
                  </li>

                    <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('school/showSchool') ? ' active' : '' }}" href="{{  route('cod.batch') }}">
                            <i class="nav-main-link-icon si si-graduation"></i>
                              <span class="nav-main-link-name">Submit batch</span>
                          </a>
                      </li>
              </ul>
            </li>
              <li class="nav-main-item{{ request()->is('intakes/*') ? ' open' : '' }}">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="{{ route('cod.applications') }}">
                      <i class="nav-main-link-icon si si-graduation"></i>
                      <span class="nav-main-link-name">Admissions</span>
                  </a>
                  <ul class="nav-main-submenu">
                      <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('intake/showIntake') ? ' active' : '' }}" href="{{ route('cod.Admissions') }}">
                              <i class="nav-main-link-icon si si-calendar"></i>
                              <span class="nav-main-link-name">View Admissions</span>
                          </a>
                      </li>
                  </ul>
              </li>

              <li class="nav-main-item{{ request()->is('intakes/*') ? ' open' : '' }}">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="{{ route('cod.applications') }}">
                      <i class="nav-main-link-icon si si-graduation"></i>
                      <span class="nav-main-link-name">Course Transfers</span>
                  </a>
                  <ul class="nav-main-submenu">
                      <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('intake/showIntake') ? ' active' : '' }}" href="{{ route('department.courseTransfers') }}">
                              <i class="nav-main-link-icon si si-calendar"></i>
                              <span class="nav-main-link-name">Transfer Requests</span>
                          </a>
                      </li>
                  </ul>
              </li>
              <li class="nav-main-item{{ request()->is('intakes/*') ? ' open' : '' }}">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="{{ route('cod.applications') }}">
                      <i class="nav-main-link-icon si si-graduation"></i>
                      <span class="nav-main-link-name">Deferment & Leaves</span>
                  </a>
                  <ul class="nav-main-submenu">
                      <li class="nav-main-item">
                          <a class="nav-main-link{{ request()->is('intake/showIntake') ? ' active' : '' }}" href="{{ route('department.academicLeave') }}">
                              <i class="nav-main-link-icon si si-calendar"></i>
                              <span class="nav-main-link-name">View requests</span>
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
    <header id="page-header" style="background: #d89837 !important">
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
          <button type="button" class="btn btn-sm btn-alt-dark me-2 d-none d-lg-inline-block" data-toggle="layout" data-action="sidebar_mini_toggle">
            <i class="fa fa-fw fa-list-ul fa-flip-horizontal"></i>
          </button>
          <!-- END Toggle Mini Sidebar -->

        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="d-flex align-items-center">
          <!-- User Dropdown -->
          <div class="dropdown d-inline-block ms-2">
            <button type="button" class="btn btn-sm btn-alt-dark d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="rounded-circle" src="{{ asset('media/avatars/may.png') }}" alt="Header Avatar" style="width: 21px;">
              <span class="d-none d-sm-inline-block ms-2">
                  @if(Auth::guard('user')->check())
                      {{ Auth::guard('user')->user()->name }}
                  @else
                      {{ Auth::user()->name }}
                  @endif
              </span>
              <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block ms-1 mt-1"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0" aria-labelledby="page-header-user-dropdown">
              <div class="p-3 text-center bg-body-dark border-bottom rounded-top">
                <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ asset('media/avatars/may.png') }}" alt="">
                <p class="mt-2 mb-0 fw-medium">
           {{-- {{ Auth::guard('user')->user()->name }}--}}
                    @if(Auth::guard('user')->check())
                        {{ Auth::guard('user')->user()->name }}
                    @else
                        {{ Auth::user()->name }}
                    @endif </p>
                <p class="mb-0 text-muted fs-sm fw-medium">
                    @if(Auth::guard('user')->check())
                        {{ Auth::guard('user')->user()->role_id }}
                    @else
                        Applicant
                    @endif</p>
              </div>
              {{-- <div class="p-2">
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                  <span class="fs-sm fw-medium">Settings</span>
                </a>
              </div> --}}
              <div role="separator" class="dropdown-divider m-0"></div>
              <div class="p-2">
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('application.logout') }}">
                  <span class="fs-sm fw-medium">Log Out</span>
                </a>
              </div>
            </div>
          </div>
          <!-- END User Dropdown -->
{{--
          <!-- Notifications Dropdown -->
          <div class="dropdown d-inline-block ms-2">
            <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-fw fa-bell"></i>
              <span class="text-primary">•</span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 border-0 fs-sm" aria-labelledby="page-header-notifications-dropdown">
              <div class="p-2 bg-body-light border-bottom text-center rounded-top">
                <h5 class="dropdown-header text-uppercase">Notifications</h5>
              </div>
              <ul class="nav-items mb-0">
                <li>
                  <a class="text-dark d-flex py-2" href="javascript:void(0)">
                    <div class="flex-shrink-0 me-2 ms-3">
                      <i class="fa fa-fw fa-check-circle text-success"></i>
                    </div>
                    <div class="flex-grow-1 pe-2">
                      <div class="fw-semibold">You have a new follower</div>
                      <span class="fw-medium text-muted">15 min ago</span>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="text-dark d-flex py-2" href="javascript:void(0)">
                    <div class="flex-shrink-0 me-2 ms-3">
                      <i class="fa fa-fw fa-plus-circle text-primary"></i>
                    </div>
                    <div class="flex-grow-1 pe-2">
                      <div class="fw-semibold">1 new sale, keep it up</div>
                      <span class="fw-medium text-muted">22 min ago</span>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="text-dark d-flex py-2" href="javascript:void(0)">
                    <div class="flex-shrink-0 me-2 ms-3">
                      <i class="fa fa-fw fa-times-circle text-danger"></i>
                    </div>
                    <div class="flex-grow-1 pe-2">
                      <div class="fw-semibold">Update failed, restart server</div>
                      <span class="fw-medium text-muted">26 min ago</span>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="text-dark d-flex py-2" href="javascript:void(0)">
                    <div class="flex-shrink-0 me-2 ms-3">
                      <i class="fa fa-fw fa-plus-circle text-primary"></i>
                    </div>
                    <div class="flex-grow-1 pe-2">
                      <div class="fw-semibold">2 new sales, keep it up</div>
                      <span class="fw-medium text-muted">33 min ago</span>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="text-dark d-flex py-2" href="javascript:void(0)">
                    <div class="flex-shrink-0 me-2 ms-3">
                      <i class="fa fa-fw fa-user-plus text-success"></i>
                    </div>
                    <div class="flex-grow-1 pe-2">
                      <div class="fw-semibold">You have a new subscriber</div>
                      <span class="fw-medium text-muted">41 min ago</span>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="text-dark d-flex py-2" href="javascript:void(0)">
                    <div class="flex-shrink-0 me-2 ms-3">
                      <i class="fa fa-fw fa-check-circle text-success"></i>
                    </div>
                    <div class="flex-grow-1 pe-2">
                      <div class="fw-semibold">You have a new follower</div>
                      <span class="fw-medium text-muted">42 min ago</span>
                    </div>
                  </a>
                </li>
              </ul>
              <div class="p-2 border-top text-center">
                <a class="d-inline-block fw-medium" href="javascript:void(0)">
                  <i class="fa fa-fw fa-arrow-down me-1 opacity-50"></i> Load More..
                </a>
              </div>
            </div>
          </div>
          <!-- END Notifications Dropdown --> --}}
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
    @section('css_before')
        <!-- Page JS Plugins CSS -->
            <link rel="stylesheet" href="{{ url('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
            <link rel="stylesheet" href="{{ url('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    @endsection

    @section('js_after')
        <!-- jQuery (required for DataTables plugin) -->
            <script src="{{ url('js/lib/jquery.min.js') }}"></script>

            <!-- Page JS Plugins -->
            <script src="{{ url('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
            <script src="{{ url('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
            <script src="{{ url('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
            <script src="{{ url('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
            <script src="{{ url('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
            <script src="{{ url('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
            <script src="{{ url('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
            <script src="{{ url('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
            <script src="{{ url('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

            <!-- Page JS Code -->
            <script src="{{ url('js/pages/tables_datatables.js') }}"></script>
        @endsection
        @include('application::messages.notification')
    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer" class="" style="background: rgba(0, 0, 0, 0.7) !important">
      <div class="content py-3">
        <div class="row fs-sm" style="color: white; !mportant">
          <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
            Designed by <a class="fw-semibold"  style="color: gold;" href="https://support.tum.ac.ke/" target="_blank">TUM ICTS</a>
          </div>
          <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
            <a class="fw-semibold" href="https://www.tum.ac.ke/" style="color: gold;" target="_blank">Technical University of Mombasa</a> &copy; <span data-toggle="year-copy"></span>
          </div>
        </div>
      </div>
    </footer>
    <!-- END Footer -->
  </div>
  <!-- END Page Container -->

  <script src="{{ url("js/oneui.app.js") }}"></script>


  <!-- Laravel Scaffolding JS -->
  <!-- <script src="{{ mix('/js/laravel.app.js') }}"></script> -->

  @yield('js_after')
</body>

</html>
