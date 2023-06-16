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
            order: [[2, 'asc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );
</script>


<?php $__env->startSection('content'); ?>

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        REQUEST REGISTRATION
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="<?php echo e(route('student')); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Semester Details
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row row-cols-sm-2 g-2">

                <div class="">
                    <fieldset class="border p-2 mb-4" style="height: 100% !important;">
                        <legend  class="float-none w-auto"> <h6> CURRENT DETAILS </h6></legend>
                    <div class="mb-4">
                        <span class="h5 fs-sm mb-3">STUDENT NAME : </span>
                        <span class="h6 fs-sm fw-normal mb-3"> <?php echo e(Auth::guard('student')->user()->loggedStudent->sname); ?> <?php echo e(Auth::guard('student')->user()->loggedStudent->fname); ?> <?php echo e(Auth::guard('student')->user()->loggedStudent->mname); ?> </span>
                    </div>
                    <div class="mb-4">
                        <span class="h5 fs-sm mb-3">PHONE NUMBER : </span>
                        <span class="h6 fs-sm fw-normal mb-3"> <?php echo e(Auth::guard('student')->user()->loggedStudent->mobile); ?> </span>
                    </div>
                    <div class="mb-4">
                        <span class="h5 fs-sm mb-3">EMAIL ADDRESS : </span>
                        <span class="h6 fs-sm fw-normal mb-3"> <?php echo e(Auth::guard('student')->user()->loggedStudent->email); ?> </span>
                    </div>
                    <div class="mb-4">
                        <span class="h5 fs-sm mb-3">PHYSICAL ADDRESS : </span>
                        <span class="h6 fs-sm fw-normal mb-3"> P.O BOX <?php echo e(Auth::guard('student')->user()->loggedStudent->address); ?>-<?php echo e(Auth::guard('student')->user()->loggedStudent->postal_code); ?> <?php echo e(Auth::guard('student')->user()->loggedStudent->town); ?></span>
                    </div>
                    <div class="mb-4">
                        <span class="h5 fs-sm mb-3">REG. NUMBER : </span>
                        <span class="h6 fs-sm fw-normal"> <?php echo e(Auth::guard('student')->user()->loggedStudent->reg_number); ?> </span>
                    </div>
                    <div class="mb-4">
                        <span class="h5 fs-sm mb-3">COURSE ADMITTED : </span>
                        <span class="h6 fs-sm fw-normal"> <?php echo e(Auth::guard('student')->user()->loggedStudent->courseStudent-> studentCourse->course_name); ?> </span>
                    </div>

                    <div class="mb-4">
                        <?php if($reg == null): ?>
                            <span class="text-warning mb-3">Not registered</span>
                        <?php else: ?>
                        <span class="h5 fs-sm mb-3"> YEAR OF STUDY : </span>
                        <span class="h6 fs-sm fw-normal mb-3"> <?php echo e($reg->year_study); ?></span>

                        <span class="h5 fs-sm mb-3"> SEMESTER OF STUDY : </span>
                        <span class="h6 fs-sm fw-normal mb-3"> <?php echo e($reg->semester_study); ?> (<?php echo e($reg->patternRoll->season); ?>)</span>

                        <span class="h5 fs-sm mb-3"> ACADEMIC YEAR : </span>
                        <span class="h6 fs-sm fw-normal mb-3"> <?php echo e($reg->academic_year); ?></span>
                        <?php endif; ?>
                    </div>
                    </fieldset>
                </div>


                <div class="">

                    <?php if($next != NULL ): ?>
                        <fieldset class="border p-3 mb-4" style="height: 100% !important;">
                            <legend  class="float-none w-auto"> <h6> NEXT SEMESTER DETAILS </h6></legend>
                            <div class="row row-cols-sm-3 g-1 fs-sm">
                                <div class="mb-4">
                                    <span class="fw-semibold">ACADEMIC YEAR : </span> <?php echo e($next->academic_year); ?>

                                </div>

                                <div class="mb-4">
                                    <span class="fw-semibold">SEMESTER : </span> <?php echo e($next->period); ?>

                                </div>

                                <div class="mb-4">
                                    <span class="fw-semibold"> STAGE : </span> <?php echo e($next->semester); ?>

                                </div>
                            </div>

                                <?php if(in_array($next->semester, ['1.3', '2.3', '3.3', '4.3', '5.3', '6.3', '7.3'], true)): ?>

                                <fieldset class="border p-2 mb-0">
                                    <legend  class="float-none w-auto"> <h6>  SEMESTER PERIOD </h6></legend>

                                    <?php echo e($next->pattern->season); ?>

                                </fieldset>

                                <?php else: ?>
                                <fieldset class="border p-2 mb-0">
                                    <legend  class="float-none w-auto"> <h6>  SEMESTER UNITS </h6></legend>
                                    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p> <?php echo e(++$key); ?>. <?php echo e($one->unit_code); ?> - <?php echo e($one->unit_name); ?></p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </fieldset>
                                <?php endif; ?>
                        </fieldset>
                    <?php else: ?>

                        <fieldset class="border p3 mb-4">
                            <legend class="float-none w-auto"><h6> NEXT SEMESTER DETAILS </h6></legend>

                            <?php if($reg == null): ?>
                                <p class="text-warning text-center h6">Oops! You are not a bona fide student</p>
                            <?php else: ?>

                                <?php
                                    $imploded = implode(' ', $list);

                                    $finished = substr($imploded, -3);

                                    $current = $reg->year_study.'.'.$reg->semester_study;
                                    ?>

                                <?php if($imploded == null): ?>

                                    <h6 class="text-info text-center">
                                       Oops! Class Schedule not created. Please contact your COD.
                                    </h6>

                                <?php elseif($finished = $current): ?>

                                    <h6 class="text-success text-center">
                                        Congrats!!! You made it to the last semester of study.
                                    </h6>

                                <?php endif; ?>

                            <?php endif; ?>

                        </fieldset>

                    <?php endif; ?>

                </div>
            </div>

            <?php if($next != NULL): ?>
                <form method="POST" action="<?php echo e(route('student.registerSemester')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="semester" value="<?php echo e($next->semester); ?>">
                    <input type="hidden" name="yearstudy" value="<?php echo e($next->stage); ?>">
                    <input type="hidden" name="semesterstudy" value="<?php echo e($next->pattern->season_code); ?>">
                    <input type="hidden" name="period" value="<?php echo e($next->period); ?>">
                    <input type="hidden" name="academicyear" value="<?php echo e($next->academic_year); ?>">
                    <input type="hidden" name="pattern" value="<?php echo e($next->pattern_id); ?>">
                    <div class="d-flex justify-content-center mt-4">
                        <?php if(in_array($next->semester, ['1.3', '2.3', '3.3', '4.3', '5.3', '6.3', '7.3'], true)): ?>
                            <?php if($dates == null): ?>
                                <button class="btn btn-outline-warning col-md-5 disabled"> Semester registration not scheduled </button>
                            <?php else: ?>
                                <?php
                                    $today = \Carbon\Carbon::now();
                                ?>
                                <?php if($today < $dates->start_date): ?>
                                    <button class="btn btn-outline-warning col-md-5 disabled">
                                        Semester registration to open on <?php echo e(\Carbon\Carbon::parse($dates->start_date)->format('D, d-M-Y')); ?>

                                    </button>
                                <?php elseif($today > $dates->end_date): ?>
                                    <button class="btn btn-outline-warning col-md-5 disabled">
                                        Semester registration closed
                                    </button>
                                <?php elseif($today <= $dates->end_date): ?>
                                    <button class="btn btn-outline-primary col-md-5">Break for <?php echo e($next->pattern->season); ?> </button>
                                <?php endif; ?>

                            <?php endif; ?>
                        <?php else: ?>
                            <?php if($dates == null): ?>
                                <button class="btn btn-outline-warning col-md-5 disabled"> Semester registration not scheduled </button>
                            <?php else: ?>
                                <?php
                                    $today = \Carbon\Carbon::now();
                                ?>
                                <?php if($today < $dates->start_date): ?>
                                    <button class="btn btn-outline-warning col-md-5 disabled">
                                        Semester registration to open on <?php echo e(\Carbon\Carbon::parse($dates->start_date)->format('D, d-M-Y')); ?>

                                    </button>
                                <?php elseif($today > $dates->end_date): ?>
                                    <button class="btn btn-outline-warning col-md-5 disabled">
                                        Semester registration closed
                                    </button>
                                <?php elseif($today <= $dates->end_date): ?>
                                    <button class="btn btn-outline-success col-md-5"> Submit Registration </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Student\Resources/views/semester/requestRegistration.blade.php ENDPATH**/ ?>