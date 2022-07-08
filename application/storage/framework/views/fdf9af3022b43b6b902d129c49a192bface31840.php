<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<link rel="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

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

<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        APPLICATIONS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Applications</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            All Applications
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
                    <form action="<?php echo e(route('courses.acceptedMail')); ?>" method="post">
                        <?php echo csrf_field(); ?>

            <table id="example" class="table table-borderless table-striped js-dataTable-responsive fs-sm">
                <?php if(count($accepted)>0): ?>
                    <thead>
                    <tr>
                        <th>✔</th>
                        <th>Applicant Name</th>
                        
                        <th>department</th>
                        <th>course</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $accepted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php if($item->dean_status === 1 || 2): ?>
                                    <input class="accepted" type="checkbox" name="submit[]" value="<?php echo e($item->id); ?>">
                                        <?php else: ?>
                                        ✔
                                    <?php endif; ?>
                                    </td>
                                <td> <?php echo e($item->applicant->sname); ?> <?php echo e($item->applicant->fname); ?> <?php echo e($item->applicant->mname); ?></td>
                                
                                <td> <?php echo e($item->courses->department_id); ?></td>
                                <td> <?php echo e($item->courses->course_name); ?></td>
                                <td> <?php if($item->dean_status ===1): ?>
                                    <a  class="badge badge bg-success" >Approved</a>
                                    <?php else: ?>
                                    <a  class="badge badge bg-danger" >Rejected</a>
                                    <?php endif; ?>
                                </td>

                            </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                <?php else: ?>
                <tr>
                    <small class="text-center text-muted">There are no accepted appications</small>
                </tr>
                <?php endif; ?>
        </table>
        <?php if(count($accepted)>0): ?>
            <div>
                <input type="checkbox" onclick="for(c in document.getElementsByClassName('accepted')) document.getElementsByClassName('accepted').item(c).checked = this.checked"> Select all
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-sm btn-alt-primary" href="route('courses.archived')" data-toggle="click-ripple">Submit batch</button>
            </div>
            <?php endif; ?>
    </form>


        </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sims\application\Modules/Courses\Resources/views/offer/applications.blade.php ENDPATH**/ ?>