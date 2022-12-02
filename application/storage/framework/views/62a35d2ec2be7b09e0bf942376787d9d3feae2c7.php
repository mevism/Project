<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.js"></script>



<?php $__env->startSection('content'); ?>
    <div id="page-container">
        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="bg-image" style="background-image: url('<?php echo e(asset( 'media/photos/photo28@2x.jpg')); ?>');">
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
                                        CREATE ACCOUNT | <?php echo e(config('app.name')); ?>

                                    </h5>
                                    <p class="fw-medium text-muted">
                                        I already an account <a href="<?php echo e(route('root')); ?>"> sign in </a> here.
                                    </p>
                                </div>
                                <!-- END Header -->

                                <!-- Sign In Form -->
                                <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js) -->
                                <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                <div class="row g-0 justify-content-center">
                                    <div class="col-sm-8 col-xl-4">
                                        <form class="js-validation-signin" action="<?php echo e(route('application.signup')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-floating mb-4">
                                                <input type="email" class="form-control form-control" value="<?php echo e(old('email')); ?>" name="email">
                                                <label class="form-label" for="email">Email Address</label>
                                            </div>

                                            <div class=" mb-4">
                                                <label class="form-label" for="mobile">Mobile Number</label>
                                                <input id="phone" type="tel" class="form-control col-md-12" value="<?php echo e(old('mobile')); ?>" name="mobile">




                                                <span id="valid-msg" class="hide"></span>
                                                <span id="error-msg" class="hide text-danger fs-sm"></span>

                                                <script>

                                                    var isValidNumber = false;
                                                    var input = document.querySelector("#phone"),
                                                        errorMsg = document.querySelector("#error-msg"),
                                                        validMsg = document.querySelector("#valid-msg");

                                                    // here, the index maps to the error code returned from getValidationError - see readme
                                                    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

                                                    // // initialise plugin
                                                    var iti = window.intlTelInput(input, {
                                                        allowExtensions: true,
                                                        formatOnDisplay: true,
                                                        autoFormat: true,
                                                        autoHideDialCode: true,
                                                        defaultCountry: "ke",
                                                        ipinfoToken: "yolo",


                                                        nationalMode: false,
                                                        numberType: "MOBILE",
                                                        onlyCountries: ['ke', 'ug', 'tz', 'rw', 'cd', 'bi'],
                                                        preventInvalidNumbers: true,
                                                        separateDialCode: true,
                                                        initialCountry: "KE",

                                                        geoIpLookup: function(callback) {
                                                            $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                                                                var countryCode = (resp && resp.country) ? resp.country : "";
                                                                callback(countryCode);
                                                            });
                                                        },

                                                        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/utils.js?1638200991544"
                                                        // utilsScript: "node_modules/intl-tel-input/build/js/utils.js"
                                                    });

                                                    var reset = function() {
                                                        input.classList.remove("error");
                                                        errorMsg.innerHTML = "";
                                                        errorMsg.classList.add("hide");
                                                        validMsg.classList.add("hide");
                                                    };

                                                    // on blur: validate
                                                    input.addEventListener('blur', function() {
                                                        reset();
                                                        if (input.value.trim()) {
                                                            if (iti.isValidNumber()) {
                                                                validMsg.classList.remove("hide");
                                                            } else {
                                                                input.classList.add("error");
                                                                var errorCode = iti.getValidationError();
                                                                errorMsg.innerHTML = errorMap[errorCode];
                                                                errorMsg.classList.remove("hide");
                                                            }
                                                        }
                                                    });

                                                    // on keyup / change flag: reset
                                                    input.addEventListener('change', reset);
                                                    input.addEventListener('keyup', reset);

                                                </script>


                                            </div>
                                            <div class="form-floating mb-4">
                                                <input type="password" class="form-control form-control" id="password" name="password">
                                                <label class="form-label" for="password">Create Password</label>
                                            </div>
                                            <div class="form-floating mb-4">
                                                <input type="password" class="form-control form-control" id="password_confirmation" name="password_confirmation">
                                                <label class="form-label" for="username">Password Confirmation</label>
                                            </div>
                                            <div class="captcha mb-4">
                                               <span class = "capcha_api"><?php echo captcha_img(); ?></span>
                                                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                                                        &#x21bb;
                                                    </button>
                                            </div>
                                            <div class="form-floating mb-4">
                                                <input type="text" class="form-control form-control" id="captcha" name="captcha">
                                                <label class="form-label" for="captcha"> Security Captcha </label>
                                            </div>

                                            <div class="d-flex justify-content-center mb-4">
                                                <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">
                                                    Create Account
                                                </button>
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
                                <img src="<?php echo e(url('media/tum-logo/iso.PNG')); ?>" alt="iso image" style="height: 50px !important; width: 200px !important;">
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
    <script type="text/javascript">
        $('#reload').click(function () {
            $.ajax({
                type: 'GET',
                url: '<?php echo e(route('application.reloadCaptcha')); ?>',
                success: function (data) {
                    $(".capcha_api").html(data.captcha);
                }
            });
        });
    </script>








































<?php $__env->stopSection(); ?>

<?php echo $__env->make('application::layouts.simple', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Registrar/application/Modules/Application/Resources/views/auth/signup.blade.php ENDPATH**/ ?>