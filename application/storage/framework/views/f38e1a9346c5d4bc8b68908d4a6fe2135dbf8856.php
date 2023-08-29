<?php $__env->startSection('content'); ?>
    <div id="page-container">

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="hero-static d-flex align-items-center">
                <div class="w-100">
                    <!-- Sign Up Section -->
                    <div class="bg-body-light">
                        <div class="content content-full">
                            <div class="row g-0 justify-content-center">
                                <div class="col-md-8 col-lg-6 col-xl-4 py-4 px-4 px-lg-5">
                                    <!-- Header -->
                                    <div class="text-center">
                                        <p class="mb-2">
                                            <i class="fa fa-2x fa fa-user-graduate text-primary"></i>
                                        </p>
                                        <h1 class="h4  mb-1">
                                            VERIFY STUDENT DETAILS
                                        </h1>
                                    </div>
                                    <!-- END Header -->

                                    <!-- Sign Up Form -->
                                    <!-- jQuery Validation (.js-validation-signup class is initialized in js/pages/op_auth_signup.min.js which was auto compiled from _js/pages/op_auth_signup.js) -->
                                    <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                    <form class="#" action="<?php echo e(route('payment.submitRegistration')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="py-3">
                                            <div class="mb-4 form-floating">
                                                <input type="text" class="form-control form-control-lg" readonly name="student_number" placeholder="Username" value="<?php echo e($student->RegStud_No_PK); ?>">
                                                <label>STUDENT NUMBER</label>
                                            </div>
                                            <div class="mb-4 form-floating">
                                                <input type="email" class="form-control form-control-lg" readonly name="student_email" placeholder="Username" value="<?php echo e($student->RegStud_Email); ?>">
                                                <label>STUDENT EMAIL</label>
                                            </div>
                                            <div class="mb-4 form-floating">
                                                <input type="text" class="form-control form-control-lg" readonly name="student_name" placeholder="Username" value="<?php echo e($student->RegStud_Name1.' '.$student->RegStud_Name2.' '.$student->RegStud_Name3); ?>">
                                                <label>STUDENT NAME</label>
                                            </div>
                                            <div class="mb-4 form-floating">
                                                <input type="text" class="form-control form-control-lg" name="phone_number" placeholder="Email" value="<?php echo e(old('phone_number')); ?>">
                                                <label>STUDENT PHONE NUMBER</label>
                                            </div>

                                            <div class="mb-4 form-floating">
                                                <input type="password" class="form-control form-control-lg" name="password" placeholder="Email">
                                                <label>CREATE PASSWORD</label>
                                            </div>

                                            <div class="mb-4 form-floating">
                                                <input type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="Email">
                                                <label>CONFIRM PASSWORD</label>
                                            </div>











                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-lg-6 col-xxl-5">
                                                <button type="submit" class="btn w-100 btn-alt-success col-md-8">
                                                    <i class=" opacity-50"></i> CREATE ACCOUNT
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Sign Up Form -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Sign Up Section -->

                    <!-- Footer -->
                    <div class="fs-sm text-center text-muted py-3">
                        <strong><?php echo e(config('app.name')); ?></strong> &copy; <?php echo e(\Carbon\Carbon::now()->format('Y')); ?>

                    </div>
                    <!-- END Footer -->
                </div>

                <!-- Terms Modal -->
                <div class="modal fade" id="one-signup-terms" tabindex="-1" role="dialog" aria-labelledby="one-signup-terms" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
                        <div class="modal-content">
                            <div class="block block-rounded block-transparent mb-0">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Terms &amp; Conditions</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="fa fa-fw fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                                    <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                                    <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                                    <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                                    <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                                </div>
                                <div class="block-content block-content-full text-end bg-body">
                                    <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">I Agree</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Terms Modal -->
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('epayment::layouts.simple', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Epayment\Resources/views/register.blade.php ENDPATH**/ ?>