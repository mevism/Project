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
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-grow-1">
                    <h5 class="h5 fw-bold mb-0">
                        INTAKES
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Intakes</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            View intakes
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
              <table id="example" class="table table-borderless table-striped table-vcenter js-dataTable-responsive">
                <span class="d-flex justify-content-end">
                    <a class="btn btn-alt-info btn-sm" href="<?php echo e(route('courses.addIntake')); ?>">Create</a>
                </span><br>
                <thead>

                  <tr>
                    <th>Intakes</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>

                </thead>
                <tbody>
                  <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $intake): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td style="text-transform: uppercase" class="fw-semibold fs-sm"><?php echo e(Carbon\carbon::parse($intake->intake_from)->format('M-Y')); ?> - <?php echo e(Carbon\carbon::parse($intake->intake_to)->format('M-Y')); ?></td>
                    
                    <td>
                    <?php if($intake->status === 0): ?>
                    <a  class="btn btn-sm btn-alt-primary" href="<?php echo e(route('courses.editstatusIntake', $intake->id)); ?>">Pending</a>
                    <?php endif; ?>
                    <?php if($intake->status === 1): ?>
                    <a  class="btn btn-sm btn-alt-success" href="<?php echo e(route('courses.editstatusIntake', $intake->id)); ?>">Ongoing</a>
                    <?php endif; ?>
                    <?php if($intake->status === 2): ?>
                    <a  class="btn btn-sm btn-alt-info" href="<?php echo e(route('courses.editstatusIntake', $intake->id)); ?>">Expired</a>
                    <?php endif; ?>
                    <?php if($intake->status === 3): ?>
                    <a  class="btn btn-sm btn-alt-danger" href="<?php echo e(route('courses.editstatusIntake', $intake->id)); ?>">Suspended</a>
                    <?php endif; ?>
                     </td>
                    <td> 
                      <a class="btn btn-sm btn-alt-secondary" href="<?php echo e(route('courses.viewIntake', $intake->id)); ?>">view</a> 
                   
                      <a class="btn btn-sm btn-alt-danger" onclick="return confirm('Are you sure you want to delete this intake ?')" href="<?php echo e(route('courses.destroyIntake', $intake->id)); ?>">delete</a> 
                    </td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </tbody>
              </table>
                </div>
            </div>
          </div>
          <!-- Dynamic Table Responsive -->
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('registrar::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Registrar/application/Modules/Registrar/Resources/views/intake/showIntake.blade.php ENDPATH**/ ?>