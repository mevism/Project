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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        READMISSION
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="<?php echo e(route('student')); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            ALL READMISSION REQUESTS
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <div class="d-flex justify-content-end mb-4">
                    <a class="btn btn-sm btn-alt-primary m-2" href="<?php echo e(route('student.readmisionrequest')); ?>">Create request</a>
                </div>
                <table id="example"  class="table table-sm table-striped table-bordered fs-sm">
                    <thead>
                    <th>#</th>
                    <th nowrap=""> Leave Type </th>
                    <th>REQUEST TO JOIN</th>
                    <th>JOIN AT STAGE</th>
                    <th>JOIN ON </th>
                    <th nowrap="">REQUESTED ON</th>
                    <th nowrap=""> Status</th>
                    <th nowrap=""> Action</th>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $readmits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $readmit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(++$key); ?> </td>
                            <td>
                                <?php if($readmit->leaves->type == 1): ?>
                                    ACADEMIC LEAVE
                                <?php elseif($readmit->leaves->type == 2): ?>
                                    DEFERMENT
                                <?php elseif($readmit->leaves->type == 3): ?>
                                    SUSPENSION
                                <?php else: ?>
                                    DISCONTINUATION
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($readmit->leaves->deferredClass->deferred_class); ?></td>
                            <td><?php echo e($readmit->leaves->deferredClass->stage); ?></td>
                            <td>
                                <span class="fw-semibold"> Academic Year : </span> <?php echo e($readmit->leaves->deferredClass->academic_year); ?> <br>
                                <span class="fw-semibold"> Academic Sem. : </span> <?php echo e($readmit->leaves->deferredClass->semester_study); ?>

                            </td>
                            <td>
                                <span class="fw-semibold"> Academic Year : </span> <?php echo e($readmit->academic_year); ?> <br>
                                <span class="fw-semibold"> Academic Sem. : </span> <?php echo e($readmit->academic_semester); ?>

                            </td>
                            <td nowrap="">
                                <?php if($readmit->status == 0): ?>
                                    <?php if($readmit->readmissionApproval == null): ?>
                                        <span class="text-info">Pending</span>
                                    <?php else: ?>
                                        <span class="text-primary">Processing</span>
                                    <?php endif; ?>
                                <?php elseif($readmit->status == 1): ?>
                                    <span class="text-success"> Successful</span>
                                <?php else: ?>
                                    <span class="text-danger"> Unsuccessful</span>
                                <?php endif; ?>
                            </td>
                            <td nowrap="">
                                <?php if($readmit->status != NULL): ?>
                                    <?php if($readmit->status == 0): ?>
                                        <a class="btn btn-sm btn-outline-secondary" disabled=""> Processing </a>
                                    <?php else: ?>
                                        <a class="btn btn-sm btn-outline-success" disabled=""> Processed </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a class="btn btn-sm btn-alt-danger" href="#">Withdraw</a>
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

<?php echo $__env->make('student::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Courses/application/Modules/Student/Resources/views/academic/readmissions.blade.php ENDPATH**/ ?>