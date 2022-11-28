

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

<?php $__env->startSection('content'); ?>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">How to initiate the process of admission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Step 1. Choose the course that you want to attach your admission documents to and click the link upload docs.</p>
                    <p>Step 2. Ensure you have all the documents as required. All the documents are required.</p>
                    <p>Step 3. Organize your document as follows</p>
                    <ol class="ml-6">
                        <li>Pdf scanned Academic documents - Course acceptance letter, student personal details and all your academic certificates/results slip</li>
                        <li>Pdf scanned Medical Examination Form</li>
                        <li>Pdf scanned Fee payment bank slips</li>
                        <li>.PNG, .JPG, .JPEG passport photo size</li>
                    </ol>
                    <span class="text-danger"> All the four (4) documents should be compressed to at most 4mbs.</span>
                    <p>Step 4. Upload all the documents as required</p>
                    <p>Step 5. Ensure all the documents are correctly uploaded and then submit for verification.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-alt-primary" data-bs-dismiss="modal">Understood, I want to continue</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(window).on('load', function() {
            $('#staticBackdrop').modal('show');
        });
    </script>

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-1">
                        Admissions
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Admissions</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Accepted Courses
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <table id="example" class="table table-md table-striped table-bordered table-vcenter fs-sm">
                <?php if(count($courses)>0): ?>
                    <thead>
                    <tr>
                        <th>Department</th>
                        <th>Course</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($course->courses->getCourseDept->name); ?></td>
                            <td><?php echo e($course->courses->course_name); ?></td>
                            <td nowrap="">
                                <?php if($course->registrar_status == 3 && $course->cod_status == 1): ?>
                                    <a class="btn btn-sm btn-alt-info" data-toggle="click-ripple" href="<?php echo e(route('application.uploadDocuments', ['id' => Crypt::encrypt($course->id)])); ?>"><i class="fa fa-file-upload"></i> upload docs</a>
                                <?php elseif($course->registrar_status == NULL && $course->finance_status == NULL): ?>
                                    <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('application.edit', ['id' => Crypt::encrypt($course->id)])); ?>">
                                        <i class="fa fa-pen-to-square"></i> update</a>
                                <?php elseif($course->registrar_status == 1 && $course->cod_status == 2): ?>
                                    <a class="btn btn-sm btn-alt-danger" href="#">
                                        <i class="fa fa-ban"></i> rejected</a>
                                <?php else: ?>
                                    <a class="btn btn-sm btn-alt-secondary disabled" href="<?php echo e(route('application.progress', ['id' => Crypt::encrypt($course->id)])); ?>"> <i class="fa fa-spinner"></i> in progress</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                <?php else: ?>
                    <small class="text-center text-muted"> You have not submitted any applications</small>
                <?php endif; ?>
            </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            responsive: true,
            order: [[2, 'asc']],
            rowGroup: {
                dataSrc: 2
            }
        } );
    } );
</script>

<?php echo $__env->make('application::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smis\application\Modules/Application\Resources/views/applicant/myadmissions.blade.php ENDPATH**/ ?>