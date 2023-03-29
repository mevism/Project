
<?php $__env->startSection('content'); ?>

    <div class="bg-image" style="background-image: url( <?php echo e(url('media/photos/photo12@2x.jpg')); ?> );">
      <div class="bg-black-50">
        <div class="content content-full text-center">
          <div class="my-3">
            <img class="img-avatar img-avatar-thumb" src="<?php echo e(url('media/profile', auth()->guard('user')->user()->profile_image)); ?>" alt="">
          </div>
          <h1 class="h2 text-white mb-0"><?php echo e(auth()->guard('user')->user()->title); ?> <?php echo e(auth()->guard('user')->user()->last_name); ?> <?php echo e(auth()->guard('user')->user()->first_name); ?> <?php echo e(auth()->guard('user')->user()->middle_name); ?></h1>
          <span class="text-white-75">Lecturer</span><br>
          <a class="btn btn-sm btn-alt-secondary mt-3" href="<?php echo e(route('lecturer.editMyprofile')); ?>">
            <i class=" text-danger"></i> Edit Profile
          </a>
        </div>
      </div>
    </div>
    <!-- END Hero -->

   

    <!-- Page Content -->
    <div class="content content-boxed">
      <div class="row">
        <div class="col-md-7 col-xl-8">
          <!-- Updates -->
          <ul class="timeline timeline-alt py-0">
            <li class="timeline-event">
              <div class="timeline-event-icon bg-default">
                <i class="fa fa-id-card"></i>
              </div>
              <div class="timeline-event-block block">
                <div class="block-header">
                  <h3 class="block-title">Personal Details</h3>
                  <div class="block-options">
                  </div>
                </div>
                <div class="block-content">
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-4">Name:</div>
                        <div class="col-md-8"><?php echo e(auth()->guard('user')->user()->title); ?> <?php echo e(auth()->guard('user')->user()->last_name); ?> <?php echo e(auth()->guard('user')->user()->first_name); ?> <?php echo e(auth()->guard('user')->user()->middle_name); ?>

                        </div>
                </div>
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-4">Staff No:</div>
                        <div class="col-md-8"><?php echo e(auth()->guard('user')->user()->staff_number); ?></div>
                </div>
                <div class="row m-2 fs-sm" >
                    <div class="col-md-4">Gender:</div>
                    <div class="col-md-8"> <?php if(auth()->guard('user')->user()->gender=='F'): ?>
                        Female
                         <?php else: ?> Male
                         <?php endif; ?></div>
            </div>
              </div>
            </li>
            <li class="timeline-event">
              <div class="timeline-event-icon bg-modern">
                <i class="fa fa-phone"></i>
              </div>
              <div class="timeline-event-block block">
                <div class="block-header">
                  <h3 class="block-title">Contant Details</h3>
                  <div class="block-options">
                  </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-4">Phone Number:</div>
                        <div class="col-md-8"><?php echo e(auth()->guard('user')->user()->phone_number); ?></div>
                </div>
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-4">Office Email:</div>
                        <div class="col-md-8"><?php echo e(auth()->guard('user')->user()->office_email); ?></div>
                </div>
                <div class="row m-2 fs-sm" >
                    <div class="col-md-4">Personal Email:</div>
                    <div class="col-md-8"><?php echo e(auth()->guard('user')->user()->personal_email); ?></div>
            </div>
                </div>
              </div>
            </li>
            <li class="timeline-event">
              <div class="timeline-event-icon bg-info">
                <i class="fa fa-briefcase"></i>
              </div>
              <div class="timeline-event-block block">
                <div class="block-header">
                  <h3 class="block-title">Department Details</h3>
                </div>
                <div class="block-content">
                    <?php $__currentLoopData = auth()->guard('user')->user()->placedUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-3">Department:</div>
                        <div class="col-md-9">
                            <?php echo e($employment->userDepartment->name); ?>

                    </div>
                    </div>
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-3">Station:</div>
                        <div class="col-md-9">
                            <?php echo e($employment->userDepartment->name); ?>

                        </div>
                    </div>

                    <div class="row m-2 fs-sm" >
                        <div class="col-md-3">Role:</div>
                        <div class="col-md-9">
                             <?php echo e($employment->userRole->name); ?>

                        </div>
                    </div>
                    <div class="row m-2 fs-sm" >
                        <div class="col-md-3">Contract:</div>
                        <div class="col-md-9">
                             <?php echo e($employment->employment_terms); ?>

                        </div>
                    </div>
                    <hr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
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
                <i class="fa fa-briefcase text-muted me-1"></i> Qualifications
              </h3>
              <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                  
                </button>
              </div>
            </div>
            <div class="block-content">
                <?php $__currentLoopData = $qualifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$qualification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="d-flex align-items-center push">
                    <div class="flex-shrink-0 me-3">
                    <a class="item item-rounded fs-lg" href="javascript:void(0)">
                        <i class="fa fa-book"></i> 
                    </a>
                    </div>
                <div class="flex-grow-1">
                  <div class="fw-semibold">
                    <?php if($qualification->level==1): ?> 
                    CERTIFICATE
                    <?php elseif($qualification->level==2): ?>
                        DIPLOMA
                    <?php elseif($qualification->level==3): ?>
                        BACHELORS
                    <?php elseif($qualification->level==4): ?>
                        MASTERS 
                    <?php elseif($qualification->level==5): ?>
                        PHD 
                    <?php endif; ?>
                   
              </div>
                  <div class="fs-sm"><?php echo e($qualification ->qualification); ?></div>
                </div>
              </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          </div>
          <!-- END Products -->
        </div>
      
    
    <!-- END Page Content -->
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('lecturer::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\project\application\Modules/Lecturer\Resources/views/profile/myprofile.blade.php ENDPATH**/ ?>