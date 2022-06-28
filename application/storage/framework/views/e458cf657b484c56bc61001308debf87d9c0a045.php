

<?php $__env->startSection('content'); ?>
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <div class="h5 fw-bold mb-0">
                <h5>DEPARTMENTS</h5>
            </div>
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
<main id="main-container">
    <!-- Page Content -->

      <!-- Dynamic Table Responsive -->
      <div class="block block-rounded">

        <div class="block-content block-content-full">
          <div class="row">
            <div class="col-12">
          <table class="table table-borderless table-striped table-vcenter js-dataTable-responsive">
            <span class="d-flex justify-content-end">
                <a class="btn btn-alt-info btn-sm" href="<?php echo e(route('courses.addDepartment')); ?>">Create</a>
            </span><br>
            <thead>

              <tr>
                <th tyle="text-transform: uppercase">Schools</th>
                <th tyle="text-transform: uppercase">Departments</th>
                  <th colspan="3" class="text-center" >Action</th>

              </tr>

            </thead>
            <tbody><?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td style="text-transform: uppercase"> <?php echo e($department->school_id); ?></td>
                <td style="text-transform: uppercase"> <?php echo e($department->name); ?></td>
                <td> <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('courses.editDepartment', $department->id)); ?>">edit</a> </td>
                <td> <a class="btn btn-sm btn-alt-danger" href="<?php echo e(route('courses.destroyDepartment', $department->id)); ?>">delete</a> </td>
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
    <!-- END Page Content -->
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sims\application\Modules/Courses\Resources/views/department/showDepartment.blade.php ENDPATH**/ ?>