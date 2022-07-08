<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Applications
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Application</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Apply
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content content-boxed">
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <!-- Updates -->
                <form class="js-validation-signin" method="post" action="<?php echo e(route('application.update', $app->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <ul class="timeline timeline-alt py-0">
                        <li class="timeline-event">
                            <div class="timeline-event-icon bg-default">
                                <i class="fa fa-school"></i>
                            </div>
                            <div class="timeline-event-block block">
                                <div class="block-header">
                                    <h3 class="block-title">Course Details</h3>
                                    <div class="block-options">
                                        <div class="timeline-event-time block-options-item fs-sm">
                                            <i class="fa fa-info" title="user information"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <div class="row" style="padding: 5px !important;">
                                        <label class="col-sm-2 col-form-label" for="example-hf-email">School</label>
                                        <div class="col-sm-8 text-uppercase" style="padding: 5px !important;">
                                            <input type="text" class="form-control form-control-alt" name="school" value="<?php echo e($app->courses->school_id); ?>" readonly>
                                            <input type="hidden" name="intake" value="<?php echo e($app->intake_id); ?>">
                                            <input type="hidden" name="course_id" value="<?php echo e($app->course_id); ?>">
                                        </div>
                                    </div>

                                    <div class="row" style="padding: 5px !important;">
                                        <label class="col-sm-2 col-form-label" for="example-hf-email">Department</label>
                                        <div class="col-sm-8 text-uppercase" style="padding: 5px !important;">
                                            <input type="text" class="form-control form-control-alt" name="department" value="<?php echo e($app->courses->department_id); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="row" style="padding: 5px !important;">
                                        <label class="col-sm-2 col-form-label" for="example-hf-password">Course</label>
                                        <div class="col-sm-8 text-uppercase" style="padding: 5px !important;">
                                            <input type="text" class="form-control form-control-alt" name="course" value="<?php echo e($app->courses->course_name); ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-event">
                            <div class="timeline-event-icon bg-default">
                                <i class="fa fa-book-open"></i>
                            </div>
                            <div class="timeline-event-block block">
                                <div class="block-header">
                                    <h3 class="block-title">Cluster Subjects</h3>
                                    <div class="block-options">
                                        <div class="timeline-event-time block-options-item fs-sm">
                                            <i class="fa fa-info" title="user information"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <div class="row" style="padding: 5px !important;">
                                        <label class="col-sm-2 col-form-label" for="example-hf-email">Subject 1</label>
                                        <div class="col-sm-8 text-uppercase" style="padding: 5px !important;">
                                            <div class="input-group">
                                                <span class="input-group-text input-group-text-alt"><?php echo e(Str::limit( $app->courses->subject1, $limit = 3 , $end='' )); ?></span>
                                                <input type="text" class="form-control form-control-alt" name="subject1" value="<?php echo e($app->subject_1); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="padding: 5px !important;">
                                        <label class="col-sm-2 col-form-label" for="example-hf-email">Subject 2</label>
                                        <div class="col-sm-8 text-uppercase" style="padding: 5px !important;">
                                            <div class="input-group">
                                                <span class="input-group-text input-group-text-alt"><?php echo e(Str::limit( $app->courses->subject2, $limit = 3 , $end='' )); ?></span>
                                                <input type="text" class="form-control form-control-alt" name="subject2" value="<?php echo e($app->subject_2); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="padding: 5px !important;">
                                        <label class="col-sm-2 col-form-label" for="example-hf-password">Subject 3</label>
                                        <div class="col-sm-8 text-uppercase" style="padding: 5px !important;">
                                            <div class="input-group">
                                                <span class="input-group-text input-group-text-alt"><?php echo e(Str::limit( $app->courses->subject3, $limit = 8 , $end='' )); ?></span>
                                                <input type="text" class="form-control form-control-alt" name="subject3" value="<?php echo e($app->subject_3); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="padding: 5px !important;">
                                        <label class="col-sm-2 col-form-label" for="example-hf-email">Subject 4 </label>
                                        <div class="col-sm-8 text-uppercase" style="padding: 5px !important;">
                                            <div class="input-group">
                                                <span class="input-group-text input-group-text-alt"><?php echo e(Str::limit( $app->courses->subject4, $limit = 8 , $end='' )); ?></span>
                                                <input type="text" class="form-control form-control-alt" name="subject4" value="<?php echo e($app->subject_1); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-event">
                            <div class="timeline-event-icon bg-dark">
                                <i class="fa fa-money-bill"></i>
                            </div>
                            <div class="timeline-event-block block">
                                <div class="block-header">
                                    <h3 class="block-title">Payment Details</h3>
                                    <div class="block-options">
                                        <div class="timeline-event-time block-options-item fs-sm">
                                            <i class="fa fa-info" title="user information"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <p class="text-muted">To complete application you must pay and add payment details to this form</p>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="py-2 mb-0">
                                                You are required to pay <span class="fw-bold">Ksh. <?php echo e($app->courses->fee); ?> </span> to complete this application.
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-block-popin"> How do I pay?</a>

                                            </div>
                                            <div class="text-uppercase" style="padding: 7px !important;">
                                                <input type="text" class="form-control form-control-alt" required value="<?php echo e($app->receipt); ?>" name="receipt" placeholder="Enter RECEIPT NUMBER">
                                            </div>
                                            <div class="text-uppercase" style="padding: 7px !important;">
                                                <input type="file" class="form-control form-control-alt" required value="<?php echo e($app->receipt_file); ?>" name="receipt_file">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-event">
                            <div class="timeline-event-icon bg-modern">
                                <i class="fa fa-book"></i>
                            </div>
                            <div class="timeline-event-block block">
                                <div class="block-header">
                                    <h3 class="block-title">Education History <span class="fs-sm text-danger text-lowercase fw-normal"><sup>*</sup> You are required to fill your education history again afresh </span></h3>
                                    <div class="block-options">
                                        <div class="timeline-event-time block-options-item fs-sm">
                                            <i class="fa fa-info" title="user information"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content block-content-full">

                                    <div class="row">
                                        <div class="col-md-2" style="padding: 7px !important;">
                                            <label class="form-check-label"> Secondary school</label>
                                        </div>
                                        <div class="col-md-8" style="padding: 10px !important;">
                                            <div style="padding: 7px !important;">
                                                <input type="text" class="form-control form-control-alt text-uppercase" value="<?php echo e(old('secondary')); ?>" name="secondary" placeholder="Institution name">
                                            </div>
                                            <div style="padding: 7px !important;">
                                                <input type="text" class="form-control form-control-alt text-uppercase" value="<?php echo e(old('secondaryqualification')); ?>" name="secondaryqualification" placeholder="Qualifications acquired">
                                            </div>
                                            <div class="row" style="padding: 7px !important;">
                                                <div class="col-6">
                                                    <input type="month" class="form-control form-control-alt" value="<?php echo e(old('secstartdate')); ?>" name="secstartdate">
                                                    <small class="text-muted">Starting year</small>
                                                </div>
                                                <div class="col-6">
                                                    <input type="month" class="form-control form-control-alt" value="<?php echo e(old('secenddate')); ?>" name="secenddate">
                                                    <small class="text-muted">Year Finished</small>
                                                </div>
                                            </div><div style="padding: 7px !important;">
                                                <input type="file" class="form-control form-control-alt" value="<?php echo e(old('seccert')); ?>" name="seccert" placeholder="upload certificate">
                                                <small class="text-muted">Upload certificate</small>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($app->courses->level == 2): ?>
                                        <div class="row">
                                            <div class="col-md-2" style="padding: 7px !important;">
                                                <label class="form-check-label"> Tertiary Institution</label>
                                            </div>
                                            <div class="col-md-8" style="padding: 10px !important;">
                                                <div style="padding: 7px !important;">
                                                    <input type="text" class="form-control form-control-alt text-uppercase" value="<?php echo e(old('tertiary')); ?>" name="tertiary" placeholder="Institution name">
                                                </div>
                                                <div style="padding: 7px !important;">
                                                    <input type="text" class="form-control form-control-alt text-uppercase" value="<?php echo e(old('teriaryqualification')); ?>" name="teriaryqualification" placeholder="Qualifications acquired">
                                                </div>
                                                <div class="row" style="padding: 7px !important;">
                                                    <div class="col-6">
                                                        <input type="month" class="form-control form-control-alt" value="<?php echo e(old('terstartdate')); ?>" name="terstartdate">
                                                        <small class="text-muted">Starting year</small>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="month" class="form-control form-control-alt" value="<?php echo e(old('terenddate')); ?>" name="terenddate">
                                                        <small class="text-muted">Year Finished</small>
                                                    </div>
                                                </div><div style="padding: 7px !important;">
                                                    <input type="file" class="form-control form-control-alt" value="<?php echo e(old('tercert')); ?>" name="tercert" placeholder="upload certificate">
                                                    <small class="text-muted">Upload certificate</small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($app->courses->level >= 3): ?>
                                        <div class="row">
                                            <div class="col-md-2" style="padding: 7px !important;">
                                                <label class="form-check-label"> Tertiary Institution</label>
                                            </div>
                                            <div class="col-md-8" style="padding: 10px !important;">
                                                <div style="padding: 7px !important;">
                                                    <input type="text" class="form-control form-control-alt text-uppercase" value="<?php echo e(old('tertiary')); ?>" name="tertiary" placeholder="Institution name">
                                                </div>
                                                <div style="padding: 7px !important;">
                                                    <input type="text" class="form-control form-control-alt text-uppercase" value="<?php echo e(old('teriaryqualification')); ?>" name="teriaryqualification" placeholder="Qualifications acquired">
                                                </div>
                                                <div class="row" style="padding: 7px !important;">
                                                    <div class="col-6">
                                                        <input type="month" class="form-control form-control-alt" value="<?php echo e(old('terstartdate')); ?>" name="terstartdate">
                                                        <small class="text-muted">Starting year</small>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="month" class="form-control form-control-alt" value="<?php echo e(old('terenddate')); ?>" name="terenddate">
                                                        <small class="text-muted">Year Finished</small>
                                                    </div>
                                                </div><div style="padding: 7px !important;">
                                                    <input type="file" class="form-control form-control-alt" value="<?php echo e(old('tercert')); ?>" name="tercert" placeholder="upload certificate">
                                                    <small class="text-muted">Upload certificate</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2" style="padding: 7px !important;">
                                                <label class="form-check-label"> Tertiary Institution 2</label>
                                            </div>
                                            <div class="col-md-8" style="padding: 10px !important;">
                                                <div style="padding: 7px !important;">
                                                    <input type="text" class="form-control form-control-alt text-uppercase" value="<?php echo e(old('tertiary2')); ?>" name="tertiary2" placeholder="Institution name">
                                                </div>
                                                <div style="padding: 7px !important;">
                                                    <input type="text" class="form-control form-control-alt text-uppercase" value="<?php echo e(old('teriary2qualification')); ?>" name="teriary2qualification" placeholder="Qualifications acquired">
                                                </div>
                                                <div class="row" style="padding: 7px !important;">
                                                    <div class="col-6">
                                                        <input type="month" class="form-control form-control-alt" value="<?php echo e(old('ter2startdate')); ?>" name="ter2startdate">
                                                        <small class="text-muted">Starting year</small>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="month" class="form-control form-control-alt" value="<?php echo e(old('ter2enddate')); ?>" name="ter2enddate">
                                                        <small class="text-muted">Year Finished</small>
                                                    </div>
                                                </div><div style="padding: 7px !important;">
                                                    <input type="file" class="form-control form-control-alt" value="<?php echo e(old('ter2cert')); ?>" name="ter2cert" placeholder="upload certificate">
                                                    <small class="text-muted">Upload certificate</small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>



































































































































































                        <li class="timeline-event">
                            <div class="timeline-event-icon bg-dark">
                                <i class="fa fa-user-check"></i>
                            </div>
                            <div class="timeline-event-block block">
                                <div class="block-header">
                                    <h3 class="block-title">Declaration</h3>
                                    <div class="block-options">
                                        <div class="timeline-event-time block-options-item fs-sm">
                                            <i class="fa fa-info" title="user information"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <p class="text-muted">Applicant declaration</p>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="" style="padding: 7px !important;">
                                                <input type="checkbox" name="declare" required>
                                                I <span class="text-decoration-underline"> <?php echo e(Auth::user()->sname); ?> <?php echo e(Auth::user()->mname); ?> <?php echo e(Auth::user()->fname); ?></span> declare that the information given in this application form is correct. I further certify that I have read, understood and agreed to comply with the terms stipulated herein.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center" style="padding: 15px !important;">
                                    <div class="col-md-4">
                                        <button type="submit" class="btn w-100 btn-alt-primary">
                                            Submit application
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <!-- END Updates -->
                </form>
            </div>
        </div>
    </div>
    <!-- Pop In Block Modal -->
    <div class="modal fade" id="modal-block-popin" tabindex="-1" role="dialog" aria-labelledby="modal-block-popin" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popin" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Application fee payment</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        Fee is payable through the following bank and branches:
                        <ul>
                            <li>Cooperative Bank of Kenya <b>Acc. No 01129079001600 </b> (Nkrumah Rd Branch).</li>
                            <li>Standard Chartered Bank <b>Acc. No. 0102092728000 </b>(Treasury Square).</li>
                            <li>Equity Bank <b> Acc. No. 0460297818058 </b> (Digo Rd Branch).</li>
                            <li>National Bank <b> Acc. No. 01038074211700 </b> (TUM Branch).</li>
                            <li>KCB Lamu Campus: <b> Acc. No. 1118817192 </b> (Mvita Branch).</li>
                            <li>KCB (TUM) Fee Collection <b> Acc No. 1169329578 </b> (Mvita Branch).</li>
                            <li>Barclays Bank <b> Acc. No. 2034098894 </b> (Nkrumah Rd Branch).</li>
                        </ul>

                        <span class="text-muted text-center" style="color: red !important;">Application fee is non refundable</span>
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Pop In Block Modal -->
<?php $__env->stopSection(); ?>



<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sims\application\Modules/Application\Resources/views/applicant/edit.blade.php ENDPATH**/ ?>