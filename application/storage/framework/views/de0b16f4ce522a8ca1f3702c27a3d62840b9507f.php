<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-1">
                        Admission
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">My Courses</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                           Upload admission documents
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-bordered">
        <div class="block-content block-content-full">

            <table class="table table-sm table-striped table-bordered table-vcenter fs-sm">

                <thead>
                    <th>#</th>
                    <th>Document</th>
                    <th>File uploaded</th>
                    <th>Upload</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Academic certificates (as 1 pdf document)</td>
                        <td>
                            <?php if($admission->admissionDoc != null): ?>
                                <?php echo e($admission->admissionDoc->certificates); ?>

                            <?php else: ?>
                            no file
                            <?php endif; ?>
                        </td>
                        <td>
                            <form method="POST" action="<?php echo e(route('application.academicDoc')); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="file" class="form-control-sm" name="academicDoc" <?php if($admission->admissionDoc != null && $admission->admissionDoc->status == 1): ?> disabled <?php endif; ?>>
                                <input type="hidden" name="academicDocId" value="<?php echo e($admission->id); ?>">
                                <button type="submit" class="btn btn-sm btn-success" <?php if($admission->admissionDoc != null && $admission->admissionDoc->status == 1): ?> disabled <?php endif; ?> ><i class="fa fa-file-upload"></i> upload</button>
                            </form>
                        </td>
                        <td>
                            <?php if($admission->admissionDoc == null): ?>
                                <i class="fa fa-spinner text-primary"></i> <span class="text-primary">Pending</span>
                            <?php else: ?>
                            <?php if($admission->admissionDoc->certificates == null): ?>
                                    <i class="fa fa-spinner text-primary"></i> <span class="text-primary">Pending</span>
                                <?php else: ?>
                                    <i class="fa fa-check text-success"></i> <span class="text-success fw-bold">Uploaded</span>
                            <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Bank slip/receipt/cheques (as 1 pdf document)</td>
                        <td>
                            <?php if($admission->admissionDoc != null): ?>
                                <?php echo e($admission->admissionDoc->bank_receipt); ?>

                            <?php else: ?>
                                no file
                            <?php endif; ?>
                        </td>
                        <td>
                            <form method="POST" action="<?php echo e(route('application.bankReceipt')); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="file" name="bankReceipt" class="form-control-sm" <?php if($admission->admissionDoc != null && $admission->admissionDoc->status == 1): ?> disabled <?php endif; ?>>
                                <input type="hidden" name="bankReceiptId" value="<?php echo e($admission->id); ?>">
                                <button type="submit" class="btn btn-sm btn-success" <?php if($admission->admissionDoc != null && $admission->admissionDoc->status == 1): ?> disabled <?php endif; ?> ><i class="fa fa-file-upload"></i> upload</button>
                            </form>
                        </td>
                        <td>
                            <?php if($admission->admissionDoc != null): ?>
                            <?php if($admission->admissionDoc->bank_receipt == null): ?>
                                    <i class="fa fa-spinner text-primary"></i> <span class="text-primary">Pending</span>
                                <?php else: ?>
                                    <i class="fa fa-check text-success"></i> <span class="text-success fw-bold">Uploaded</span>
                            <?php endif; ?>
                            <?php else: ?>
                                <i class="fa fa-spinner text-primary"></i> <span class="text-primary">Pending</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Medical Report form (as 1 pdf document)</td>
                        <td>
                            <?php if($admission->admissionDoc != null): ?>
                                <?php echo e($admission->admissionDoc->medical_form); ?>

                            <?php else: ?>
                                no file
                            <?php endif; ?>
                        </td>
                        <td>
                            <form method="POST" action="<?php echo e(route('application.medicalForm')); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="file" name="medicalForm" class="form-control-sm" <?php if($admission->admissionDoc != null && $admission->admissionDoc->status == 1): ?> disabled <?php endif; ?>>
                                <input type="hidden" name="medicalFormId" value="<?php echo e($admission->id); ?>">
                                <button type="submit" class="btn btn-sm btn-success" <?php if($admission->admissionDoc != null && $admission->admissionDoc->status == 1): ?> disabled <?php endif; ?> ><i class="fa fa-file-upload"></i> upload</button>
                            </form>
                        </td>
                        <td>
                            <?php if($admission->admissionDoc != null): ?>
                            <?php if($admission->admissionDoc->medical_form == null): ?>
                                    <i class="fa fa-spinner text-primary"></i> <span class="text-primary">Pending</span>
                                <?php else: ?>
                                <i class="fa fa-check text-success"></i> <span class="text-success fw-bold">Uploaded</span>
                            <?php endif; ?>
                            <?php else: ?>
                                <i class="fa fa-spinner text-primary"></i> <span class="text-primary">Pending</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Student PassPort (as 1 Image)</td>
                        <td>
                            <?php if($admission->admissionDoc != null): ?>
                                <?php echo e($admission->admissionDoc->passport_photo); ?>

                            <?php else: ?>
                                no file
                            <?php endif; ?>
                        </td>
                        <td>
                            <form method="POST" action="<?php echo e(route('application.passportPhoto')); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="file" name="passPort" class="form-control-sm" <?php if($admission->admissionDoc != null && $admission->admissionDoc->status == 1): ?> disabled <?php endif; ?>>
                                <input type="hidden" name="passPortId" value="<?php echo e($admission->id); ?>">
                                <button type="submit" class="btn btn-sm btn-success" <?php if($admission->admissionDoc != null && $admission->admissionDoc->status == 1): ?> disabled <?php endif; ?> ><i class="fa fa-file-upload"></i> upload</button>
                            </form>
                        </td>
                        <td>
                            <?php if($admission->admissionDoc != null): ?>
                            <?php if($admission->admissionDoc->passport_photo == null): ?>
                                    <i class="fa fa-spinner text-primary"></i> <span class="text-primary">Pending</span>
                                <?php else: ?>
                                <i class="fa fa-check text-success"></i> <span class="text-success fw-bold">Uploaded</span>
                            <?php endif; ?>
                            <?php else: ?>
                                <i class="fa fa-spinner text-primary"></i> <span class="text-primary">Pending</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
                <?php if($admission->admissionDoc == null): ?>

                   <div class="d-flex justify-content-center">
                       <div class="content-boxed m-3 fs-sm">
                           <p> All academic documents should be scanned in to one document for upload </p>
                           <p> After uploading all documents a button will appear requesting you to submit your documents. Ensure that correct documents are uploaded before submitting</p>
                           <p> Once you have submitted your documents you will not be able to edit them. Please be careful while uploading your documents. </p>
                       </div>
                   </div>

                <?php else: ?>
                <?php if($admission->admissionDoc->certificates &&  $admission->admissionDoc->bank_receipt && $admission->admissionDoc->medical_form && $admission->admissionDoc->passport_photo != null): ?>
                    <?php if($admission->admissionDoc->status == 0): ?>
            <div class="d-flex justify-content-center m-3">
                <a class="btn btn-sm btn-alt-success" data-toggle="click-ripple" onclick="return confirm('You are about to submit your documents. Once submitted cannot be changed. Are you sure you want to proceed?')" href="<?php echo e(route('application.submitDocuments', ['id' => Crypt::encrypt($admission->id)])); ?>">Submit documents</a>
            </div>
                    <?php else: ?>
                        <p class="h6 text-center text-success m-4">Your documents are being processed</p>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="d-flex justify-content-center">
                        <div class="content-boxed m-3 fs-sm">
                            <p> All academic documents should be scanned in to one document for upload </p>
                            <p> After uploading all documents a button will appear requesting you to submit your documents. Ensure that correct documents are uploaded before submitting</p>
                            <p> Once you have submitted your documents you will not be able to edit them. Please be careful while uploading your documents. </p>
                        </div>
                    </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Registrar/application/Modules/Application/Resources/views/applicant/admission.blade.php ENDPATH**/ ?>