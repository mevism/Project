
<?php $__env->startSection('content'); ?>
    <div class="bg-image" style="background-image: url(<?php echo e(url('media/photos/photo33@2x.jpg')); ?>);">
        <div class="bg-black-50">
            <div class="content content-full text-center">
                <div class="my-3">
                    <img class="img-avatar img-avatar-thumb" src="<?php echo e(asset('/media/avatars/avatar14.jpg')); ?>" alt="">
                </div>
                <h1 class="h2 text-white mb-0"><?php echo e(Auth::user()->sname); ?>, <?php echo e(Auth::user()->mname); ?> <?php echo e(Auth::user()->fname); ?></h1>
                <span class="text-white-75"> Applicant </span>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="content content-boxed">
        <div class="row">
            <div class="col-md-7 col-xl-8">
                <!-- Updates -->
                <ul class="timeline timeline-alt py-0">
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-default">
                            <i class="fa fa-user-gear"></i>
                        </div>
                        <div class="timeline-event-block block">
                            <div class="block-header">
                                <h3 class="block-title">Personal Info</h3>
                                <div class="block-options">
                                    <div class="timeline-event-time block-options-item fs-sm">
                                        <i class="fa fa-info" title="user information"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content">
                                <p class="fw-bold mb-2 text-uppercase text-center">
                                    <?php echo e(Auth::user()->title); ?>

                                    <?php echo e(Auth::user()->sname); ?>

                                    <?php echo e(Auth::user()->mname); ?>

                                    <?php echo e(Auth::user()->fname); ?>

                                </p>
                                <div class="row">
                                    <div class="col-4 fw-semibold">Gender </div>
                                    <div class="col-8"> <p>: <?php echo e(Auth::user()->gender); ?> </p></div>
                                </div>

                                <div class="row">
                                    <div class="col-4 fw-semibold">ID/Birth/Passport No.</div>
                                    <div class="col-8 text-capitalize"> <p>: <?php echo e(Auth::user()->id_number); ?></p></div>
                                </div>

                                <div class="row">
                                    <div class="col-4 fw-semibold"> Index/Registration No. </div>
                                    <div class="col-xl-8"> <p>: <?php echo e(Auth::user()->index_number); ?></p></div>
                                </div>

                                <div class="row">
                                    <div class="col-4 fw-semibold">Marital Status </div>
                                    <div class="col-8 text-capitalize"> <p>: <?php echo e(Auth::user()->marital_status); ?></p></div>
                                </div>

                                <div class="row">
                                    <div class="col-4 fw-semibold"> Living with disability </div>
                                    <div class="col-xl-8"> <p>: <?php echo e(Auth::user()->disabled); ?></p></div>
                                </div>

                                <?php if(Auth::user()->disabled === 'Yes'): ?>
                                <div class="row">
                                    <div class="col-4 fw-semibold">Type of Disability </div>
                                    <div class="col-8"> <p>: <?php echo e(Auth::user()->disability); ?></p></div>
                                </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-modern">
                            <i class="fa fa-contact-card"></i>
                        </div>
                        <div class="timeline-event-block block">
                            <div class="block-header">
                                <h3 class="block-title">Contact Info</h3>
                                <div class="block-options">
                                    <div class="timeline-event-time block-options-item fs-sm">
                                        <i class="fa fa-info" title="user information"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-full">
                                <p class="fw-semibold mb-2">
                                    Primary Email: <?php echo e(Auth::user()->email); ?>

                                </p>
                                <p>Primary Mobile: <?php echo e(Auth::user()->mobile); ?></p>
                                <p>Secondary Mobile: <?php echo e(Auth::user()->alt_mobile); ?></p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-info">
                            <i class="fa fa-address-book"></i>
                        </div>
                        <div class="timeline-event-block block">
                            <div class="block-header">
                                <h3 class="block-title">Physical Address</h3>
                                <div class="block-options">
                                    <div class="timeline-event-time block-options-item fs-sm">
                                        <i class="fa fa-info" title="user information"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content">
                                <p>Nationality: <?php echo e(Auth::user()->nationality); ?></p>
                                <p>County: <?php echo e(Auth::user()->county); ?></p>
                                <p>Sub County: <?php echo e(Auth::user()->sub_county); ?></p>
                                <p>Town: <?php echo e(Auth::user()->town); ?></p>
                                <p>Address: <?php echo e(Auth::user()->address); ?></p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-dark">
                            <i class="fa fa-cog"></i>
                        </div>
                        <div class="timeline-event-block block">
                            <div class="block-header">
                                <h3 class="block-title">Account Details</h3>
                                <div class="block-options">
                                    <div class="timeline-event-time block-options-item fs-sm">
                                        <i class="fa fa-info" title="user information"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content">
                                <p class="fw-semibold mb-2">
                                    Username: <?php echo e(Auth::user()->username); ?>

                                </p>
                                <p>
                                    Account activated at: <?php echo e(Auth::user()->email_verified_at); ?>

                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
                <!-- END Updates -->
            </div>
            <div class="col-md-5 col-xl-4">
                <!-- Products -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            <i class="fa fa-school text-muted me-1"></i> previous applications
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="d-flex align-items-center push">
                            <div class="flex-shrink-0 me-3">



                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Course 1</div>
                                <div class="fs-sm">Course1 Details</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center push">
                            <div class="flex-shrink-0 me-3">



                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Course 2</div>
                                <div class="fs-sm">Course2 Details</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center push">
                            <div class="flex-shrink-0 me-3">



                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Course 3</div>
                                <div class="fs-sm">Course3 Details</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center push">
                            <div class="flex-shrink-0 me-3">
                                
                                
                                
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Course 4</div>
                                <div class="fs-sm">Course4 Details</div>
                            </div>
                        </div>
                        <div class="text-center push">
                            <button type="button" class="btn btn-sm btn-alt-secondary">View More..</button>
                        </div>
                    </div>
                </div>
                <!-- END Products -->
            </div>
        </div>
    </div>
    <!-- END Page Content -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp\htdocs\courses\project\application\Modules/Application\Resources/views/applicant/profilepage.blade.php ENDPATH**/ ?>