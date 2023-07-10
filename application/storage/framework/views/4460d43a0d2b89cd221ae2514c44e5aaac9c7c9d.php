
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
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-1">
            <div class="flex-grow-1">
                <h5 class="h5 fw-bold mb-0">
                    EXAM RESULTS
                </h5>
            </div>
            <nav class="flex-shrink-0 mt-0 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="<?php echo e(route('student.examresults')); ?>">Academic Semester</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        EXAM MARKS
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="block block-rounded">
    <div class="block-content block-content-full">
        <div class="table-responsive">
            <table id="example"  class="table table-sm table-striped table-bordered fs-sm">
                <thead>
                <th>#</th>
                <th> Unit code </th>
                <th> Unit Name </th>
                <th> Grade </th>
                <th> Remark </th>
                </thead>
                <?php
                $i = 0;
               ?>
            <?php $__currentLoopData = $exam_marks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td> <?php echo e(++$i); ?> </td>
                <td><?php echo e($mark->unit_code); ?></td>
                <td><?php echo e($mark->unit->unit_name); ?></td>

                <td>
                    <?php if(($mark->total_mark>=0)&&($mark->total_mark<40)): ?>
                    E
                    <?php elseif(($mark->total_mark>=40)&&($mark->total_mark<50)): ?>
                    D
                    <?php elseif(($mark->total_mark>=50)&&($mark->total_mark<60)): ?>
                    C
                    <?php elseif(($mark->total_mark>=60)&&($mark->total_mark<70)): ?>
                    B
                    <?php elseif(($mark->total_mark>=70)&&($mark->total_mark<=100)): ?>
                    A
                    <?php elseif($mark->total_mark == "ABSENT"): ?>
                    ABS
                    <?php else: ?>
                    INVALID

                    <?php endif; ?>
                    </td>
                <td>
                    <?php if($mark->total_mark < 40): ?>
                    FAIL
                    <?php elseif($mark->total_mark>=40): ?>
                    PASS
                    <?php elseif($mark->total_mark == "ABSENT"): ?>
                    ABS
                    <?php else: ?>
                    WITHHELD
                    
                    <?php endif; ?>
                    </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            </table>
        </div></div>
    </div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('student::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\project\application\Modules/Student\Resources/views/examination/viewexammarks.blade.php ENDPATH**/ ?>