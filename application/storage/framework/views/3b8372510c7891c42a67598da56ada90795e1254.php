<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Update Application Status
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Application</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Status
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="row">
                    <div class="col-lg-7 mb-1">
                        <div class="row p-1">
                            <div class="col-md-4 fw-bolder text-start">Applicant Name </div>
                            <div class="col-md-8"> <?php echo e($app->applicant->sname); ?> <?php echo e($app->applicant->fname); ?> <?php echo e($app->applicant->mname); ?></div>
                        </div>
                        <div class="row p-1">
                            <div class="col-md-4 fw-bolder text-start">Course Name</div>
                            <div class="col-md-8"> <?php echo e($app->courses->course_name); ?> </div>
                        </div>
                        <div class="row p-1">
                            <div class="col-md-4 fw-bolder text-start">Course Name</div>
                            <div class="col-md-8"> <?php echo e($app->receipt); ?> </div>
                        </div>
                        <?php if($app->finance_status === 2): ?>

                            <div class="row p-1">
                                <div class="col-md-4 fw-bolder text-start">Why rejected?</div>
                                <div class="col-md-8">
                                    <p><?php echo e($app->finance_comments); ?></p>
                                </div>
                            </div>

                        <?php endif; ?>
                    </div>
                    <div class="col-lg-5 space-y-2">
                        <div class="d-flex justify-content-center">
                            <div class="card-img" style="margin: auto !important;">
                                <img style="margin: auto !important; max-height: 80vh !important; width: 100% !important;" src="<?php echo e(url('receipts/', $app->receipt_file)); ?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center py-1">
                    <a class="btn btn-sm btn-alt-secondary m-2" data-toggle="click-ripple" href="<?php echo e(route('finance.applications')); ?>">Close</a>
                </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('applications::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sims\application\Modules/Finance\Resources/views/applications/preview.blade.php ENDPATH**/ ?>