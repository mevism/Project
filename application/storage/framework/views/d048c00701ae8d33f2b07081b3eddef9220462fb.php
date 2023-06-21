

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
                        EXAMINATIONS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Exams</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            All Exams
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
                        <th>Marks</th>
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
                                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop-<?php echo e($workload->id); ?>">
                                        Enter Marks
                                    </button>
                                    <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php
                                            $userSetting = [];
                                        ?>

                                        <?php if($setting->unit_code == $workload->workloadUnit->unit_code && $setting->class_code == $workload->class_code): ?>
                                            <?php
                                                $userSetting = $setting;
                                            ?>

                                            <div class="modal fade" id="staticBackdrop-<?php echo e($workload->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-md modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title fs-10" id="staticBackdropLabel"><?php echo e($workload->workloadUnit->unit_code.' - '. $workload->workloadUnit->unit_name); ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <form method="post" action="<?php echo e(route('lecturer.studentList', ['id' => Crypt::encrypt($workload->id), 'unit_id' => Crypt::encrypt($workload->workloadUnit->id) ])); ?>">
                                                                <?php echo csrf_field(); ?>
                                                                <div class="row">
                                                                    <div class="col-md-5 fw-semibold mb-4"> Unit Settings </div>
                                                                    <div class="col-md-3 fw-semibold mb-4"> Set Weights </div>
                                                                    <div class="col-md-4 fw-semibold mb-4"> My weights </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row mb-4">
                                                                            <div class="col-md-5">
                                                                                Exam Marks
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                : <?php echo e($workload->workloadUnit->total_exam); ?>

                                                                            </div>
                                                                            <div class="col-md-5">
                                                                                <input type="number" class="form-control-sm form-control" <?php if($userSetting != null): ?> value="<?php echo e($userSetting->exam); ?>" <?php endif; ?> name="exam">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-md-5">
                                                                                CAT1/CAT Marks
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                : <?php echo e($workload->workloadUnit->cat); ?>

                                                                            </div>
                                                                            <div class="col-md-5">
                                                                                <input type="number" class="form-control-sm form-control" <?php if($userSetting != null): ?> value="<?php echo e($userSetting->cat); ?>" <?php endif; ?> name="cat">
                                                                            </div>
                                                                        </div>
                                                                        <?php if($workload->workloadUnit->assignment != null): ?>
                                                                            <div class="row mb-4">
                                                                                <div class="col-md-5">
                                                                                    CAT2/Assignment Marks
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    : <?php echo e($workload->workloadUnit->assignment); ?>

                                                                                </div>
                                                                                <div class="col-md-5">
                                                                                    <input type="number" class="form-control-sm form-control" <?php if($userSetting != null): ?> value="<?php echo e($userSetting->assignment); ?>" <?php endif; ?> name="assignment">
                                                                                </div>
                                                                            </div>
                                                                        <?php endif; ?>

                                                                        <?php if($workload->workloadUnit->practical != null): ?>
                                                                            <div class="row mb-4">
                                                                                <div class="col-md-5">
                                                                                    <p>CAT3/Practicals Marks</p>
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    : <?php echo e($workload->workloadUnit->practical); ?>

                                                                                </div>
                                                                                <div class="col-md-5">
                                                                                    <input type="number" class="form-control-sm form-control" <?php if($userSetting != null): ?> value="<?php echo e($userSetting->practical); ?>" <?php endif; ?> name="practical">
                                                                                </div>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-center">
                                                                    <button type="submit" class="btn btn-sm btn-alt-success">Save settings & proceed</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endif; ?>
                                    <!-- Button trigger modal -->
                                        <!-- Modal -->

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <div class="modal fade" id="staticBackdrop-<?php echo e($workload->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-md modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fs-10" id="staticBackdropLabel"><?php echo e($workload->workloadUnit->unit_code.' - '. $workload->workloadUnit->unit_name); ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <form method="post" action="<?php echo e(route('lecturer.studentList', ['id' => Crypt::encrypt($workload->id), 'unit_id' => Crypt::encrypt($workload->workloadUnit->id) ])); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="row">
                                                            <div class="col-md-5 fw-semibold mb-4"> Unit Settings </div>
                                                            <div class="col-md-3 fw-semibold mb-4"> Set Weights </div>
                                                            <div class="col-md-4 fw-semibold mb-4"> My weights </div>
                                                            <div class="col-md-12">
                                                                <div class="row mb-4">
                                                                    <div class="col-md-5">
                                                                        Exam Marks
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        : <?php echo e($workload->workloadUnit->total_exam); ?>

                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <input type="number" class="form-control-sm form-control" value="<?php echo e(old('exam')); ?>" name="exam">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-4">
                                                                    <div class="col-md-5">
                                                                        CAT1/CAT Marks
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        : <?php echo e($workload->workloadUnit->cat); ?>

                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <input type="number" class="form-control-sm form-control" value="<?php echo e(old('cat')); ?>" name="cat">
                                                                    </div>
                                                                </div>
                                                                <?php if($workload->workloadUnit->assignment != null): ?>
                                                                    <div class="row mb-4">
                                                                        <div class="col-md-5">
                                                                            CAT2/Assignment Marks
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            : <?php echo e($workload->workloadUnit->assignment); ?>

                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <input type="number" class="form-control-sm form-control" value="<?php echo e(old('assignment')); ?>" name="assignment">
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <?php if($workload->workloadUnit->practical != null): ?>
                                                                    <div class="row mb-4">
                                                                        <div class="col-md-5">
                                                                            <p>CAT3/Practicals Marks</p>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            : <?php echo e($workload->workloadUnit->practical); ?>

                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <input type="number" class="form-control-sm form-control" value="<?php echo e(old('practical')); ?>" name="practical">
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-center">
                                                            <button type="submit" class="btn btn-sm btn-alt-success">Save settings & proceed</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

<?php echo $__env->make('lecturer::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\project\application\Modules/Lecturer\Resources/views/examination/index.blade.php ENDPATH**/ ?>