

<?php $__env->startSection('content'); ?>

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
              <h4 class="">
                  
              </h4>
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Department</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a  href="showDepartment">View Departments</a>
                  </li>
              </ol>
          </nav>
      </div>
  </div>
</div>
    <div class="content">
      <div  style="margin-left:20%;" class="block block-rounded col-md-9 col-lg-8 col-xl-6">
            <div class="block-header block-header-default">
              <h3 class="block-title">ADD DEPARTMENT</h3>
            </div>
            <div class="block-content block-content-full">
              <div class="row">
                <div class="col-lg-12 space-y-0">

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="<?php echo e(route('courses.storeDepartment')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <div class="col-12 col-xl-12">
                      <select name="school" class="form-control form-control-alt text-uppercase">
                        <option selected disabled> Select School </option>
                        <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($school->name); ?>"><?php echo e($school->name); ?></option>        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    <div class="col-12 col-xl-12">
                      <input type="text" value="<?php echo e(old('name')); ?>"  class="form-control form-control-alt text-uppercase" id="name" name="name" placeholder="Department">
                    </div>
                    <div class="col-12 text-center p-3">
                      <button type="submit" class="btn btn-alt-success" data-toggle="click-ripple">Create Department</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
    </div> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp\htdocs\courses\project\application\Modules/Registrar\Resources/views/department/addDepartment.blade.php ENDPATH**/ ?>