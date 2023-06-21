
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
                        <?php echo e($semester); ?>-<?php echo e($year); ?> WORKLOAD
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
                <div class="col-12 table-responsive">
                    <table id="example" class="table table-bordered sm table-striped table-vcenter js-dataTable-responsive fs-sm">
                        <thead>
                        <th>#</th>
                        <th>Staff number </th>
                        <th>Staff name </th>
                        <th>Qualifications </th>
                        <th>Role </th>
                        <th>Class Code</th>
                        <th>Load </th>
                        <th>Std</th>
                        <th>Unit Code</th>
                        <th>Unit Name</th>
                        <th>Level</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $workloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lec => $workload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td> <?php echo e($loop->iteration); ?> </td>
                                <td>
                                    <?php $__currentLoopData = $lecturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lecturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($lecturer->id == $lec): ?>
                                            <?php echo e($lecturer->staff_number); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <?php $__currentLoopData = $lecturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lecturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($lecturer->id == $lec): ?>
                                           <?php echo e($lecturer->title); ?>. <?php echo e($lecturer->last_name); ?> <?php echo e($lecturer->first_name); ?> <?php echo e($lecturer->middle_name); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <?php $__currentLoopData = $lecturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lecturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($lecturer->id == $lec): ?>
                                            <?php $__currentLoopData = $lecturer->lecturerQualfs()->where('status', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qualification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <p><?php echo e($qualification->qualification); ?></p>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <?php $__currentLoopData = $lecturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lecturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($lecturer->id == $lec): ?>
                                            <?php $__currentLoopData = $lecturer->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <p><?php echo e($role->name); ?></p>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td nowrap="">
                                    <?php $__currentLoopData = $workload; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p><?php echo e($class->class_code); ?></p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>

                                <td>
                                    <?php  $userLoad = $workload->count();  ?>
                                    <?php $__currentLoopData = $lecturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lecturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($lecturer->id === $lec): ?>
                                            <?php $staff = $lecturer; ?>

                                            <?php if($staff->placedUser->first()->employment_terms == 'FT'): ?>
                                                <?php for($i = 0; $i < $userLoad; ++$i): ?>
                                                    <?php if($i < 3): ?>
                                                        <?php $load = 'FT'; ?>
                                                        <p><?php echo e($load); ?></p>
                                                    <?php else: ?>
                                                        <?php $load = 'PT'; ?>
                                                        <p><?php echo e($load); ?></p>
                                                    <?php endif; ?>
                                                <?php endfor; ?>

                                            <?php else: ?>
                                                <?php for($i = 0; $i < $userLoad; ++$i): ?>
                                                    <?php if($i < $userLoad): ?>
                                                        <?php $load = 'PT'; ?>
                                                        <p><?php echo e($load); ?></p>
                                                    <?php endif; ?>
                                                <?php endfor; ?>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <?php $__currentLoopData = $workload; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p><?php echo e($class->classWorkload->studentClass->count()); ?></p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td nowrap="">
                                    <?php $__currentLoopData = $workload; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p><?php echo e($class->workloadUnit->unit_code); ?></p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td nowrap="">
                                    <?php $__currentLoopData = $workload; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p><?php echo e($class->workloadUnit->unit_name); ?></p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <?php $__currentLoopData = $workload; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p><?php echo e($class->classWorkload->classCourse->level); ?></p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('cod::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\project\application\Modules/Workload\Resources/views/workload/viewSemesterWorkload.blade.php ENDPATH**/ ?>