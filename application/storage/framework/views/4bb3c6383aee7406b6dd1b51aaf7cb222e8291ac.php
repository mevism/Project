<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Update your personal details
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-1 mt-sm-0 ms-sm-1" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Profile</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Update profile
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">



        <div class="block-content">
            <div class="block-content block-content-full">
                <div class="d-flex justify-content-center fs-sm">
                    <span class="col-md-12 mb-4 text-center text-danger">
                    <i class="fa fa-info-circle"></i>
                    Please ensure that you update your profile within 72hours or the account will be deleted permanently.
                </span>
                </div>
                <div class="row">
                        <!-- Form Grid with Labels -->
                        <form class="" method="POST" action="<?php echo e(route('application.updateDetails')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row row-cols-sm-3 g-2">
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="fname" required value="<?php echo e(old('fname')); ?>" placeholder="FIRST NAME">
                                    <label class="form-label" for="fname">FIRST NAME</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="mname" value="<?php echo e(old('mname')); ?>" placeholder="MIDDLE NAME">
                                    <label class="form-label" for="mname">MIDDLE NAME</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control" name="sname" value="<?php echo e(old('sname')); ?>" required placeholder="SUR NAME">
                                    <label class="form-label" for="sname">SUR NAME</label>
                                </div>
                                <div class="form-floating col-12">
                                <select class="form-control text-muted" name="title" required>
                                    <option selected="selected" disabled class="text-center"> - select title - </option>
                                    <option <?php if(old('title') === 'Mr.'): ?> selected="selected" <?php endif; ?> value="Mr."> Mr.</option>
                                    <option <?php if(old('title') === 'Miss.'): ?> selected="selected" <?php endif; ?> value="Miss."> Miss. </option>
                                    <option <?php if(old('title') === 'Ms.'): ?> selected="selected" <?php endif; ?> value="Ms."> Ms. </option>
                                    <option <?php if(old('title') === 'Mrs.'): ?> selected="selected" <?php endif; ?> value="Mrs."> Mrs. </option>
                                    <option <?php if(old('title') === 'Dr.'): ?> selected="selected" <?php endif; ?> value="Dr.">Dr.</option>
                                    <option <?php if(old('title') === 'Prof.'): ?> selected="selected" <?php endif; ?> value="Prof."> Prof. </option>
                                </select>
                                <label class="form-label" for="title">TITTLE</label>
                            </div>
                            <div class="form-floating col-12">
                                    <select name="status" id="status" class="form-control text-muted" required>
                                        <option disabled selected class="text-center"> - select martial status - </option>
                                        <option <?php if(old('status') === 'Single'): ?> selected="selected" <?php endif; ?> value="single" >Single</option>
                                        <option <?php if(old('status') === 'Married'): ?> selected="selected" <?php endif; ?> value="married">Married</option>
                                        <option <?php if(old('status') === 'Divorced'): ?> selected="selected" <?php endif; ?> value="divorced" >Divorced</option>
                                        <option <?php if(old('status') === 'Separated'): ?> selected="selected" <?php endif; ?> value="separated" >Separated</option>
                                    </select>
                                    <label class="form-label" for="status">MARITAL STATUS</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="date" class="form-control" name="dob" value="<?php echo e(old('dob')); ?>" required>
                                    <label class="form-label">DATE OF BIRTH </label>
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="form-label">GENDER</label>
                                    <div class="space-x-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" value="M" <?php if(old('gender') === 'Male'): ?> checked <?php endif; ?> required>
                                                <label class="form-check-label">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" value="F" <?php if(old('gender') === 'Female'): ?> checked <?php endif; ?> required>
                                                <label class="form-check-label">Female</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" value="O" <?php if(old('gender') === 'Other'): ?> checked <?php endif; ?> required>
                                                <label class="form-check-label">Other</label>
                                            </div>
                                    </div>
                                </div>
                            <div class="form-floating col-12">
                                <input type="text" class="form-control text-uppercase" name="id_number" value="<?php echo e(old('id_number')); ?>" required placeholder="ID/PASSPORT/BIRTH CERT">
                                <label class="form-label">ID/ BIRTH/ PASSPORT NUMBER</label>
                            </div>
                            <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="index_number" value="<?php echo e(old('index_number')); ?>" required placeholder="INDEX">
                                    <label class="form-label" for="index_number">INDEX/REGISTRATION NUMBER</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="alt_number" value="<?php echo e(old('alt_number')); ?>" required placeholder="PHONE">
                                    <label class="form-label">ALTERNATIVE MOBILE NUMBER</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="email" class="form-control text-uppercase" name="alt_email" value="<?php echo e(old('alt_email')); ?>" required placeholder="EMAIL">
                                    <label class="form-label">ALTERNATIVE EMAIL ADDRESS</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="number" class="form-control text-uppercase" name="address" value="<?php echo e(old('address')); ?>" required placeholder="BOX">
                                    <label class="form-label">P.O BOX</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="number" class="form-control text-uppercase" name="postalcode" value="<?php echo e(old('address')); ?>" required placeholder="POSTAL">
                                    <label class="form-label">POSTAL CODE</label>
                                </div>
                                <div class="form-floating col-12">
                                    <select class="form-control text-muted" name="nationality" required placeholder="FIRST NAME">
                                        <option value="" selected disabled class="text-center"> - select nationality -</option>
                                        <option value="KE">KENYAN</option>
                                        <option value="UG">UGANDAN</option>
                                        <option value="TZ">TANZANIAN</option>
                                    </select>
                                    <label class="form-label">NATIONALITY</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="county" required value="<?php echo e(old('county')); ?>" placeholder="COUNTY">
                                    <label class="form-label">COUNTY</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="subcounty" value="<?php echo e(old('subcounty')); ?>" placeholder="SUB COUNTY">
                                    <label class="form-label">SUB-COUNTY</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="town" required value="<?php echo e(old('town')); ?>" placeholder="TOWN">
                                    <label class="form-label">TOWN</label>
                                </div>
                            <div class="col-12">
                                <label class="form-label">ARE YOU DISABLED </label>
                                <div class="space-x-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="disabled" value="No" <?php if(old('disabled') === 'No'): ?> checked <?php endif; ?> required>
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="disabled" value="Yes" <?php if(old('disabled') === 'Yes'): ?> checked <?php endif; ?> required>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="desc form-floating col-12 mt-4">
                                <textarea class="form-control" name="disability" rows="4" placeholder="Describe here kind of disability" value="<?php echo e(old('disability')); ?>"></textarea>
                                <label class="form-label" for="disability">Nature of disability</label>
                            </div>
                                <div class="d-flex justify-content-center text-center mt-4">
                                        <button class="col-md-3 btn btn-alt-success" data-toggle="ripple" type="submit"> Update details </button>
                                </div>
                        </form>
                        <!-- END Form Grid with Labels -->
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function (){
            $('div.desc').hide();

            $('input[name=disabled]').on('click', function () {
                var selectedValue = $('input[name=disabled]:checked').val();

                if(selectedValue == 'Yes') {
                    $('div.desc').show();
                }else if(selectedValue == 'No'){
                    $('div.desc').hide();
                }
            });
        });

    </script>

    <script src="<?php echo e(url('/js/oneui.app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Sims/application/Modules/Application/Resources/views/applicant/updatePage.blade.php ENDPATH**/ ?>