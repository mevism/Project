<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

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
                        MY WORKLOADS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Workload</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            My Workloads
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
                <table id="example" class="table table-sm table-responsive table-bordered table-striped js-dataTable-responsive fs-sm">
                        <thead>
                            <th>#</th>
                            <th>Academic Year</th>
                            <th>Academic Semester</th>
                            <th>Class</th>
                            <th>Unit code</th>
                            <th>Unit name</th>
                            <th>Class list</th>
                        </thead>
                        <tbody>
                        <?php
                            $i = 0;
                        ?>
                            <?php $__currentLoopData = $workloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year => $workload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td> <?php echo e(++$i); ?> </td>
                                    <td> <?php echo e($workload->academic_year); ?> </td>
                                    <td> <?php echo e($workload->academic_semester); ?> </td>
                                    <td> <?php echo e($workload->class_code); ?> </td>
                                    <td> <?php echo e($workload->workloadUnit->unit_code); ?> </td>
                                    <td> <?php echo e($workload->workloadUnit->unit_name); ?> </td>
                                    <td>

                                       <a class="btn btn-sm btn-alt-secondary" href="#"> Download </a>
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



<?php echo $__env->make('lecturer::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Lecturer\Resources/views/workload/viewworkload.blade.php ENDPATH**/ ?>