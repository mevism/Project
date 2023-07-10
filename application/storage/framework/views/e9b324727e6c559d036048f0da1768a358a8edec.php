<!doctype html>
<html lang="<?php echo e(config('app.locale')); ?>">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  <title><?php echo e(config('app.name')); ?></title>

  <meta name="description" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
  <meta name="author" content="pixelcave">
  <meta name="robots" content="noindex, nofollow">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <!-- Icons -->
  <link rel="shortcut icon" href="<?php echo e(asset('media/favicons/favicon.png')); ?>">
  <link rel="icon" sizes="192x192" type="image/png" href="<?php echo e(asset('media/favicons/favicon-192x192.png')); ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('media/favicons/apple-touch-icon-180x180.png')); ?>">

  <!-- Fonts and Styles -->
  <?php echo $__env->yieldContent('css_before'); ?>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" id="css-main" href="<?php echo e(url('/css/oneui.css')); ?>">

  <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
  <!-- <link rel="stylesheet" id="css-theme" href="<?php echo e(mix('/css/themes/amethyst.css')); ?>"> -->
  <?php echo $__env->yieldContent('css_after'); ?>

  <!-- Scripts -->
  <script>
    window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>;
  </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

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
          <span class="smini-hide fs-5 tracking-wider"><span class="fw-normal"><?php echo e(config('app.name')); ?></span></span>
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
              <a class="nav-main-link<?php echo e(request()->is('dashboard') ? ' active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                <i class="nav-main-link-icon si si-cursor"></i>
                <span class="nav-main-link-name">

                    <?php if(auth()->guard('user')->user()->hasRole('Registrar')): ?>
                        Registry
                    <?php endif; ?>
                </span>
              </a>
            </li>
            <li class="nav-main-item<?php echo e(request()->is('intakes/*') ? ' open' : ''); ?>">
              <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                <i class="nav-main-link-icon si si-graduation"></i>
                <span class="nav-main-link-name">Academics</span>
              </a>
              <ul class="nav-main-submenu">
                <li class="nav-main-item<?php echo e(request()->is('intakes/*') ? ' open' : ''); ?>">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                    <i class="nav-main-link-icon si si-graduation"></i>
                    <span class="nav-main-link-name">Schedule</span>
                  </a>
                    <ul class="nav-main-submenu">
                      <li class="nav-main-item">
                        <a class="nav-main-link<?php echo e(request()->is('school/showSchool') ? ' active' : ''); ?>" href="<?php echo e(route('courses.showSchool')); ?>">
                          <i class="nav-main-link-icon si si-graduation"></i>
                            <span class="nav-main-link-name">Schools</span>
                        </a>
                      </li>
                      <li class="nav-main-item">
                        <a class="nav-main-link<?php echo e(request()->is('department/showDepartment') ? ' active' : ''); ?>" href="<?php echo e(route('courses.showDepartment')); ?>">
                          <i class="nav-main-link-icon si si-user"></i>
                          <span class="nav-main-link-name">Department</span>
                        </a>
                      </li>
                      <li class="nav-main-item">
                          <a class="nav-main-link<?php echo e(request()->is('courses/showCourse') ? ' active' : ''); ?>" href="<?php echo e(route('courses.showCourse')); ?>">
                            <i class="nav-main-link-icon si si-layers"></i>
                              <span class="nav-main-link-name">Courses</span>
                          </a>
                      </li>
                      <li class="nav-main-item">
                        <a class="nav-main-link<?php echo e(request()->is('attendance/index') ? ' active' : ''); ?>" href="<?php echo e(route('courses.showAttendance')); ?>">
                          <i class="nav-main-link-icon si si-layers"></i>
                          <span class="nav-main-link-name">Mode of Study</span>
                        </a>
                      </li>
                    </ul>
                </li>
                <li class="nav-main-item<?php echo e(request()->is('intakes/*') ? ' open' : ''); ?>">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                    <i class="nav-main-link-icon si si-graduation"></i>
                    <span class="nav-main-link-name">Imports</span>
                  </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                          <a class="nav-main-link<?php echo e(request()->is('classes/index') ? ' active' : ''); ?>" href="<?php echo e(route('courses.importUnit')); ?>">
                            <i class="nav-main-link-icon si si-layers"></i>
                            <span class="nav-main-link-name"> Units</span>
                          </a>
                        </li>
                        <li class="nav-main-item">
                          <a class="nav-main-link<?php echo e(request()->is('classes/index') ? ' active' : ''); ?>" href="<?php echo e(route('courses.importExportCourses')); ?>">
                            <i class="nav-main-link-icon si si-layers"></i>
                            <span class="nav-main-link-name">Courses</span>
                          </a>
                        </li>
                        <li class="nav-main-item">
                          <a class="nav-main-link<?php echo e(request()->is('classes/index') ? ' active' : ''); ?>" href="<?php echo e(route('courses.importExportclusterWeights')); ?>">
                            <i class="nav-main-link-icon si si-layers"></i>
                            <span class="nav-main-link-name"> Cluster Weights</span>
                          </a>
                        </li>
                        <li class="nav-main-item">
                          <a class="nav-main-link<?php echo e(request()->is('classes/index') ? ' active' : ''); ?>" href="<?php echo e(route('courses.importUnitProgramms')); ?>">
                            <i class="nav-main-link-icon si si-layers"></i>
                            <span class="nav-main-link-name"> Unit Programs</span>
                          </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-main-item<?php echo e(request()->is('calender/*') ? ' open' : ''); ?>">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                    <i class="nav-main-link-icon si si-calendar"></i>
                    <span class="nav-main-link-name">Events Calender</span>
                  </a>
                  <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                      <a class="nav-main-link<?php echo e(request()->is('attendance/index') ? ' active' : ''); ?>" href="<?php echo e(route('courses.showEvent')); ?>">
                        <i class="nav-main-link-icon si si-layers"></i>
                        <span class="nav-main-link-name"> Events</span>
                      </a>
                    </li>

                    <li class="nav-main-item">
                      <a class="nav-main-link<?php echo e(request()->is('attendance/index') ? ' active' : ''); ?>" href="<?php echo e(route('courses.showCalenderOfEvents')); ?>">
                        <i class="nav-main-link-icon si si-calendar"></i>
                        <span class="nav-main-link-name"> Calender of Events</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link<?php echo e(request()->is('intake/showIntake') ? ' active' : ''); ?>" href="<?php echo e(route('courses.academicYear')); ?>">
                          <i class="nav-main-link-icon si si-calendar"></i>
                          <span class="nav-main-link-name">Academic Years</span>
                      </a>
                  </li>

                  </ul>
                </li>
                <li class="nav-main-item<?php echo e(request()->is('semFee/*') ? ' open' : ''); ?>">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                    <i class="nav-main-link-icon si si-user"></i>
                    <span class="nav-main-link-name">Fee Structures</span>
                  </a>
                  <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                      <a class="nav-main-link<?php echo e(request()->is('attendance/index') ? ' active' : ''); ?>" href="<?php echo e(route('courses.showSemFee')); ?>">
                        <i class="nav-main-link-icon si si-layers"></i>
                        <span class="nav-main-link-name"> Course Fee Structures</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link<?php echo e(request()->is('attendance/index') ? ' active' : ''); ?>" href="<?php echo e(route('courses.showVoteheads')); ?>">
                        <i class="nav-main-link-icon si si-layers"></i>
                        <span class="nav-main-link-name"> Voteheads</span>
                      </a>
                    </li>

                  </ul>
                </li>
              </ul>
            </li>
            <li class="nav-main-item<?php echo e(request()->is('intakes/*') ? ' open' : ''); ?>">
              <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                <i class="nav-main-link-icon si si-user"></i>
                <span class="nav-main-link-name">Applications</span>
              </a>
              <ul class="nav-main-submenu">
                <li class="nav-main-item">
                  <a class="nav-main-link<?php echo e(request()->is('applications') ? ' active' : ''); ?>" href="<?php echo e(route('courses.applications')); ?>">
                    <i class="nav-main-link-icon si si-user"></i>
                    <span class="nav-main-link-name">
                       Self Sponsored
                    </span>

                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link<?php echo e(request()->is('showKuccps') ? ' active' : ''); ?>" href="<?php echo e(route('courses.showKuccps')); ?>">
                    <i class="nav-main-link-icon si si-user"></i>
                    <span class="nav-main-link-name">
                       Government Sponsored
                    </span>

                  </a>
                </li>

                <li class="nav-main-item">
                  <a class="nav-main-link<?php echo e(request()->is('archived') ? ' active' : ''); ?>" href="<?php echo e(route('courses.archived')); ?>">
                    <i class="nav-main-link-icon si si-user"></i>
                    <span class="nav-main-link-name">
                       Archived
                    </span>

                  </a>
                </li>

                <li class="nav-main-item">
                  <a class="nav-main-link<?php echo e(request()->is('importExportViewkuccps') ? ' active' : ''); ?>" href="<?php echo e(route('courses.importExportViewkuccps')); ?>">
                    <i class="nav-main-link-icon si si-user"></i>
                    <span class="nav-main-link-name">
                       Import File
                    </span>

                  </a>
                </li>


              </ul>
            </li>
              <li class="nav-main-item<?php echo e(request()->is('intakes/*') ? ' open' : ''); ?>">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                      <i class="nav-main-link-icon si si-user"></i>
                      <span class="nav-main-link-name">Admissions</span>
                  </a>
                  <ul class="nav-main-submenu">
                      <li class="nav-main-item">
                          <a class="nav-main-link<?php echo e(request()->is('applications') ? ' active' : ''); ?>" href="<?php echo e(route('courses.admissions')); ?>">
                              <i class="nav-main-link-icon si si-user"></i>
                              <span class="nav-main-link-name"> View Admissions </span>
                          </a>
                      </li>
                  </ul>
              </li>

            <li class="nav-main-item<?php echo e(request()->is('intakes/*') ? ' open' : ''); ?>">
              <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                  <i class="nav-main-link-icon si si-user"></i>
                  <span class="nav-main-link-name"> Student Progression</span>
              </a>
              <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link<?php echo e(request()->is('transfer') ? ' active' : ''); ?>" href="<?php echo e(route('courses.yearly')); ?>">
                        <i class="nav-main-link-icon si si-user"></i>
                        <span class="nav-main-link-name"> Course Transfer </span>
                    </a>
                </li>
            </ul>
              <ul class="nav-main-submenu">

                  <li class="nav-main-item">
                      <a class="nav-main-link<?php echo e(request()->is('transfer') ? ' active' : ''); ?>" href="<?php echo e(route('courses.leaves')); ?>">
                          <i class="nav-main-link-icon si si-user"></i>
                          <span class="nav-main-link-name"> Academic Leave</span>
                      </a>
                  </li>
              </ul>
              <ul class="nav-main-submenu">

                <li class="nav-main-item">
                    <a class="nav-main-link<?php echo e(request()->is('transfer') ? ' active' : ''); ?>" href="<?php echo e(route('courses.readmissions')); ?>">
                        <i class="nav-main-link-icon si si-user"></i>
                        <span class="nav-main-link-name"> Readmission</span>
                    </a>
                </li>
            </ul>
          </li>
          <li class="nav-main-item<?php echo e(request()->is('intakes/*') ? ' open' : ''); ?>">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                <i class="nav-main-link-icon si si-user"></i>
                <span class="nav-main-link-name">Workloads</span>
            </a>
            <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link<?php echo e(request()->is('applications') ? ' active' : ''); ?>" href="<?php echo e(route('courses.workload')); ?>">
                        <i class="nav-main-link-icon si si-user"></i>
                        <span class="nav-main-link-name"> view Workload </span>
                    </a>
                </li>
            </ul>
        </li>

            <li class="nav-main-item<?php echo e(request()->is('intakes/*') ? ' open' : ''); ?>">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                    <i class="nav-main-link-icon si si-user"></i>
                    <span class="nav-main-link-name">Admin</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link<?php echo e(request()->is('applications') ? ' active' : ''); ?>" href="<?php echo e(route('admin.users')); ?>">
                            <i class="nav-main-link-icon si si-user"></i>
                            <span class="nav-main-link-name"> Users </span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link<?php echo e(request()->is('applications') ? ' active' : ''); ?>" href="<?php echo e(route('admin.showDepartment')); ?>">
                            <i class="nav-main-link-icon si si-user"></i>
                            <span class="nav-main-link-name"> Departments </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item<?php echo e(request()->is('intakes/*') ? ' open' : ''); ?>">
              <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                  <i class="nav-main-link-icon si si-user"></i>
                  <span class="nav-main-link-name">Examination</span>
              </a>
              <ul class="nav-main-submenu">
                  <li class="nav-main-item">
                      <a class="nav-main-link<?php echo e(request()->is('applications') ? ' active' : ''); ?>" href="<?php echo e(route('courses.yearlyExamMarks')); ?>">
                          <i class="nav-main-link-icon si si-user"></i>
                          <span class="nav-main-link-name"> View Exams </span>
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
              <img class="rounded-circle" src="<?php echo e(asset('media/avatars/male.png')); ?>" alt="Header Avatar" style="width: 21px;">
              <span class="d-none d-sm-inline-block ms-2">
                  <?php
                    $user = auth()->guard('user')->user()->staffInfos;
                  ?>

                  <?php if(auth()->guard('user')->check()): ?>
                      <?php echo e($user->title); ?> <?php echo e($user->last_name); ?>

                  <?php endif; ?>
              </span>
              <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block ms-1 mt-1"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0" aria-labelledby="page-header-user-dropdown">
              <div class="p-3 text-center bg-body-dark border-bottom rounded-top">
                <img class="img-avatar img-avatar48 img-avatar-thumb" src="<?php echo e(asset('media/avatars/male.png')); ?>" alt="">
                <p class="mt-2 mb-0 fw-medium">
           
                    <?php if(auth()->guard('user')->check()): ?>
                        <?php echo e($user->title); ?> <?php echo e($user->last_name); ?> <?php echo e($user->first_name); ?> <?php echo e($user->middle_name); ?>

                    <?php endif; ?> </p>
                <p class="mb-0 text-muted fs-sm fw-medium">
                    <?php if(auth()->guard('user')->user()->hasRole('Registrar')): ?>
                        Registrar
                  <?php endif; ?>
              </div>
              
              <div role="separator" class="dropdown-divider m-0"></div>
              <div class="p-2">
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="<?php echo e(route('logout')); ?>">
                  <span class="fs-sm fw-medium">Sign Out</span>
                </a>
              </div>
            </div>
          </div>
          <!-- END User Dropdown -->

        </div>
        <!-- END Right Section -->
      </div>
      <!-- END Header Content -->

      <!-- Header Search -->
      <div id="page-header-search" class="overlay-header bg-body-extra-light">
        <div class="content-header">
          <form class="w-100" action="/dashboard" method="POST">
            <?php echo csrf_field(); ?>
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

      <?php $__env->startSection('css_before'); ?>
        <!-- Page JS Plugins CSS -->
            <link rel="stylesheet" href="<?php echo e(url('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(url('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css')); ?>">
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('js_after'); ?>
        <!-- jQuery (required for DataTables plugin) -->
            <script src="<?php echo e(url('js/lib/jquery.min.js')); ?>"></script>

            <!-- Page JS Plugins -->
            <script src="<?php echo e(url('js/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
            <script src="<?php echo e(url('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js')); ?>"></script>
            <script src="<?php echo e(url('js/plugins/datatables-buttons/dataTables.buttons.min.js')); ?>"></script>
            <script src="<?php echo e(url('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js')); ?>"></script>
            <script src="<?php echo e(url('js/plugins/datatables-buttons-jszip/jszip.min.js')); ?>"></script>
            <script src="<?php echo e(url('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js')); ?>"></script>
            <script src="<?php echo e(url('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js')); ?>"></script>
            <script src="<?php echo e(url('js/plugins/datatables-buttons/buttons.print.min.js')); ?>"></script>
             <script src="<?php echo e(url('js/plugins/datatables-buttons/buttons.html5.min.js')); ?>"></script>

            <!-- Page JS Code -->
            <script src="<?php echo e(url('js/pages/tables_datatables.js')); ?>"></script>
        <?php $__env->stopSection(); ?>

      <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->make('application::messages.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

  <!-- OneUI Core JS -->
  <script src="<?php echo e(url('js/oneui.app.js')); ?>"></script>

  <!-- Laravel Scaffolding JS -->
  <!-- <script src="<?php echo e(mix('/js/laravel.app.js')); ?>"></script> -->


  <?php echo $__env->yieldContent('js_after'); ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\project1\application\Modules/Registrar\Resources/views/layouts/backend.blade.php ENDPATH**/ ?>