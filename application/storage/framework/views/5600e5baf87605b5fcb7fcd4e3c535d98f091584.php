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
                        ACADEMIC LEAVE
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="<?php echo e(route('student')); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            ALL ACADEMIC LEAVES
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
                    <a class="btn btn-sm btn-alt-primary m-2" href="<?php echo e(route('student.academicleaverequest')); ?>">Create request</a>
                </div>
                <table id="example"  class="table table-sm table-striped table-bordered fs-sm">
                    <thead>
                        <th>#</th>
                        <th nowrap=""> CURRENT CLASS </th>
                        <th>Stage</th>
                        <th nowrap="">Academic Year</th>
                        <th nowrap="">Leave Type</th>
                        <th nowrap="">From - To</th>
                        <th nowrap="">Reason(s)</th>
                        <th nowrap=""> Status</th>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(++$key); ?> </td>
                            <td> <?php echo e($leave->studentLeave->courseStudent->class_code); ?> </td>
                            <td> Y<?php echo e($leave->year_study); ?> S<?php echo e($leave->semester_study); ?> </td>
                            <td> <?php echo e($leave->academic_year); ?> </td>
                            <td nowrap="">
                                <?php if($leave->type == 1): ?>
                                    ACADEMIC LEAVE
                                <?php else: ?>
                                    DEFERMENT
                                <?php endif; ?>
                            </td>
                            <td nowrap=""> From : <?php echo e($leave->from); ?> <br> To : <?php echo e($leave->to); ?></td>
                            <td> <?php echo e($leave->reason); ?> </td>
                            <td nowrap="">
                                <?php if($leave->approveLeave == NULL): ?>
                                    <a class="btn btn-sm btn-alt-danger" href="<?php echo e(route('student.deleteleaverequest', ['id' => Crypt::encrypt($leave->id)])); ?>"> Withdraw </a>
                                <?php else: ?>
                                    <?php if($leave->approveLeave->status == 1): ?>
                                        <span class="text-success fw-bold"> Successful </span>
                                    <?php elseif($leave->approveLeave->status == 2): ?>
                                        <span class="text-danger fw-bold"> Unsuccessful</span>
                                    <?php else: ?>
                                        <span class="text-info fw-bold"> Processing</span>
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

<?php echo $__env->make('student::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Courses/application/Modules/Student/Resources/views/academic/academicleave.blade.php ENDPATH**/ ?>