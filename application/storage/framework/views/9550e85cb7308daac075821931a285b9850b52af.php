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
            <div class="col-12 table-responsive">
                <table id="example" class="table table-sm table-striped table-bordered fs-sm">
                    <thead>
                    <th>#</th>
                    <th>Department</th>
                    <th>Course</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($course->courses->getCourseDept->name); ?></td>
                            <td><?php echo e($course->courses->course_name); ?></td>
                            <td nowrap="">
                                <?php if($course->applicationApproval == null): ?>
                                    <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('application.edit', $course->application_id)); ?>">
                                        <i class="fa fa-pen-to-square"></i> update</a>
                                <?php elseif($course->applicationApproval != null): ?>
                                    <?php if($course->applicationApproval->finance_status != null && $course->applicationApproval->cod_status == null): ?>
                                        <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('application.edit', $course->application_id)); ?>"> <i class="fa fa-pen-to-square"></i> update</a>
                                    <?php elseif($course->applicationApproval->cod_status == 1 && $course->applicationApproval->registrar_status == 3): ?>
                                        <a class="btn btn-sm btn-alt-success" target="_top" href="<?php echo e(route('application.download', $course->application_id)); ?>"><i class="fa fa-file-pdf"></i> download</a>
                                        <a class="btn btn-sm btn-alt-info" data-toggle="click-ripple" href="<?php echo e(route('application.uploadDocuments', $course->application_id)); ?>"><i class="fa fa-file-upload"></i> upload docs</a>
                                    <?php elseif($course->applicationApproval->cod_status == 2 && $course->applicationApproval->registrar_status == 3): ?>
                                        <a class="btn btn-sm btn-alt-danger" href="#"> <i class="fa fa-ban"></i> rejected</a>
                                    <?php elseif($course->applicationApproval->cod_status == null || $course->applicationApproval->cod_status != null): ?>
                                        <a class="btn btn-sm btn-alt-secondary disabled" href="#"> <i class="fa fa-spinner"></i> in progress </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
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

<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Application\Resources/views/applicant/mycourses.blade.php ENDPATH**/ ?>