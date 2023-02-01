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
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        <?php echo e(strtoupper(\Carbon\Carbon::parse($intake->intake_from)->format('MY') )); ?> CLASSES
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Department</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Classes
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
                    <table id="example" class="table table-sm table-bordered table-striped table-vcenter js-dataTable-responsive fs-sm">
                        <thead>
                        <td>#</td>
                        <th>Class Name</th>
                        <th>Course Code</th>
                        <th>Study Mode</th>
                        <th>Class Pattern</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>

                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $intakes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $intakes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php ++$i ?>
                                <tr>
                                  <td> <?php echo e($i); ?> </td>
                                  <td> <?php echo e($class->name); ?> </td>
                                  <td> <?php echo e($class->classCourse->course_code); ?> </td>
                                  <td> <?php echo e($class->attendance_code); ?> </td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-info" href="<?php echo e(route('cod.classPattern', ['id' => Crypt::encrypt($class->id)])); ?>">View Pattern</a>
                                    </td>
                                    <td nowrap="">
                                        <a class="btn btn-sm btn-alt-info disabled" href="<?php echo e(route('courses.editClasses', ['id' => Crypt::encrypt($class->id)])); ?>">edit</a>
                                        <a class="btn btn-sm btn-alt-danger disabled" onclick="return confirm('Are you sure you want to delete this course ?')" href="<?php echo e(route('courses.destroyClasses', ['id' => Crypt::encrypt($class->id)])); ?>">delete</a>
                                        <a class="btn btn-sm btn-alt-secondary" href="<?php echo e(route('department.classList', ['id' => Crypt::encrypt($class->id)])); ?>">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- Dynamic Table Responsive -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cod::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Courses/application/Modules/COD/Resources/views/classes/intakeClasses.blade.php ENDPATH**/ ?>