
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
    <div class="content" id = "content">
        <div class="d-flex justify-content-center">
            <span class="alert alert-danger"> <i class="fa fa-info-circle"></i> Please ensure that you update your profile within 72hours or the account will be deleted permanently. </span>
        </div>
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="row">
                        <!-- Form Grid with Labels -->
                        <form class="row row-cols-md-auto g-3 justify-content-between" method="POST" action="<?php echo e(route('application.updateDetails')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-floating col-12">
                                    <select class="form-control" name="title" required>
                                        <option selected="selected" disabled class="text-center"> - - - - - - select title - - - - - - </option>
                                        <option <?php if(old('title') === 'Mr.'): ?> selected="selected" <?php endif; ?> value="Mr."> Mr.</option>
                                        <option <?php if(old('title') === 'Miss.'): ?> selected="selected" <?php endif; ?> value="Miss."> Miss. </option>
                                        <option <?php if(old('title') === 'Ms.'): ?> selected="selected" <?php endif; ?> value="Ms."> Ms. </option>
                                        <option <?php if(old('title') === 'Mrs.'): ?> selected="selected" <?php endif; ?> value="Mrs."> Mrs. </option>
                                        <option <?php if(old('title') === 'Dr.'): ?> selected="selected" <?php endif; ?> value="Dr.">Dr.</option>
                                        <option <?php if(old('title') === 'Prof.'): ?> selected="selected" <?php endif; ?> value="Prof."> Prof. </option>
                                    </select>
                                <label class="form-label" for="title">Title</label>
                            </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="fname" required value="<?php echo e(old('fname')); ?>">
                                    <label class="form-label" for="fname">First name</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="mname" value="<?php echo e(old('mname')); ?>">
                                    <label class="form-label" for="mname">Middle Name</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control" name="sname" value="<?php echo e(old('sname')); ?>" required>
                                    <label class="form-label" for="sname">Surname</label>
                                </div>
                                <div class="form-floating col-12">
                                    <select name="status" id="status" class="form-control" required>
                                        <option disabled selected class="text-center"> - - - select martial status - - - </option>
                                        <option <?php if(old('status') === 'Single'): ?> selected="selected" <?php endif; ?> value="single" >Single</option>
                                        <option <?php if(old('status') === 'Married'): ?> selected="selected" <?php endif; ?> value="married">Married</option>
                                        <option <?php if(old('status') === 'Divorced'): ?> selected="selected" <?php endif; ?> value="divorced" >Divorced</option>
                                        <option <?php if(old('status') === 'Separated'): ?> selected="selected" <?php endif; ?> value="separated" >Separated</option>
                                    </select>
                                    <label class="form-label" for="status">Marital status</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="date" class="form-control" name="dob" value="<?php echo e(old('dob')); ?>" required>
                                    <label class="form-label">Date of birth </label>
                                </div>
                                <div class="col-12 form-check-inline">
                                    <label class="form-check-label">Gender</label>
                                    <div class="space-x-0">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" value="Male" <?php if(old('gender') === 'Male'): ?> checked <?php endif; ?> required>
                                                <label class="form-check-label">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" value="Female" <?php if(old('gender') === 'Female'): ?> checked <?php endif; ?> required>
                                                <label class="form-check-label">Female</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" value="Other" <?php if(old('gender') === 'Other'): ?> checked <?php endif; ?> required>
                                                <label class="form-check-label">Other</label>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Living with a disability? </label>
                                    <div class="space-x-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="disabled" value="No" <?php if(old('disabled') === 'No'): ?> checked <?php endif; ?> required>
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id = 'disability-check' type="radio" name="disabled" value="Yes" <?php if(old('disabled') === 'Yes'): ?> checked <?php endif; ?> required>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="index_number" value="<?php echo e(old('index_number')); ?>" required>
                                    <label class="form-label" for="index_number">Index/Registration number</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="alt_number" value="<?php echo e(old('alt_number')); ?>" required>
                                    <label class="form-label">Alternative phone</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="id_number" value="<?php echo e(old('id_number')); ?>" required>
                                    <label class="form-label">ID/BIRTH/Passport Number</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="address" value="<?php echo e(old('address')); ?>" required>
                                    <label class="form-label">Physical address</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="nationality" value="<?php echo e(old('nationality')); ?>" required>
                                    <label class="form-label">Nationality</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="county" required value="<?php echo e(old('county')); ?>">
                                    <label class="form-label">County</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="subcounty" value="<?php echo e(old('subcounty')); ?>">
                                    <label class="form-label">Sub-County</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="town" required value="<?php echo e(old('town')); ?>">
                                    <label class="form-label">Town</label>
                                </div>




                                <div class="d-flex justify-content-between">
                                    <div class="text-center">
                                    <div class="col-md-12" style="width: 100% !important;">
                                        <button class="form-control btn btn-alt-info" data-toggle="ripple" type="submit"> Update details </button>
                                    </div>
                                    </div>
                                </div>
                        </form>
                        <!-- END Form Grid with Labels -->
                </div>
            </div>
        </div>
    </div>

    <script src="/js/lib/jquery.min.js"></script>
    <script>

            $(document).on('click','disability-check',function(e){
                $('#content').append(`
                    <div id = 'plot-modal' style = 'width:100%;height:100%;background:rgba(0,0,0,0.7);position:fixed;top:-1%;'>
                        <div id = 'plot-inner-modal' style = 'width:50%;height:20%;margin:15%;background:#fff;'>
                            <form accept-charset=utf8>
                                <textarea id = 'check-disability'></textarea>
                                <button id = 'confirm-disability'>OK</button>
                            </form>
                        </div>
                    </div>
                `)
            });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp\htdocs\courses\project\application\Modules/Application\Resources/views/applicant/updatePage.blade.php ENDPATH**/ ?>