<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        VIEW READMISSION REQUEST
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Readmission</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Readmission
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
                    <div class="d-flex justify-content-center m-2">
                        <div class="col-md-6 p-2">
                            <fieldset class="border p-2" style="height: 100% !important;">
                                <legend class="float-none w-auto"><h6 class="fw-bold text-center"> STUDENT'S CURRENT STAGE</h6></legend>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Reg. Number </div>
                                    <div class="col-md-9 fs-sm">
                                        <?php echo e($leave->leaves->studentLeave->reg_number); ?>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Student Name</div>
                                    <div class="col-md-9 fs-sm">
                                        <?php echo e($leave->leaves->studentLeave->sname.' '.$leave->leaves->studentLeave->fname.' '.$leave->leaves->studentLeave->mname); ?>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Class</div>
                                    <div class="col-md-9 fs-sm">
                                        <?php echo e($leave->leaves->studentLeave->courseStudent->class_code); ?>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Course</div>
                                    <div class="col-md-9 fs-sm">
                                        <?php echo e($leave->leaves->studentLeave->courseStudent->studentCourse->course_name); ?>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Department</div>
                                    <div class="col-md-9 fs-sm">
                                        <?php echo e($leave->leaves->studentLeave->courseStudent->studentCourse->getCourseDept->name); ?>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Current Stage</div>
                                    <div class="col-md-9 fs-sm">
                                        <?php echo e('Year'.' '.$stage->year_study.' Semester'.$stage->semester_study.' '.'('.$stage->patternRoll->season.')'); ?>

                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6 p-2">
                            <fieldset class="border p-2" style="height: 100% !important;">
                                <legend class="float-none w-auto"><h6 class="fw-bold text-center"> DEFERMENT/ACADEMIC LEAVE DETAILS</h6></legend>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Leave Type</div>
                                    <div class="col-md-8 fs-sm">
                                        <?php if($leave->leaves->type == 1): ?>
                                            ACADEMIC LEAVE
                                        <?php else: ?>
                                            DEFERMENT
                                        <?php endif; ?>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Leave Dates</div>
                                    <div class="col-md-8 fs-sm">
                                        From: <?php echo e($leave->leaves->from); ?> - To: <?php echo e($leave->leaves->to); ?>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">New Class (Requested)</div>
                                    <div class="col-md-8 fs-sm">
                                        <?php echo e($leave->leaves->deferredClass->deferred_class); ?>

                                    </div>
                                </div>

                                <form method="POST" action="<?php echo e(route('dean.acceptReadmission', ['id' => Crypt::encrypt($leave->id)])); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="row mb-3">
                                        <div class="col-md-4 fw-bold">New Class (Placed)</div>
                                        <div class="col-md-8 fs-sm">
                                            <select name="class" class="form-control col-md-8">
                                                <option class="text-center" disabled selected>-- select class --</option>
                                                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__currentLoopData = $class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classname => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($classname); ?>"><?php echo e($classname); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">New Stage</div>
                                    <div class="col-md-8 fs-sm">
                                        <?php echo e($leave->leaves->deferredClass->stage); ?>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Readmission Period</div>
                                    <div class="col-md-8 fs-sm">
                                        Academic Year <?php echo e($leave->leaves->deferredClass->academic_year); ?> Semester <?php echo e($leave->leaves->deferredClass->semester_study); ?>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Deferment Period</div>
                                    <div class="col-md-8 fs-sm">
                                        <?php echo e(Carbon\Carbon::parse($leave->leaves->to)->diffInMonths(\Carbon\Carbon::parse($leave->leaves->from))); ?> Months
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Reason(s)</div>
                                    <div class="col-md-8 fs-sm">
                                        <?php echo e($leave->leaves->reason); ?>

                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center m-2">
                        <?php if($leave->readmissionApproval->dean_status == null): ?>
                            <button class="btn btn-outline-success col-md-2 m-2"> Accept Readmission </button>
                            <a class="btn btn-outline-danger col-md-2 m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Decline Readmission</a>
                        <?php else: ?>
                            <?php if($leave->readmissionApproval->dean_status == 1): ?>
                                <a class="btn btn-outline-danger col-md-2 m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Decline Readmission </a>
                            <?php else: ?>
                                <button class="btn btn-outline-success col-md-2 m-2"> Accept Readmission </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">YOUR REMARKS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo e(route('dean.declineReadmission', ['id' => Crypt::encrypt($leave->id)])); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="d-flex justify-content-center mb-4">
                            <div class="col-md-11">
                                <textarea name="remarks" placeholder="Remarks" rows="6" class="form-control"></textarea>
                                <input type="hidden" value="<?php echo e($leave->id); ?>" name="transfer_id">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-outline-success col-md-5">Submit Remarks</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dean::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Courses/application/Modules/Dean/Resources/views/readmissions/selectedReadmission.blade.php ENDPATH**/ ?>