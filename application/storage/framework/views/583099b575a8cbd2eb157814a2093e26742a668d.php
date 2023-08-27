<style>
    .amount {
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
        box-shadow: none !important;
        background: none !important;
    }
</style>
<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0">
                        PAYMENT
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">PAYMENT</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            REQUEST PAYMENT
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset class="border p-2" style="height: 100% !important;">
                        <legend class="float-none w-auto"><h6 class="fw-bold text-center"> STUDENT DETAILS</h6></legend>
                        <div class="mb-4">
                            <span class="h5 fs-sm">STUDENT NAME : </span>
                            <span class="h6 fs-sm fw-normal"> <?php echo e(auth()->guard('epayments')->user()->student_name); ?> </span>
                        </div>
                        <div class="mb-4">
                            <span class="h5 fs-sm">STUDENT NUMBER : </span>
                            <span class="h6 fs-sm fw-normal"> <?php echo e(auth()->guard('epayments')->user()->username); ?> </span>
                        </div>
                        <div class="mb-4">
                            <span class="h5 fs-sm">STUDENT NAME : </span>
                            <span class="h6 fs-sm fw-normal"> <?php echo e(auth()->guard('epayments')->user()->student_email); ?> </span>
                        </div>
                        <div class="mb-4">
                            <span class="h5 fs-sm">PHONE NUMBER : </span>
                            <span class="h6 fs-sm fw-normal"> <?php echo e(auth()->guard('epayments')->user()->phone_number); ?></span>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6 space-y-0">
                    <fieldset class="border p-2" style="height: 100% !important;">
                        <legend class="float-none w-auto"><h6 class="fw-bold text-center"> INVOICE DETAILS</h6></legend>
                        <div class="mb-4">
                            <span class="h5 fs-sm">FEE BALANCE : </span>
                            <span class="h6 fs-sm fw-normal"> <?php echo e($fee); ?> </span>
                        </div>
                        <div class="mb-4">
                             <h6 class="mb-2 mx-5 text-decoration-underline"> PAYMENT DESCRIPTION <sup class="text-danger">*</sup></h6>
                                <form method="POST" action="<?php echo e(route('epayment.makeRequest')); ?>">
                                   <?php echo csrf_field(); ?>
                                    <div class="mx-5 mb-4">
                                        <select name="type" class="form-control">
                                            <option disabled selected>-- select -- </option>
                                            <option value="SEMESTER TUITION FEE"> SEMESTER TUITION FEE </option>
                                            <option value="MID-ENTRY FEE"> MID-ENTRY FEE </option>
                                            <option value="ACCOMMODATION FEE"> ACCOMMODATION FEE </option>
                                            <option value="GRADUATION FEE"> GRADUATION FEE </option>
                                            <option value="CHANGE OF COURSE"> CHANGE OF COURSE </option>
                                            <option value="SUPPLEMENTARY EXAMS"> SUPPLEMENTARY EXAMS </option>
                                            <option value="RETAKES"> RETAKES </option>
                                            <option value="PENALTY/FINES"> PENALTY/FINES </option>
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="mb-4 col-md-5"><span class="h5 fs-sm">AMOUNT TO PAY (KSH.):<sup class="text-danger">*</sup> </span></div>
                                        <div class="mb-4 col-md-7">
                                            <input type="number" name="amount" id="amount" class="form-control col-md-8 amount">
                                        </div>
                                        <div class="mb-4 col-md-5"><span class="h5 fs-sm">CONVENIENCE FEE (KSH.) : </span></div>
                                        <div class="mb-4 col-md-7">
                                            <input type="number" name="convenience" id="convenience" readonly class="form-control col-md-8 amount">
                                        </div>
                                        <div class="mb- col-md-5"><span class="h5 fs-sm">TOTAL AMOUNT TO PAY (KSH.) : </span></div>
                                        <div class="mb-4 col-md-7">
                                            <input type="number" name="total_amount" id="total_amount" readonly class="form-control col-md-8 amount">
                                        </div>
                                    </div>

                                   <div class="mb-4 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-alt-success">Proceed to pay</button>
                                   </div>
                                </form>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#amount').on('change', function () {
            var amount = $(this).val();
            var convenience = 50;
            $('#convenience').val(convenience);
            $('#total_amount').val(parseFloat(amount) + parseFloat(convenience));
        });
    });
</script>



<?php echo $__env->make('epayment::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Epayment\Resources/views/dashboard/requestPayment.blade.php ENDPATH**/ ?>