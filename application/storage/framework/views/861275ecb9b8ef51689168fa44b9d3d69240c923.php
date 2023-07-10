

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        My Qualifications
                    </h5>
                </div>

                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Profile</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            My Qualifications
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
                            <div class="d-flex justify-content-end m-2">
                                <a class="btn btn-sm btn-alt-primary" data-toggle="click-ripple" href="<?php echo e(route('lecturer.addqualifications')); ?>">Add Qualifications </a>
                            </div>
        
            <table id="example" class="table table-sm table-bordered table-striped js-dataTable-responsive fs-sm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('delete'); ?>

                    <thead>
                        <th></th>
                        <th>Level</th>
                        <th>Institution</th>
                        <th>Qualification</th>
                        <th>Status</th>
                        <th>Action</th>

                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $qualifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $qualification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(++$key); ?></td>
                                <td>
                                    <?php if($qualification->level==1): ?> 
                                        CERTIFICATE
                                    <?php elseif($qualification->level==2): ?>
                                         DIPLOMA
                                    <?php elseif($qualification->level==3): ?>
                                        BACHELORS
                                    <?php elseif($qualification->level==4): ?>
                                        MASTERS 
                                    <?php elseif($qualification->level==5): ?>
                                        PHD 
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($qualification->institution); ?></td>
                                <td><?php echo e($qualification->qualification); ?></td>
                                <td nowrap>
                                    <?php if($qualification->qualification_status == 0): ?>
                                    <span class="badge bg-primary"> <i class="fa fa-spinner"></i> pending</span>
                                    <?php elseif($qualification->qualification_status==1): ?>
                                    <span class="badge bg-success"> <i class="fa fa-check"></i> Approved</span>
                                    <?php elseif($qualification->qualification_status==2): ?>
                                    <span class="badge bg-danger" > <i class="fa fa-ban" ></i> Declined </span> 
                                    <span> 
                                    <a class="link m-3" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo e($qualification->id); ?>"> Why? </a>
                                    </span>
                                    <?php endif; ?> 
                                </td>
                                <td>
                                    <?php if($qualification->qualification_status==0): ?>
                                    <a class="btn btn-sm btn-alt-danger" href="<?php echo e(route('lecturer.deleteQualification', ['id' => Crypt::encrypt($qualification->id)] )); ?>">Drop</a>
                                    <?php elseif($qualification->qualification_status==1): ?>
                                    <a class="btn btn-sm btn-alt-success" disabled>Verified</a>
                                    <?php elseif($qualification->qualification_status==2): ?>
                                    <a class="btn btn-sm btn-alt-info" href="<?php echo e(route('lecturer.editQualifications', ['id' => Crypt::encrypt($qualification->id)])); ?>">Edit</a>
                                    <a class="btn btn-sm btn-alt-danger" href="<?php echo e(route('lecturer.deleteQualification', ['id' => Crypt::encrypt($qualification->id)] )); ?>">Drop</a>
                                    <?php endif; ?> 
                                </td>




                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal-<?php echo e($qualification->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h6 class="modal-title fs-5" id="exampleModalLabel">Qualification Remarks</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php $__currentLoopData = $qualification->getQualificationRemark; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <p><?php echo e(\Carbon\Carbon::parse($remark->created_at)->format('d-M-y')); ?> - <?php echo e($remark->remarks); ?></p>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                        </div>
                                    </div>
                                    </div>
                                </div>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
                </div>
                </div>
            </div>
        <?php $__env->stopSection(); ?>

        <script>
            $(document).ready(function() {
                $('#example').DataTable( {
                    responsive: true,
                    order: [[0, 'asc']],
                    rowGroup: {
                        dataSrc: 2
                    }
                } );
            } );
        </script>

<?php echo $__env->make('lecturer::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\project1\application\Modules/Lecturer\Resources/views/profile/qualifications.blade.php ENDPATH**/ ?>