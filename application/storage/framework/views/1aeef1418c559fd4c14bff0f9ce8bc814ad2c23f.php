<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Application Submission
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Application</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Batch submission
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-responsive-sm table-borderless table-striped js-dataTable-responsive">
                        <?php if(count($apps)>0): ?>
                            <thead>
                            <th>✔</th>
                            <th>Applicant Name</th>
                            <th>Course Name</th>
                            <th>Department </th>
                            <th>Status</th>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $apps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($app->registrar_status === null): ?>
                                            <form action="<?php echo e(route('dean.batchSubmit')); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <input class="batch" type="checkbox" name="submit[]" value="<?php echo e($app->id); ?>" required>
                                                <?php else: ?>
                                                    ✔
                                        <?php endif; ?>
                                    </td>
                                    <td> <?php echo e($app->applicant->sname); ?> <?php echo e($app->applicant->fname); ?> <?php echo e($app->applicant->mname); ?></td>
                                    <td> <?php echo e($app->course); ?></td>
                                    <td> <?php echo e($app->department); ?></td>
                                    <td>
                                        <?php if($app->cod_status === 0): ?>
                                            <span class="badge bg-primary">Awaiting</span>
                                        <?php elseif($app->cod_status === 1): ?>
                                            <span class="badge bg-success">Approved</span>
                                        <?php elseif($app->cod_status === 2): ?>
                                            <span class="badge bg-warning">Rejected</span>
                                        <?php else: ?>
                                            <span class="badge bg-primary">Awaiting</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        <?php else: ?>
                            <tr>
                                <span class="text-muted text-center fs-sm">There are no applications awaiting batch submission</span>
                            </tr>
                        <?php endif; ?>
                    </table>
                    <?php if(count($apps)>0): ?>
                        <div>
                            <input type="checkbox" onclick="for(c in document.getElementsByClassName('batch')) document.getElementsByClassName('batch').item(c).checked = this.checked"> Select all
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-sm btn-alt-primary" data-toggle="click-ripple">Submit batch</button>
                        </div>
                        <?php endif; ?>
                        </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dean::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sims\application\Modules/Dean\Resources/views/applications/batch.blade.php ENDPATH**/ ?>