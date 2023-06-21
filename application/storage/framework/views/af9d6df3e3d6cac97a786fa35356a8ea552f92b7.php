
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

    <link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    <link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

    <script>
      $(document).ready(function() {
          $('#example').DataTable( {
              responsive: true,
              order: [[0, 'asc']],
              rowGroup: {
                  dataSrc: 2
              }
          } );
      } );
    </script>
<?php $__env->startSection('content'); ?>
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h6 class="h6 fw-bold mb-0">
                DEPARTMENTS
            </h6>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Departments</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        View departments
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Dynamic Table Responsive -->
      <div class="block block-rounded">
        <div class="block-content block-content-full">
          <div class="row">
            <div class="col-12 table-responsive">
                <span class="d-flex justify-content-end m-2">
                <a class="btn btn-alt-info btn-sm" href="<?php echo e(route('admin.addDepartment')); ?>">Create</a>
                </span>
          <table id="example" class="table table-sm table-bordered table-striped fs-sm">
            <thead>

              <tr>
                <th>#</th>
                <th>division</th>
                <th>DEPARTMENT NAME</th>
                <th nowrap="">DEPT CODE</th>
                <th>HISTORY</th>
                <th>Action</th>
              </tr>

            </thead>
            <tbody>
              <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td> <?php echo e(++$key); ?> </td>
                <td> <?php echo e(strtoupper($department->division->name)); ?> </td>
                <td> <?php echo e($department->name); ?></td>
                <td> <?php echo e($department->dept_code); ?> </td>
                  <td>
                    <a class="btn btn-sm btn-alt-secondary" href="<?php echo e(route('courses.departmentPreview', $department->department_id)); ?>"> View </a>
                  </td>
                <td nowrap>
                  <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('courses.editDepartment', $department->department_id)); ?>">  edit <i class="fa fa-pencil"></i> </a>

                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tbody>
          </table>
        </div>
        </div>
      </div>
      <!-- Dynamic Table Responsive -->
    </div>
    <!-- END Page Content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\project\application\Modules/Administrator\Resources/views/department/showDepartment.blade.php ENDPATH**/ ?>