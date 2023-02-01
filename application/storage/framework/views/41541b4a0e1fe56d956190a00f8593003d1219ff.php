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
                     ACADEMIC/DEFERMENT LEAVE REQUESTS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Schools</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            ACADEMIC/DEFERMENT
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
                        <a class="btn  btn-alt-primary btn-sm" href="">Generate report</a>
                    </div>
                    <form action="<?php echo e(route('courses.acceptedAcademicLeaves')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <table id="example" class="table table-md table-striped table-bordered table-vcenter fs-sm">
                            
                                <thead>
                                    <th>✔</th>
                                    <th>#</th>
                                    <th nowrap=""> Student Number</th>
                                    <th nowrap="">Student name</th>
                                    <th nowrap="">Department</th>
                                    <th>COD Remarks</th>
                                    <th>DEAN STATUS</th>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <tr>
                                                <td>
                                                    <?php if($item->registrar_status == NULL ): ?>
                                                    <input class="leaves" type="checkbox" name="submit[]" value="<?php echo e($item->id); ?>">
                                                        <?php else: ?>
                                                        ✔
                                                    <?php endif; ?>
                                                </td>
                                                <td> <?php echo e(++$key); ?> </td>
                                                <td><?php echo e($item->studentLeave->reg_number); ?></td>
                                                <td><?php echo e($item->studentLeave->sname.' '. $item->studentLeave->fname.' '. $item->studentLeave->mname); ?> </td>
                                                <td><?php echo e($item->studentLeave->courseStudent->deptStudCourse->dept_code); ?></td>
                                                <td>
                                                    <?php if($item->approveLeave != null): ?>
                                                    <?php echo e($item->approveLeave->cod_remarks); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($item->approveLeave != null): ?>
                                                        <?php if($item->approveLeave->dean_status == 1): ?>
                                                            <span class="badge bg-success">Accepted</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">Rejected</span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            
                        </table>
                        <?php if(count($leaves) > 0): ?>
                        <div>
                            <input type="checkbox" onclick="for(c in document.getElementsByClassName('leaves')) document.getElementsByClassName('leaves').item(c).checked = this.checked"> Select all
                        </div>

                        <?php endif; ?>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-outline-success col-md-3 m-2" data-toggle="click-ripple">Send Mail</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Courses/application/Modules/Registrar/Resources/views/leaves/index.blade.php ENDPATH**/ ?>