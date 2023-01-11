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
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
            <div class="flex-grow-0">
                <h5 class="h5 fw-bold mb-0" >
                    <?php echo e($year); ?> COURSE TRANSFER
                </h5>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Transfer</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Transfer
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
                <div class="d-flex justify-content-end m-2">
                    <a class="btn  btn-alt-primary btn-sm" href="<?php echo e(route('dean.requestedTransfers', ['year' => Crypt::encrypt($year)])); ?>">Generate report</a>
                </div>
                <table id="example" class="table table-bordered table-striped fs-sm">
                    
                        <thead>
                            <th>#</th>
                            <th>Reg. Number</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>COD Remarks</th>
                            <th>DEAN Remarks</th>
                            <th nowrap="">Action</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $transfer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(++$key); ?></td>
                            <td> <?php echo e($item->transferApproval->studentTransfer->reg_number); ?> </td>
                            <td>
                                <?php echo e($item->transferApproval->studentTransfer->sname.' '.$item->transferApproval->studentTransfer->fname.' '.$item->transferApproval->studentTransfer->mname); ?>

                            </td>
                            <td> <?php echo e($item->transferApproval->courseTransfer->course_code); ?></td>
                            <td> <?php echo e($item->transferApproval->deptTransfer->dept_code); ?></td>
                             <td> <?php echo e($item->cod_remarks); ?></td>
                            <td>
                                <?php if($item->dean_remarks == null): ?>
                                    <span class="badge bg-primary">Waiting approval</span>
                                    <?php echo e($item->dean_remarks); ?>

                                <?php else: ?>
                                    <p class="text-success"><?php echo e($item->dean_remarks); ?></p>
                                <?php endif; ?>
                            </td>
                    
                            <td nowrap="">
                                <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('dean.viewTransfer', [ 'id' => Crypt::encrypt($item->id)])); ?>"> View </a>
                                <?php if($item->dean_status != null): ?>
                                <i class="fa fa-check text-primary"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    
                        
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dean::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Registrar/application/Modules/Dean/Resources/views/transfers/index.blade.php ENDPATH**/ ?>