<?php $__env->startSection('content'); ?>
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <div class="flex-grow-1">
                <h6 class="block-title">IMPORT UNITS</h6>         
            </div>  
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded col-md-12 col-lg-12 col-xl-12">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="d-flex justify-content-center">
                    <div class="col-lg-6 space-y-0">
                        <form class="row row-cols-lg-auto g-3 align-items-center" action="<?php echo e(route('courses.importUnit')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="col-12 col-xl-12">
                                <label class="mb-2 fw-bold">File Import</label>
                                <input type="file" name="excel_file" class="form-control">
                            </div>
                            <br>
                            <div class="col-12 col-xl-12">
                               <button type="submit" class="btn btn-alt-success mb-3">Import </button>
                            </div>
                        </form>
                     </div>
                </div>
                <?php if(count($units) > 0): ?>
                    <div class="d-flex justify-content-center">
                        <span class="text-success"> You have imported <?php echo e(count($units)); ?> Units </span> 
                    </div>
                 <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Registrar/application/Modules/Registrar/Resources/views/offer/unit.blade.php ENDPATH**/ ?>