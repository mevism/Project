<?php $__env->startSection('content'); ?>
<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <div class="flex-grow-1">
          <h6 class="block-title">
            EDIT CALENDER OF EVENTS
          </h6>
      </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">Calender</a>
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
                <div class="col-lg-8 space-y-0">

                   <form action="<?php echo e(route('courses.updateCalenderOfEvents', ['id'=> Crypt::encrypt($data->id)])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                     <?php echo method_field('PUT'); ?>
                      <div class="form-floating col-12 col-xl-12 mb-2">
                        <select name="academicyear" class="form-control form-control-alt text-uppercase">
                          <option selected value="<?php echo e($data->academic_year_id); ?>"> <?php echo e($data->academic_year_id); ?> </option>
                          <?php $__currentLoopData = $academicyear; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e(Carbon\carbon::parse($item->year_start)->format('Y')); ?>/<?php echo e(Carbon\carbon::parse($item->year_end)->format('Y')); ?>"><?php echo e(Carbon\carbon::parse($item->year_start)->format('Y')); ?>/<?php echo e(Carbon\carbon::parse($item->year_end)->format('Y')); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <label class="form-label">ACADEMIC YEAR</label>
                        </select>
                      </div>

                      <div class="form-floating col-12 col-xl-12 mb-2">
                        <select name="semester" class="form-control form-control-alt text-uppercase">
                            <option <?php if($data->intake_id == 'SEP/DEC'): ?> selected <?php endif; ?> value="SEP/DEC">SEP/DEC</option>
                            <option <?php if($data->intake_id == 'JAN/APR'): ?> selected <?php endif; ?> value="JAN/APR">JAN/APR</option>
                            <option <?php if($data->intake_id == 'MAY/AUG'): ?> selected <?php endif; ?> value="MAY/AUG">MAY/AUG</option>
                          <label class="form-label">SEMESTER</label>
                        </select>
                      </div>

                      <div class="form-floating col-12 col-xl-12 mb-2">
                        <select name="events" class="form-control form-control-alt text-uppercase">
                          <option selected value="<?php echo e($data->event_id); ?>"> <?php echo e($data->events->name); ?> </option>
                          <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($event->id); ?>"><?php echo e($event->name); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <label class="form-label">EVENT NAME</label>
                        </select>
                      </div>

                      <div class="form-floating col-12 col-xl-12 mb-2" >
                        <input type="date" class="form-control form-control-alt" value="<?php echo e($data->start_date); ?>" id="start_date" name="start_date" placeholder="Start Date">
                        <label class="form-label">START DATE</label>
                      </div>

                      <div class="form-floating col-10 col-xl-12 mb-2">
                        <input type="date" class="form-control form-control-alt" value="<?php echo e($data->end_date); ?>" name="end_date" placeholder="End Date">
                        <label class="form-label">END DATE</label>
                      </div>

                    <div class="col-12 text-center p-3 mb-4">
                      <button type="submit"  class="btn btn-alt-success" data-toggle="click-ripple">Update Calender Event</button>
                    </div>
                  </form>

                </div>
               </div>
              </div>
            </div>
          </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Registrar/application/Modules/Registrar/Resources/views/eventsCalender/editCalenderOfEvents.blade.php ENDPATH**/ ?>