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
                        <?php if(count($applicant)>0): ?>
                            <thead>
                                <th></th>
                            <th>Applicant Name</th>
                            <th>Course Name</th>
                            <th>Student Type</th>
                            <th>Status</th>
                            <th style="white-space: nowrap !important;">Action</th>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $applicant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td> <?php echo e(++$key); ?></td>
                                    <td> <?php echo e($app->applicant->sname); ?> <?php echo e($app->applicant->fname); ?> <?php echo e($app->applicant->mname); ?> </td>
                                    <td> <?php echo e($app->courses->course_name); ?></td>
                                    <td>
                                        <?php if($app->applicant->student_type == 1): ?>
                                            S-FT
                                        <?php elseif($app->applicant->student_type == 2): ?>
                                            J-FT
                                        <?php else: ?>
                                            S-PT
                                        <?php endif; ?>
                                    </td>
                                    <td>

                                        <?php if($app->approveAdm == NULL): ?>
                                            <span class="badge bg-warning"> <i class="fa fa-clock-o"></i> Not submitted</span>
                                        <?php else: ?>
                                            <?php if($app->approveAdm->cod_status == 0): ?>
                                                <span class="badge bg-primary"> <i class="fa fa-spinner"></i> Awaiting </span>
                                            <?php elseif($app->approveAdm->cod_status == 1): ?>
                                                <span class="badge bg-success"> <i class="fa fa-check-double"></i> Accepted </span>
                                                <?php elseif($app->approveAdm->cod_status == 2): ?>
                                                <span class="badge bg-danger"> <i class="fa fa-ban"></i> Rejected </span>
                                            <?php else: ?>
                                                <span class="badge bg-info"> <i class="fa fa-ban"></i> Withheld </span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td nowrap="">
                                            <?php if($app->approveAdm == NULL): ?>
                                                    <a class="btn btn-sm btn-alt-info disabled" href="<?php echo e(route('cod.reviewAdmission', ['id' => Crypt::encrypt($app->id)])); ?>"> Verify </a>
                                            <?php elseif($app->approveAdm->cod_status == 0): ?>
                                            <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('cod.reviewAdmission', ['id' => Crypt::encrypt($app->id)])); ?>"> Verify </a>
                                            <?php elseif($app->approveAdm->cod_status == 1): ?>
                                                <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('cod.reviewAdmission', ['id' => Crypt::encrypt($app->id)])); ?>"> Edit </a>
                                                <a class="btn btn-sm btn-alt-success" data-toogle="click-ripple" onclick="return confirm('Are you sure you want to submit this record?')" href="<?php echo e(route('cod.submitAdmission', ['id' => Crypt::encrypt($app->id)])); ?>"> Submit </a>
                                            <?php else: ?>
                                                    <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('cod.reviewAdmission', ['id' => Crypt::encrypt($app->id)])); ?>"> Edit </a>

                                            <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        <?php else: ?>
                            <tr>
                                <span class="text-muted text-center fs-sm">There are no new applications submitted</span>
                            </tr>
                        <?php endif; ?>
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
            order: [[5, 'asc']],
            rowGroup: {
                dataSrc: 2
            },

        } );
    } );
</script>

<?php echo $__env->make('cod::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Registrar/application/Modules/COD/Resources/views/admissions/index.blade.php ENDPATH**/ ?>