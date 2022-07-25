<script>

    <?php if(count($errors) > 0): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    toastr.error("<?php echo e($error); ?>");
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <?php if(Session::has('error')): ?>
        toastr.options = {
        "closeButton" : true,
        "progressBar" : true,
        "closeDuration" : 5000
    }
    toastr.error("<?php echo e(session('error')); ?>");
    <?php endif; ?>
        <?php if(Session::has('success')): ?>
        toastr.options = {
        "closeButton" : true,
        "progressBar" : true,
        "closeDuration" : 5000
    }
    toastr.success("<?php echo e(session('success')); ?>");
    <?php endif; ?>

        <?php if(Session::has('info')): ?>
        toastr.options = {
        "closeButton" : true,
        "progressBar" : true,
        "closeDuration" : 5000
    }
    toastr.info("<?php echo e(session('info')); ?>");
    <?php endif; ?>

        <?php if(Session::has('warning')): ?>
        toastr.options = {
        "closeButton" : true,
        "progressBar" : true,
        "closeDuration" : 5000
    }
    toastr.warning("<?php echo e(session('warning')); ?>");
    <?php endif; ?>
</script>




































<?php /**PATH /var/www/html/Finale/application/Modules/Application/Resources/views/messages/notification.blade.php ENDPATH**/ ?>