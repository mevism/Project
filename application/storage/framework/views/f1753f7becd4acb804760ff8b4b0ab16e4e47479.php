<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-1">
                        Courses
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Courses</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            My Courses
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <table id="example" class="table table-md table-striped table-bordered table-vcenter fs-sm">
                        <?php if(count($courses)>0): ?>
                            <thead>
                            <tr>
                                <th>Department</th>
                                <th>Course</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($course->courses->department_id); ?></td>
                                    <td><?php echo e($course->courses->course_name); ?></td>
                                    <td nowrap="">
                                        <?php if($course->registrar_status === 3 && $course->cod_status === 1): ?>
                                        <a class="btn btn-sm btn-alt-success" target="_top" href="<?php echo e(route('application.download', $course->id)); ?>"><i class="fa fa-file-pdf"></i> download</a>
                                        <?php elseif($course->registrar_status === NULL && $course->finance_status === NULL): ?>
                                        <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('application.edit', $course->id)); ?>">
                                            <i class="fa fa-pen-to-square"></i> update</a>
                                        <?php elseif($course->registrar_status === 1 && $course->cod_status === 2): ?>
                                            <a class="btn btn-sm btn-alt-danger" href="#">
                                                <i class="fa fa-ban"></i> rejected</a>
                                        <?php else: ?>
                                            <a class="btn btn-sm btn-alt-secondary" href="<?php echo e(route('application.progress', $course->id)); ?>"> <i class="fa fa-spinner"></i> in progress</a>
                                    <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        <?php else: ?>
                            <small class="text-center text-muted"> You have not submitted any applications</small>
                        <?php endif; ?>
                    </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>
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

<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Finale/application/Modules/Application/Resources/views/applicant/mycourses.blade.php ENDPATH**/ ?>