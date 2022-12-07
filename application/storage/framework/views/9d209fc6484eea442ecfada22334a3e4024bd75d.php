<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">



<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Application Approval
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Application</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Approvals
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="d-flex justify-content-center">
                <div class="col-md-6 space-y-0">
                    <form method="POST" action="<?php echo e(route('finance.submitInvoice')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row row-cols-sm-1 g-2">
                            <div class="form-floating mb-2">
                                <select name="student" class="form-control form-select">
                                    <option selected disabled class="text-center"> -- select student -- </option>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($student->reg_number); ?>"> <?php echo e($student->reg_number); ?> <?php echo e($student->sname.' '.$student->fname.' '.$student->mname); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="amount" class="form-control" placeholder="amount" value="<?php echo e(old('amount')); ?>">
                                <label>Amount</label>
                            </div>
                            <div class="form-floating mb-2">
                                <textarea name="description" class="form-control" style="height: 150px !important;" placeholder="Desc"></textarea>
                                <label>Description</label>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-outline-success col-md-7" data-toggle="click-ripple">Save Invoice</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('applications::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Registrar/application/Modules/Finance/Resources/views/invoices/addInvoice.blade.php ENDPATH**/ ?>