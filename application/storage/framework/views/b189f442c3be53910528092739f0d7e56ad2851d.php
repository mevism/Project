
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
                <div class="flex-grow-1">
                    <h5 class="h6 fw-bold mb-0">
                        SEMESTER WORKLOADS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Workload</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Semester Workload
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
                    <table id="example" class="table table-bordered table-responsive-sm table-striped table-vcenter js-dataTable-responsive fs-sm">
                        <thead>
                        <th>#</th>
                        <th>Class code </th>
                        <th>UNIT NAME </th>
                        <th>UNIT CODE</th>
                        <th>Stage</th>
                        <th>Unit Lecturer(s)</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td> <?php echo e(++$key); ?> </td>
                                <td> <?php echo e($unit->class_code); ?> </td>
                                <td> <?php echo e($unit->unit_code); ?> </td>
                                <td> <?php echo e($unit->unit_name); ?> </td>
                                <td> <?php echo e($unit->stage.'.'.$unit->semester); ?> </td>
                                <td nowrap="">
                                    
                                    <?php if($unit->allocateUnit == null): ?>
                                        <?php $loaded = $unit->unitTeacher()->where('status', 1)->get(); ?>
                                        <?php if(count($loaded) < 1): ?>
                                              No Unit Lecturer
                                        <?php else: ?>
                                            <?php $__currentLoopData = $unit->unitTeacher()->where('status', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lecturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="row mb-1">
                                                    <div class="col col-md-8">
                                                        <?php echo e(++$key); ?>. <?php echo e($lecturer->userTeachingArea->title); ?> <?php echo e($lecturer->userTeachingArea->last_name); ?> <?php echo e($lecturer->userTeachingArea->first_name); ?> <?php echo e($lecturer->userTeachingArea->middle_name); ?>

                                                    </div>
                                                    <div class="col col-md-4">
                                                        <a class="btn btn-sm btn-outline-success" href="<?php echo e(route('department.allocateUnit', ['staff_id' =>  Crypt::encrypt($lecturer->userTeachingArea->id), 'unit_id' => Crypt::encrypt($unit->id)])); ?>">Allocate </a>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="row mb-1">
                                            <div class="col col-md-8">
                                                 <?php echo e($unit->allocateUnit->userAllocation->last_name); ?> <?php echo e($unit->allocateUnit->userAllocation->first_name); ?> <?php echo e($unit->allocateUnit->userAllocation->middle_name); ?>

                                                ( <?php echo e($unit->allocateUnit->userAllocation->placedUser->first()->employment_terms); ?> )
                                            </div>
                                            <div class="col col-md-4">
                                                <?php if($unit->allocateUnit->workload_approval_id === 0 || $unit->allocateUnit->status == 2): ?>
                                                <a class="btn btn-sm btn-outline-danger" href="<?php echo e(route('department.deleteWorkload', ['id' => Crypt::encrypt($unit->allocateUnit->unit_id)])); ?>">Revoke </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
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

<?php echo $__env->make('cod::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\project\application\Modules/Workload\Resources/views/workload/allocateUnits.blade.php ENDPATH**/ ?>