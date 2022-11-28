


<?php $__env->startSection('content'); ?>

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0" style="text-align: center">
                         IMPORT CLUSTER WEIGHTS
                    </h5>
                </div>
             
            </div>
        </div>
    </div>

    <div class="content">
    <div  style="margin-left:20%;" class="block block-rounded col-md-9 col-lg-8 col-xl-6">
        <div class="block-header block-header-default">
            <h3 class="block-title" style="text-align: center">Import </h3>
          </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-12 space-y-0">
                    <form class="row row-cols-lg-auto g-3 align-items-center" action="<?php echo e(route('courses.importclusterWeights')); ?>" method="post" enctype="multipart/form-data">
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
            <?php if(count($clusters) > 0): ?>
            <div class="d-flex justify-content-center">

                <span class="text-success"> You have imported <?php echo e(count($clusters)); ?> Cluster Weights </span> 

            </div>
            <?php endif; ?>
                  </div>
        </div>
    </div>
    </div></div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Registrar\Resources/views/offer/clusterweights.blade.php ENDPATH**/ ?>