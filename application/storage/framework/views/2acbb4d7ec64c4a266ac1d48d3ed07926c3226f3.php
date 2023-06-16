<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Admissions
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Admissions</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Approvals
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-12">
                    <table id="example" class="table table-responsive table-md table-striped table-bordered table-vcenter fs-sm">
                            <thead>
                            <th>#</th>
                            <th>Applicant Name</th>
                            <th>Department</th>
                            <th>Course Name</th>
                            <th>Stud. Type</th>
                            <th>Status</th>

                            <th style="white-space: nowrap !important;">Action</th>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $admission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td nowrap=""> <?php echo e($app->sname); ?> <?php echo e($app->fname); ?> <?php echo e($app->mname); ?> </td>
                                    <td> <?php echo e($app->admissionCourse->getCourseDept->name); ?></td>
                                    <td> <?php echo e($app->admissionCourse->course_name); ?></td>
                                    <td>
                                        <?php if($app->student_type == 1): ?>
                                            S-FT
                                        <?php elseif($app->student_type == 2): ?>
                                            J-FT
                                        <?php else: ?>
                                            S-PT
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($app->registrar_status == 0): ?>
                                            <span class="badge bg-primary"> <i class="fa fa-spinner"></i> pending</span>
                                        <?php elseif($app->registrar_status == 1): ?>
                                            <span class="badge bg-success"> <i class="fa fa-check"></i> enrolled</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"> <i class="fa fa-close"></i> rejected</span>
                                        <?php endif; ?>
                                    </td>
                                    <td nowrap="">
                                        <?php if($app->registrar_status == 0): ?>
                                            <a class="btn btn-sm btn-alt-success" data-toggle="click-ripple" onclick="return confirm('Are you sure you want to erroll this student?')" href="<?php echo e(route('courses.admitStudent', ['id' => $app->application_id])); ?>"> Enroll </a>
                                            <a class="btn btn-sm btn-alt-danger m-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin-<?php echo e($app->application_id); ?>"> Reject </a>
                                            <div class="modal fade" id="modal-block-popin-<?php echo e($app->application_id); ?>" tabindex="-1" role="dialog" aria-labelledby="modal-block-popin<?php echo e($app->application_id); ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-popin" role="document">
                                                    <div class="modal-content">
                                                        <div class="block block-rounded block-transparent mb-0">
                                                            <div class="block-header block-header-default">
                                                                <h3 class="block-title">Reason(s) for rejecting <?php echo e($app->sname); ?>'s admission </h3>
                                                                <div class="block-options">
                                                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                                                        <i class="fa fa-fw fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="block-content fs-sm">
                                                                <form action="<?php echo e(route('courses.rejectAdmissions', ['id' => $app->application_id])); ?>" method="post">
                                                                    <?php echo csrf_field(); ?>
                                                                    <div class="row col-md-12 mb-3">
                                                                        <textarea class="form-control" placeholder="Write down the reasons for declining this application" name="comment" required></textarea>
                                                                        <input type="hidden" name="<?php echo e($app->application_id); ?>">
                                                                    </div>
                                                                    <div class="d-flex justify-content-center mb-2">
                                                                        <button type="submit" class="btn btn-alt-danger btn-sm">Reject</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="block-content block-content-full text-end bg-body">
                                                                <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php elseif($app->registrar_status == 1): ?>
                                            <a class="btn btn-sm btn-alt-info disabled" href="<?php echo e(route('cod.reviewAdmission', $app->application_id)); ?>"> Edit </a>
                                        <?php else: ?>
                                            <a class="btn btn-sm btn-alt-info disabled" href="<?php echo e(route('cod.reviewAdmission', $app->application_id)); ?>"> Edit </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            responsive: true,
            order: [[6, 'desc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );
</script>



<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Registrar\Resources/views/admissions/index.blade.php ENDPATH**/ ?>