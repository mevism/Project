

<?php $__env->startSection('content'); ?>
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
            <div class="flex-grow-1">
                <h5 class="h5 fw-bold mb-0">
                    COURSES
                </h5>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Courses</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        View courses
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>


 <!-- Main Container -->
 <main id="main-container">
  <!-- Page Content -->


    <!-- Dynamic Table Responsive -->
    <div class="block block-rounded">

      <div class="block-content block-content-full">
        <div class="row">
          <div class="col-12">
        <!-- DataTables init on table by adding .js-dataTable-responsive class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
        <table class="table table-borderless table-striped table-vcenter js-dataTable-responsive">
          <span class="d-flex justify-content-end">
            <a class="btn btn-alt-info btn-sm" href="<?php echo e(route('courses.addCourse')); ?>">Create</a>
        </span><br>
          <thead>
            <tr>
              <th>  Schools     </th>
              <th>  Departments </th>
              <th> Course       </th>
              <th colspan="3" class="text-center" >Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courses): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td style="text-transform: uppercase" ><?php echo e($courses->school_id); ?></td>
              <td style="text-transform: uppercase" ><?php echo e($courses->department_id); ?></td>
              <td style="text-transform: uppercase" ><?php echo e($courses->course_name); ?></td>
              <td> <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('courses.editCourse', $courses->id)); ?>">edit</a> </td>
              <td> <a class="btn btn-sm btn-alt-danger" href="<?php echo e(route('courses.destroyCourse', $courses->id)); ?>">delete</a> </td>
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
<!-- END Main Container -->


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sims\application\Modules/Courses\Resources/views/course/showCourse.blade.php ENDPATH**/ ?>