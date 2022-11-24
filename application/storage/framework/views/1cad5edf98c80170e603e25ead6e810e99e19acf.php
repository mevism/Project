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
                        Update Exam Results
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Department</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Student Results
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
                    <form method="POST" action="<?php echo e(route('department.updateResults', ['id' => Crypt::encrypt($result->id)])); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row row-cols-sm-1 g-2">
                            <div class="form-floating mb-2">
                                <select name="student" class="form-control form-select">
                                    <option selected value="<?php echo e($result->student_id); ?>" > <?php echo e($result->studentResults->reg_number); ?> <?php echo e($result->studentResults->sname.' '.$result->studentResults->fname.' '.$result->studentResults->mname); ?> </option>
                                </select>
                            </div>
                            <div class="form-floating mb-2">
                                <select name="stage" class="form-control form-select">
                                    <option <?php if($result->stage == 1): ?> selected <?php endif; ?> value="1">Year 1</option>
                                    <option <?php if($result->stage == 2): ?> selected <?php endif; ?> value="2">Year 2</option>
                                    <option <?php if($result->stage == 3): ?> selected <?php endif; ?> value="3">Year 3</option>
                                    <option <?php if($result->stage == 4): ?> selected <?php endif; ?> value="4">Year 4</option>
                                    <option <?php if($result->stage == 5): ?> selected <?php endif; ?> value="5">Year 5</option>
                                </select>
                            </div>
                            <div class="form-floating mb-2">
                                <select name="status" class="form-control form-select">
                                    <option selected disabled class="text-center"> -- select status -- </option>
                                    <option <?php if($result->status == 1): ?> selected <?php endif; ?> value="1">Pass</option>
                                    <option <?php if($result->status == 2): ?> selected <?php endif; ?> value="2">Fail</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-outline-success col-md-7" data-toggle="click-ripple">Update Result</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('cod::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/COD\Resources/views/exams/editExam.blade.php ENDPATH**/ ?>