

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

<script>
  $(document).ready(function() {
      $('#example').DataTable( {
          responsive: true,
          order: [[2, 'asc']],
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
            <div class="flex-grow-1">
                <h5 class="h5 fw-bold mb-0">
                    CLASSES
                </h5>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Classes</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        View classes
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

      <div class="block block-rounded">

        <div class="block-content block-content-full">
          <div class="row">
            <div class="col-12">
          <table id="example" class="table table-bordered table-striped table-vcenter js-dataTable-responsive">
            <span class="d-flex justify-content-end">
                <a class="btn btn-alt-info btn-sm" href="<?php echo e(route('courses.addClasses')); ?>">Create</a>
            </span><br>
            <thead>
                <th>Classes</th>
                <th>Attendance</th>
                <th>Course</th>
                <th>Action</th>
            </thead>
            <tbody>
              <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>

                <td class="fw-semibold fs-sm text-uppercase"><?php echo e($class->name); ?></td>
                <td class="fw-semibold fs-sm"><?php echo e($class->attendance_id); ?></td>
                <td style="text-transform: uppercase"class="fw-semibold fs-sm"><?php echo e($class->course_id); ?></td>
                <td>
                  <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('courses.editClasses', $class->id)); ?>">edit</a>
                <a class="btn btn-sm btn-alt-danger" href="<?php echo e(route('courses.destroyClasses', $class->id)); ?>">delete</a>
              </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tbody>
          </table>
          <?php echo e($data->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
      </div>
      <!-- Dynamic Table Responsive -->
    </div>
<?php $__env->stopSection(); ?>












<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp\htdocs\courses\project\application\Modules/Registrar\Resources/views/class/showClasses.blade.php ENDPATH**/ ?>