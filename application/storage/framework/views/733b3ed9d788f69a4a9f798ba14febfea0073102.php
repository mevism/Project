
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

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

<?php $__env->startSection('content'); ?>

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-1">
                    <h5 class="h6 fw-bold mb-0">
                        <?php echo e($user->title); ?> <?php echo e($user->last_name.' '.$user->first_name); ?> TEACHING AREAS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Teaching Areas</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Lecturer Teaching Areas
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">

        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-12 table-responsive table-primary">
                    <table id="example" class="table table-bordered table-responsive-sm table-striped table-vcenter js-dataTable-responsive fs-sm">
                        <thead>
                        <th>#</th>
                        <th> LEVEL OF STUDY </th>
                        <th> UNIT CODE </th>
                        <th> UNIT NAME </th>
                        <th> status </th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $user->teachingAreaUser()->latest()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td> <?php echo e(++$key); ?> </td>
                                <td>
                                    <?php if($area->level == 1): ?>
                                        CERTIFICATE
                                    <?php elseif($area->level == 2): ?>
                                        DIPLOMA
                                    <?php elseif($area->level == 3): ?>
                                        BACHELORS
                                    <?php elseif($area->level == 4): ?>
                                        MASTERS
                                    <?php else: ?>
                                        PHD
                                    <?php endif; ?>
                                </td>
                                <td> <?php echo e($area->unit_code); ?> </td>
                                <td> <?php echo e($area->teachingArea->unit_name); ?> </td>

                                <td>
                                    <?php if($area->status == 0): ?>
                                        <span class="badge bg-primary"> <i class="fa fa-spinner"></i> pending </span>
                                    <?php elseif($area->status == 1): ?>
                                        <span class="badge bg-success"> <i class="fa fa-check"></i> approved </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning"> <i class="fa fa-ban"></i> declined </span>
                                          <?php endif; ?>

                                </td>
                                <td>
                                    <?php if($area->status == 0): ?>
                                        <a class="btn btn-sm btn-alt-success" href="<?php echo e(route('department.approveTeachingArea', ['id' => Crypt::encrypt($area->id)])); ?>">Approve</a>
                                        <a class="btn btn-sm btn-alt-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop-<?php echo e($area->id); ?>" >Decline</a>
                                    <?php elseif($area->status == 1): ?>
                                        <a class="btn btn-sm btn-alt-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop-<?php echo e($area->id); ?>" >Decline</a>
                                    <?php else: ?>
                                        <a class="btn btn-sm btn-alt-success" href="<?php echo e(route('department.approveTeachingArea', ['id' => Crypt::encrypt($area->id)])); ?>">Approve</a>
                                    <?php endif; ?>

                                </td>

                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop-<?php echo e($area->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Reasons for rejecting the qualification</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex justify-content-center">
                                                    <div class="col-md-12">
                                                        <form method="post" action="<?php echo e(route('department.declineTeachingArea', ['id' => Crypt::encrypt($area->id)])); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <div class="mb-4 form-floating">
                                                                <textarea name="reason" class="form-control" placeholder="hello" rows="5" style="min-height: 150px !important;"></textarea>
                                                                <label>Why are you rejecting this qualification</label>
                                                            </div>
                                                            <div class="d-flex justify-content-center">
                                                                <button class="btn btn-outline-danger col-md-7">Decline</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
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

<?php echo $__env->make('cod::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\project\application\Modules/COD\Resources/views/lecturers/teachingAreas.blade.php ENDPATH**/ ?>