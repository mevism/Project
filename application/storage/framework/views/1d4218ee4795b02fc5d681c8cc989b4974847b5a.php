
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0" >
                        SYSTEM USERS
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Users</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Manage Users
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-end m-2">

                        <a type="button" class="btn btn-sm btn-alt-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Add User</a>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-sm table-md table-striped table-bordered fs-sm">
                            <thead>
                            <th>#</th>
                            <th>Staff No.</th>
                            <th>Staff Name</th>
                            <th>Gender</th>
                            <th>Official Email</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th>Manage Users</th>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td> <?php echo e(++$key); ?> </td>
                                    <td> <?php echo e($user->staff_number); ?> </td>
                                    <td> <?php echo e($user->title); ?> <?php echo e($user->last_name); ?> <?php echo e($user->first_name); ?> <?php echo e($user->middle_name); ?> </td>
                                    <td> <?php echo e($user->gender); ?> </td>
                                    <td> <?php echo e($user->office_email); ?> </td>
                                    <td class="text-uppercase"> <?php echo e($user->name); ?> </td>
                                    <td> <?php echo e($user->staffRole->name); ?> </td>
                                    <td nowrap="">
                                        <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('admin.addUserRole', $user->user_id)); ?>">roles</a>
                                        <a class="btn btn-sm btn-outline-primary">permissions</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<div class="modal " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">FETCH USER FROM TUMHRMS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="get" action="<?php echo e(route('admin.userById')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <div class="col-md-10 mb-3">
                          <div class="form-floating mb-4">
                              <input type="text" name="userId" class="form-control" placeholder="id number">
                              <label>STAFF ID NUMBER</label>
                          </div>
                            <div class="form-floating mb-4">
                                <input type="text" name="staffNumber" class="form-control" placeholder="staff number">
                                <label>STAFF STAFF NUMBER</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-md btn-alt-primary col-md-7">Validate staff</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#search').select2({
        dropdownParent: $(".modal")
    });

</script>

<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\project1\application\Modules/User\Resources/views/index.blade.php ENDPATH**/ ?>