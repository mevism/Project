<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php $__env->startSection('content'); ?>

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
            <div class="block-header block-header-default">
              <h3 class="block-title">ADD DEPARTMENT</h3>
            </div>
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Department</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a  href="showDepartment">Add Departments</a>
                  </li>
              </ol>
          </nav>
      </div>
  </div>
</div>
<div class="content">
  <div class="block block-rounded col-md-12 col-lg-12 col-xl-12">
        <div class="block-content block-content-full">
          <div class="row">
            <div class="d-flex justify-content-center">
                <div class="col-lg-6 space-y-0">

                   <form class="row row-cols-lg-auto g-3 align-items-center" action="<?php echo e(route('admin.storeDepartment')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                       <div class="form-floating col-12 col-xl-12">
                           <select name="division" class="form-control text-uppercase" id="division">
                               <option selected disabled> Select Division </option>
                               <?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <option value="<?php echo e($division->name); ?>"><?php echo e($division->name); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                           <label class="form-label">DIVISION NAME</label>
                       </div>
                      <div class="form-floating col-12 col-xl-12" id="school">
                      <select name="school" class="form-control text-uppercase" >
                        <option selected disabled> Select School </option>
                        <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($school->school_id); ?>"><?php echo e($school->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                          <label class="form-label">SCHOOL NAME</label>
                      </div>

                    <div class="form-floating col-12 col-xl-12">
                      <input type="text" value="<?php echo e(old('dept_code')); ?>"  class="form-control text-uppercase" id="dept_code" name="dept_code" placeholder="Department code">
                      <label class="form-label">DEPARTMENT CODE</label>
                    </div>

                    <div class="form-floating col-12 col-xl-12">
                      <input type="text" value="<?php echo e(old('name')); ?>"  class="form-control text-uppercase" id="name" name="name" placeholder="Department Name">
                      <label class="form-label">DEPARTMENT NAME</label>
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
    </div>
<?php $__env->stopSection(); ?>

<script>
    $(document).ready(function() {
        $('#school').hide();

        $('#division').on('change', function (){
            var academicValue = $('#division').val();

            if (academicValue == 'ACADEMIC DIVISION'){
                $('#school').show();
            }else {
                $('#school').hide();
            }

        })
    });
</script>

<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Administrator\Resources/views/department/addDepartment.blade.php ENDPATH**/ ?>