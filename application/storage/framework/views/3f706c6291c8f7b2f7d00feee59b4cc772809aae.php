

<?php $__env->startSection('content'); ?>
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: <?php echo config('medical.name'); ?>

    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('medical::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sims\application\Modules/Medical\Resources/views/index.blade.php ENDPATH**/ ?>