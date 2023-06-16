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
                    <h5 class="h5 fw-bold mb-0">
                        Intakes
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Department</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Intakes
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">

        <div class="block-content block-content-full">
            <div class="row">
                <div class="table-responsive col-12">
                    <table id="example" class="table table-bordered table-striped table-sm fs-sm">
                        <thead>
                            <th>#</th>
                            <th>Intakes</th>
                            <th>SEMESTER DATES</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $intakes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $intake): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><b class="text-uppercase"><?php echo e(Carbon\carbon::parse($intake->intake_from)->format('MY')); ?></b></td>
                                <td class="text-uppercase"><b>From : </b> <?php echo e(Carbon\carbon::parse($intake->intake_from)->format('d-M-Y')); ?> <b>To : </b> <?php echo e(Carbon\carbon::parse($intake->intake_to)->format('d-M-Y')); ?></td>
                                <td>
                                    <?php if($intake->status == 0): ?>
                                        <span class="badge bg-primary">Intake Pending</span>
                                    <?php endif; ?>
                                    <?php if($intake->status == 1): ?>
                                          <span class="badge bg-success">Intake Ongoing</span>
                                    <?php endif; ?>
                                    <?php if($intake->status == 2): ?>
                                        <span  class="badge bg-warning">Intake Closed</span>
                                    <?php endif; ?>
                                    <?php if($intake->status == 3): ?>
                                        <span  class="badge bg-danger">Intake Suspended</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($intake->status == 0 ): ?>
                                    <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('department.intakeCourses', $intake->intake_id)); ?>">Add courses</a>
                                    <?php else: ?>
                                    <a class="btn btn-sm btn-alt-secondary" href="<?php echo e(route('department.availableCourses', $intake->intake_id)); ?>">Courses on offer</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Dynamic Table Responsive -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cod::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/COD\Resources/views/intakes/index.blade.php ENDPATH**/ ?>