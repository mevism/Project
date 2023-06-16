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
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <div class="col-lg-10">
                            <!-- Block Tabs Animated Slide Up -->
                            <div class="block block-rounded">
                                <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                                    <li class="nav-item">
                                        <?php
                                            $user = auth()->guard('web')->user();
                                        ?>

                                        <button class="nav-link <?php if($user->infoApplicant == null || $user->infoApplicant->title == null): ?> active <?php endif; ?>" id="btabs-animated-slideup-home-tab" data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-home" role="tab" aria-controls="btabs-animated-slideup-home" aria-selected="true">Personal Information <?php if($user->infoApplicant != null && $user->infoApplicant->title != null): ?> <i class="fa fa-check text-success"></i> <?php endif; ?> </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link <?php if($user->infoApplicant != null && $user->infoApplicant->title != null && $user->contactApplicant->alt_email == null || $user->contactApplicant->alt_mobile == null): ?> active <?php endif; ?>" id="btabs-animated-slideup-profile-tab" data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-profile" role="tab" aria-controls="btabs-animated-slideup-profile" aria-selected="false">Contact Information <?php if($user->infoApplicant != null && $user->contactApplicant->alt_email != null && $user->contactApplicant->alt_mobile != null): ?> <i class="fa fa-check text-success"></i> <?php endif; ?> </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link <?php if($user->contactApplicant->alt_email != null && $user->contactApplicant->alt_mobile != null && $user->infoApplicant->title != null && $user->addressApplicant->nationality == null): ?> active <?php endif; ?>" id="btabs-animated-slideup-address-tab" data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-address" role="tab" aria-controls="btabs-animated-slideup-address" aria-selected="false">Address Information <?php if($user->addressApplicant != null && $user->addressApplicant->nationality != null && $user->infoApplicant->title != null): ?> <i class="fa fa-check text-success"></i> <?php endif; ?> </button>
                                    </li>
                                    <li class="nav-item ms-auto">
                                        <span class="text-warning mt-4 fs-sm">
                                            <i class="fa fa-info-circle"></i>
                                               Fill all fields marked with <span class="text-danger">*</span>
                                        </span>
                                    </li>
                                </ul>
                                <div class="block-content tab-content overflow-hidden">
                                    <div class="tab-pane fade fade-up show <?php if($user->infoApplicant == null || $user->infoApplicant->title == null): ?> active <?php endif; ?>" id="btabs-animated-slideup-home" role="tabpanel" aria-labelledby="btabs-animated-slideup-home-tab">
                                        <form class="" method="POST" action="<?php echo e(route('applicant.personalInfo')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row row-cols-sm-2 g-2">
                                                <div class="form-floating col-12">
                                                    <select class="form-control text-muted" name="title" required>
                                                        <option selected="selected" disabled class="text-center"> - select title - </option>
                                                        <option <?php if($user->infoApplicant != null): ?>
                                                                <?php if($user->infoApplicant->title == 'MR.'): ?> selected <?php endif; ?> <?php endif; ?> value="Mr."> Mr.</option>
                                                        <option <?php if($user->infoApplicant != null): ?>
                                                                <?php if($user->infoApplicant->title == 'MISS.'): ?> selected <?php endif; ?> <?php endif; ?> value="Miss."> Miss. </option>
                                                        <option <?php if($user->infoApplicant != null): ?>
                                                                <?php if($user->infoApplicant->title == 'MS.'): ?> selected <?php endif; ?> <?php endif; ?> value="Ms."> Ms. </option>
                                                        <option <?php if($user->infoApplicant != null): ?>
                                                                <?php if($user->infoApplicant->title == 'MRS.'): ?> selected <?php endif; ?> <?php endif; ?> value="Mrs."> Mrs. </option>
                                                        <option <?php if($user->infoApplicant != null): ?>
                                                                <?php if($user->infoApplicant->title == 'DR.'): ?> selected <?php endif; ?> <?php endif; ?> value="Dr.">Dr.</option>
                                                        <option <?php if($user->infoApplicant != null): ?>
                                                                <?php if($user->infoApplicant->title == 'PROF.'): ?> selected <?php endif; ?> <?php endif; ?> value="Prof."> Prof. </option>
                                                    </select>
                                                    <label class="form-label" for="title"><span class="text-danger">*</span> TITTLE </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="fname" required value="<?php if($user->infoApplicant != null): ?><?php echo e($user->infoApplicant->fname); ?><?php else: ?><?php echo e(old('fname')); ?><?php endif; ?>" placeholder="FIRST NAME">
                                                    <label class="form-label" for="fname"><span class="text-danger">*</span> FIRST NAME </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="mname" value="<?php if($user->infoApplicant != null): ?><?php echo e($user->infoApplicant->mname); ?><?php else: ?><?php echo e(old('mname')); ?><?php endif; ?>" placeholder="MIDDLE NAME">
                                                    <label class="form-label" for="mname">MIDDLE NAME</label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control" name="sname" value="<?php if($user->infoApplicant != null): ?><?php echo e($user->infoApplicant->sname); ?><?php else: ?><?php echo e(old('sname')); ?><?php endif; ?>" required placeholder="SUR NAME">
                                                    <label class="form-label" for="sname"><span class="text-danger">*</span> SUR NAME </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <select name="status" id="status" class="form-control text-muted" required>
                                                        <option disabled selected class="text-center"> - select martial status - </option>
                                                        <option <?php if($user->infoApplicant != null): ?>
                                                                <?php if($user->infoApplicant->marital_status == 'SINGLE'): ?> selected <?php endif; ?> <?php endif; ?> value="single" >Single</option>
                                                        <option <?php if($user->infoApplicant != null): ?>
                                                                <?php if($user->infoApplicant->marital_status == 'MARRIED'): ?> selected <?php endif; ?> <?php endif; ?> value="married">Married</option>
                                                        <option <?php if($user->infoApplicant != null): ?>
                                                                <?php if($user->infoApplicant->marital_status == 'DIVORCED'): ?> selected <?php endif; ?> <?php endif; ?> value="divorced" >Divorced</option>
                                                        <option <?php if($user->infoApplicant != null): ?>
                                                                <?php if($user->infoApplicant->marital_status == 'SEPARATED'): ?> selected <?php endif; ?> <?php endif; ?> value="separated" >Separated</option>
                                                    </select>
                                                    <label class="form-label" for="status"><span class="text-danger">*</span> MARITAL STATUS </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="date" class="form-control" name="dob" value="<?php if($user->infoApplicant != null): ?><?php echo e(Carbon\Carbon::parse($user->infoApplicant->DOB)->format('Y-m-d')); ?><?php else: ?> <?php echo e(old('dob')); ?><?php endif; ?>" required placeholder="">
                                                    <label class="form-label"><span class="text-danger">*</span> DATE OF BIRTH </label>
                                                </div>
                                                <div class="col-12 mb-4">
                                                        <label class="form-label"><span class="text-danger">*</span> GENDER </label>
                                                        <div class="space-x-2">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" value="M" <?php if(old('gender') == 'Male'): ?> checked <?php endif; ?> <?php if($user->infoApplicant != null): ?> <?php echo e(($user->infoApplicant->gender == 'M') ? "checked" : ""); ?> <?php endif; ?> required>
                                                                <label class="form-check-label">Male</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" value="F" <?php if(old('gender') == 'Female'): ?> checked <?php endif; ?> <?php if($user->infoApplicant != null): ?> <?php echo e(($user->infoApplicant->gender == 'F') ? "checked" : ""); ?> <?php endif; ?> required>
                                                                <label class="form-check-label">Female</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" value="O" <?php if(old('gender') == 'Other'): ?> checked <?php endif; ?> required>
                                                                <label class="form-check-label">Other</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="id_number" value="<?php if($user->infoApplicant != null): ?><?php echo e($user->infoApplicant->id_number); ?><?php else: ?><?php echo e(old('id_number')); ?><?php endif; ?>" required placeholder="ID/PASSPORT/BIRTH CERT">
                                                    <label class="form-label"><span class="text-danger">*</span> ID/ BIRTH/ PASSPORT NUMBER </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                        <input type="text" class="form-control text-uppercase" name="index_number" value="<?php if($user->infoApplicant != null): ?><?php echo e($user->infoApplicant->index_number); ?><?php else: ?><?php echo e(old('index_number')); ?><?php endif; ?>" required placeholder="INDEX">
                                                        <label class="form-label" for="index_number"><span class="text-danger">*</span> INDEX/REGISTRATION NUMBER </label>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label"><span class="text-danger">*</span> ARE YOU DISABLED </label>
                                                    <div class="space-x-2">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="disabled" value="No" <?php if($user->infoApplicant != null): ?> <?php echo e(($user->infoApplicant->disabled == 'NO') ? "checked" : ""); ?> <?php endif; ?> required>
                                                            <label class="form-check-label">No</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="disabled" value="Yes" <?php if($user->infoApplicant != null): ?> <?php echo e(($user->infoApplicant->disabled == 'YES') ? "checked" : ""); ?> <?php endif; ?> required>
                                                            <label class="form-check-label">Yes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="desc form-floating col-12 mt-4">
                                                <textarea class="form-control" name="disability" rows="4" placeholder="Describe here kind of disability" value="<?php echo e(old('disability')); ?>"><?php if($user->infoApplicant != null): ?><?php echo e($user->infoApplicant->disability); ?><?php else: ?><?php echo e(old('disability')); ?><?php endif; ?></textarea>
                                                <label class="form-label" for="disability">Nature of disability</label>
                                            </div>
                                            <div class="d-flex justify-content-center text-center mt-4">
                                                <button class="col-md-3 btn btn-alt-success" data-toggle="ripple" type="submit"> Submit & Continue </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade fade-up show <?php if($user->infoApplicant != null && $user->infoApplicant->title != null && $user->contactApplicant->alt_email == null || $user->contactApplicant->alt_mobile == null): ?> active <?php endif; ?>" id="btabs-animated-slideup-profile" role="tabpanel" aria-labelledby="btabs-animated-slideup-profile-tab">
                                        <form class="" method="POST" action="<?php echo e(route('applicant.contactInfo')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row row-cols-sm-2 g-2">
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="mobile"value="<?php if($user->contactApplicant->mobile != null ): ?><?php echo e($user->contactApplicant->mobile); ?><?php else: ?><?php echo e(old('alt_number')); ?><?php endif; ?>" required placeholder="PHONE">
                                                    <label class="form-label"><span class="text-danger">*</span> MOBILE NUMBER </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="email" class="form-control text-lowercase" name="email" value=" <?php if($user->contactApplicant->email != null): ?> <?php echo e($user->contactApplicant->email); ?> <?php else: ?> <?php echo e(old('email')); ?> <?php endif; ?>" required placeholder="EMAIL">
                                                    <label class="form-label"><span class="text-danger">*</span> EMAIL ADDRESS </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="alt_number" value="<?php if($user->contactApplicant->alt_mobile != null): ?><?php echo e($user->contactApplicant->alt_mobile); ?><?php else: ?><?php echo e(old('alt_number')); ?><?php endif; ?>" required placeholder="PHONE">
                                                    <label class="form-label"><span class="text-danger">*</span> ALTERNATIVE MOBILE NUMBER </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="email" class="form-control text-lowercase" name="alt_email" value="<?php if($user->contactApplicant->alt_email != null): ?><?php echo e($user->contactApplicant->alt_email); ?><?php else: ?><?php echo e(old('alt_email')); ?><?php endif; ?>" required placeholder="EMAIL">
                                                    <label class="form-label"><span class="text-danger">*</span> ALTERNATIVE EMAIL ADDRESS </label>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center text-center mt-4">
                                                <button class="col-md-3 btn btn-alt-success" data-toggle="ripple" type="submit"> Submit & Continue </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade fade-up show <?php if($user->contactApplicant->alt_email != null && $user->contactApplicant->alt_mobile != null && $user->infoApplicant->title != null && $user->addressApplicant->nationality == null): ?> active <?php endif; ?>" id="btabs-animated-slideup-address" role="tabpanel" aria-labelledby="btabs-animated-slideup-address-tab">
                                        <form class="" method="POST" action="<?php echo e(route('applicant.addressInfo')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row row-cols-sm-2 g-2">
                                                <div class="form-floating col-12">
                                                    <select class="form-control text-muted" name="nationality" required placeholder="FIRST NAME">
                                                        <option value="" selected disabled class="text-center"> - select nationality - </option>
                                                        <option <?php if($user->addressApplicant != null): ?>
                                                                <?php if($user->addressApplicant->nationality == 'KE'): ?> selected  <?php endif; ?> <?php endif; ?> value="KE" >KENYAN</option>
                                                        <option <?php if($user->addressApplicant != null): ?>
                                                                <?php if($user->addressApplicant->nationality == 'UG'): ?> selected <?php endif; ?> <?php endif; ?> value="UG" >UGANDAN</option>
                                                        <option <?php if($user->addressApplicant != null): ?>
                                                                <?php if($user->addressApplicant->nationality == 'TZ'): ?> selected <?php endif; ?> <?php endif; ?> value="TZ"  >TANZANIAN</option>
                                                    </select>
                                                    <label class="form-label"><span class="text-danger">*</span> NATIONALITY </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="county" required value="<?php if($user->addressApplicant != null): ?><?php echo e($user->addressApplicant->county); ?> <?php else: ?> <?php echo e(old('county')); ?><?php endif; ?>" placeholder="COUNTY">
                                                    <label class="form-label"><span class="text-danger">*</span> COUNTY </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="subcounty" value="<?php if($user->addressApplicant != null): ?><?php echo e($user->addressApplicant->sub_county); ?> <?php else: ?> <?php echo e(old('subcounty')); ?><?php endif; ?>" placeholder="SUB COUNTY" required>
                                                    <label class="form-label"><span class="text-danger">*</span> SUB-COUNTY </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="town" required value="<?php if($user->addressApplicant != null): ?><?php echo e($user->addressApplicant->town); ?><?php else: ?><?php echo e(old('town')); ?><?php endif; ?>" placeholder="TOWN">
                                                    <label class="form-label"><span class="text-danger">*</span> TOWN </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="address" value="<?php if($user->addressApplicant != null): ?><?php echo e($user->addressApplicant->address); ?><?php else: ?><?php echo e(old('address')); ?><?php endif; ?>" required placeholder="BOX">
                                                    <label class="form-label"><span class="text-danger">*</span> P.O BOX </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="postalcode" value="<?php if($user->addressApplicant != null): ?><?php echo e($user->addressApplicant->postal_code); ?><?php else: ?><?php echo e(old('postalcode')); ?><?php endif; ?>" required placeholder="POSTAL">
                                                    <label class="form-label">POSTAL CODE <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center text-center mt-4">
                                                <button class="col-md-3 btn btn-alt-success" data-toggle="ripple" type="submit"> Save & Continue </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- END Block Tabs Animated Slide Up -->

                        </div>
                </div>
                        <!-- Form Grid with Labels -->
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


<?php $__env->stopSection(); ?>

<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Application\Resources/views/applicant/updatePage.blade.php ENDPATH**/ ?>