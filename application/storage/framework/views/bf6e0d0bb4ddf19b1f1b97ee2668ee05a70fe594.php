
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
                        Application Submission
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Application</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Batch submission
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <form action="<?php echo e(route('cod.batchSubmit')); ?>" method="post">
                <?php echo csrf_field(); ?>
                    <table id="example" class="table table-responsive-sm table-bordered table-striped js-dataTable-responsive fs-sm">
                        <?php if(count($apps)>0): ?>
                            <thead>
                            <th>✔</th>
                                <th></th>
                            <th>Applicant Name</th>
                            <th>Department </th>
                            <th>Course Name</th>
                            <th>Status</th>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $apps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                    <?php if($app->dean_status === null || 3): ?>
                                    <input class="batch" type="checkbox" name="submit[]" value="<?php echo e($app->id); ?>" required>
                                        <?php else: ?>
                                        ✔
                                    <?php endif; ?>
                                    </td>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td> <?php echo e($app->applicant->sname); ?> <?php echo e($app->applicant->fname); ?> <?php echo e($app->applicant->mname); ?></td>
                                    <td> <?php echo e($app->courses->getCourseDept->name); ?></td>
                                    <td> <?php echo e($app->courses->course_name); ?></td>
                                    <td>
                                        <?php if($app->cod_status === 0): ?>
                                            <span class="badge bg-primary">Awaiting</span>
                                        <?php elseif($app->cod_status === 1): ?>
                                            <span class="badge bg-success">Accepted</span>
                                        <?php elseif($app->cod_status === 2): ?>
                                            <span class="badge bg-warning">Rejected</span>
                                        <?php else: ?>
                                            <span class="badge bg-primary">Awaiting</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        <?php else: ?>
                            <tr>
                                <span class="text-muted text-center fs-sm">There are no applications awaiting batch submission</span>
                            </tr>
                        <?php endif; ?>
                    </table>
                    <?php if(count($apps)>0): ?>
                        <div>
                            <input type="checkbox" onclick="for(c in document.getElementsByClassName('batch')) document.getElementsByClassName('batch').item(c).checked = this.checked"> Select all
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-sm btn-alt-primary" data-toggle="click-ripple">Submit batch</button>
                        </div>
                        <?php endif; ?>
                </form>
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
            order: [[2, 'asc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );
</script>

<?php echo $__env->make('cod::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp\htdocs\project\application\Modules/COD\Resources/views/applications/batch.blade.php ENDPATH**/ ?>