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
            order: [[1, 'asc']],
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
                   COURSE TRANSFER
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
            <div class="col-lg-12">
                <table id="example" class="table table-md table-striped table-bordered table-vcenter fs-sm">
                    <?php if(count($transfer)>0): ?>
                        <thead>
                            <th></th>
                            <th nowrap="">Student</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>COD Status</th>
                            
                            <th>DEAN STATUS</th>
                            

                            <th style="white-space: nowrap !important;">Action</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $transfer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td> <?php echo e($item->transferApproval->studentTransfer->sname); ?> <?php echo e($item->transferApproval->studentTransfer->fname); ?> <?php echo e($item->transferApproval->studentTransfer->mname); ?></td>
                            <td> <?php echo e($item->transferApproval->courseTransfer->course_name); ?></td>
                            <td> <?php echo e($item->transferApproval->deptTransfer->name); ?></td>
                            <td>
                                <?php if($item->cod_status == 1): ?>
                                    <span class="badge bg-success">Accepted</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Rejected</span>
                                <?php endif; ?>
                            </td>
                            
                            <td>
                                <?php if($item->dean_status == 0): ?>
                                    <span class="badge bg-primary">Pending</span>
                                <?php elseif($item->dean_status == 1): ?>
                                    <span class="badge bg-success">Accepted</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php endif; ?>
                            </td>
                            

                            <td nowrap="">
                                <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('dean.viewTransfer', $item->id)); ?>"> View </a>
                                <?php if($item->dean_status != null): ?>
                                <i class="fa fa-check text-primary"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    <?php else: ?>
                        <tr>
                            <span class="text-muted text-center fs-sm">There are no new transfers submitted</span>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dean::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Registrar/application/Modules/Dean/Resources/views/transfers/index.blade.php ENDPATH**/ ?>