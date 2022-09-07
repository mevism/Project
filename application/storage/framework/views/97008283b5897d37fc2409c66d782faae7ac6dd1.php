

<?php $__env->startSection('content'); ?>
   <div id="page-container">
        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="bg-image" style="background-image: url('media/photos/photo28@2xjpg');">
                <div class="row g-0 bg-primary-dark-op">
                    <!-- Meta Info Section -->
                    <div class="hero-static col-lg-4 d-none d-lg-flex flex-column justify-content-center">
                        <div class="p-4 p-xl-5 flex-grow-1 d-flex align-items-center">
                            <div class="w-100">
                                <a class="link-fx fw-semibold fs-2 text-white" target="_blank" href="https://www.tum.ac.ke/">
                                    <span class="d-flex justify-content-center">
                                        <img src="<?php echo e(url('media/tum-logo/tum-logo.png')); ?>" alt="logo" style="width: 50% !important; height: 50% !important;">
                                    </span>
                                    <div class="h3 p-3">
                                        Technical University of Mombasa
                                    </div>
                                </a>
                                <p class="text-white-75 me-xl-8 mt-2">
                                    Welcome to Technical University of Mombasa. A Technical University of Global Excellence in Advancing Knowledge, Science and Technology.
                                </p>
                            </div>
                        </div>
                        <div class="p-4 p-xl-5 d-xl-flex justify-content-between align-items-center fs-sm">
                            <p class="fw-medium text-white-50 mb-0">
                                <strong>TUM</strong> &copy; <span data-toggle="year-copy"></span>
                            </p>
                            <ul class="list list-inline mb-0 py-2">
                                <img src="<?php echo e(url('media/tum-logo/iso.png')); ?>" alt="iso image" style="height: 50px !important; width: 200px !important;">
                            </ul>
                        </div>
                    </div>
                    <!-- END Meta Info Section -->

                    <!-- Main Section -->
                    <div class="hero-static col-lg-8 d-flex flex-column align-items-center bg-body-light">
                        <div class="p-3 w-100 d-lg-none text-center">
                            <a class="link-fx fw-semibold fs-3 text-dark" href="https://www.tum.ac.ke/">
                                <img src="<?php echo e(url('media/tum-logo/tum-logo.png')); ?>" alt="logo">
                            </a>
                        </div>
                        <div class="p-4 w-100 flex-grow-1 d-flex align-items-center">
                            <div class="w-100">
                                <!-- Header -->
                                <div class="text-center mb-5">
                                    <h5 class="fw-bold mb-2 text-uppercase">
                                        Sign In | <?php echo e(config('app.name')); ?>

                                    </h5>
                                    <p class="fw-medium text-muted">
                                        Welcome, please login or <a href="<?php echo e(route('application.register')); ?>"> register </a> for a new account.
                                    </p>
                                </div>
                                <!-- END Header -->

                                <!-- Sign In Form -->
                                <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js) -->
                                <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                <div class="row g-0 justify-content-center">
                                    <div class="col-sm-8 col-xl-4">
                                        <form class="js-validation-signin" action="<?php echo e(route('user.login')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-floating mb-4">
                                                <input type="text" class="form-control form-control-alt" id="username" name="username">
                                                <label class="form-label" for="username">User ID</label>
                                            </div>
                                            <div class="form-floating mb-4">
                                                <input type="password" class="form-control form-control-alt" id="password" name="password">
                                                <label class="form-label" for="username">Password</label>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <div>
                                                    <a class="text-muted fs-sm fw-medium d-block d-lg-inline-block mb-1" href="#">
                                                        Forgot Password?
                                                    </a>
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">
                                                        Sign In
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- END Sign In Form -->
                            </div>
                        </div>
                        <div class="px-4 py-3 w-100 d-lg-none d-flex flex-column flex-sm-row justify-content-between fs-sm text-center text-sm-start">
                            <p class="fw-medium text-white-50 mb-0">
                                <strong>TUM</strong> &copy; <span data-toggle="year-copy"></span>
                            </p>
                            <ul class="list list-inline mb-0 py-2">
                                <img src="<?php echo e(url('media/tum-logo/iso.png')); ?>" alt="iso image" style="height: 50px !important; width: 200px !important;">
                            </ul>
                        </div>
                    </div>
                    <!-- END Main Section -->
                </div>
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.simple', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp\htdocs\project\application\resources\views/userauth/login.blade.php ENDPATH**/ ?>