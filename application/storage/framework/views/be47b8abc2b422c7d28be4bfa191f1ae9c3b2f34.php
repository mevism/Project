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
            order: [[1, 'asc']],
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
                        CLASSES
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)"><?php echo e($class->name); ?></a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Class Pattern
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



























                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Create Pattern
                        </button>
                    </div>

                        <div class="table table-responsive">
                            <table class="table table-responsive-sm table-borderless table-striped fs-sm" id="example">
                                <thead>
                                    <th>#</th>
                                    <th>Class Code</th>
                                    <th>Academic Year</th>
                                    <th>Semester Period</th>
                                    <th>Stage</th>
                                    <th>Semester</th>
                                    <th>Start date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $patterns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pattern): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(++$key); ?></td>
                                            <td><?php echo e($pattern->class_code); ?></td>
                                            <td><?php echo e($pattern->academic_year); ?></td>
                                            <td><?php echo e($pattern->period); ?></td>
                                            <td><?php echo e($pattern->stage); ?></td>
                                            <td><?php echo e($pattern->pattern->season); ?></td>
                                            <td><?php echo e($pattern->start_date); ?></td>
                                            <td><?php echo e($pattern->end_date); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#staticBackdrop-<?php echo e($pattern->id); ?>">
                                                    Edit
                                                </button>
                                                <a class="btn btn-sm btn-outline-danger" href="<?php echo e(route('cod.deleteClassPattern', ['id' => Crypt::encrypt($pattern->id)])); ?>">delete</a>

                                                <div class="modal fade" id="staticBackdrop-<?php echo e($pattern->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel"> Edit <?php echo e($pattern->period); ?> Semester</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php
                                                                    $semester = explode(' ', $class->classCourse->courseRequirements->course_duration)[0]*3-1;

                                                                    $stage = explode(' ', $class->classCourse->courseRequirements->course_duration)[0];
                                                                ?>

                                                                <form method="POST" action="<?php echo e(route('cod.updateClassPattern', ['id' => Crypt::encrypt($pattern->id)])); ?>">
                                                                    <?php echo csrf_field(); ?>

                                                                    <div class="row row-cols-sm-4 g-2">

                                                                        
                                                                        <div class="form-floating mb-2">
                                                                            <select class="form-select" name="year">
                                                                                <option value="<?php echo e($pattern->academic_year); ?>"> <?php echo e($pattern->academic_year); ?> </option>
                                                                                <?php for($z = 2020; $z <= 2100; $z++): ?>
                                                                                    <option value="<?php echo e($z.'/'.$z+1); ?>"><?php echo e($z.'/'.$z+1); ?></option>
                                                                                <?php endfor; ?>
                                                                            </select>
                                                                            <label>ACADEMIC YEAR</label>
                                                                        </div>
                                                                        <div class="form-floating mb-2">
                                                                            <select class="form-select" name="period">
                                                                                <option <?php if($pattern->period == 'SEP/DEC'): ?> selected <?php endif; ?> value="SEP/DEC">SEP/DEC</option>
                                                                                <option <?php if($pattern->period == 'JAN/APR'): ?> selected <?php endif; ?> value="JAN/APR">JAN/APR</option>
                                                                                <option <?php if($pattern->period == 'MAY/AUG'): ?> selected <?php endif; ?> value="MAY/AUG">MAY/AUG</option>
                                                                            </select>
                                                                            <label>ACADEMIC SEMESTER</label>
                                                                        </div>
                                                                        <div class="form-floating mb-2">
                                                                            <select class="form-select" name="stage">
                                                                                <option value="<?php echo e($pattern->stage); ?>">YEAR <?php echo e($pattern->stage); ?> </option>
                                                                                <?php for($x = 1; $x <= $stage; $x++): ?>
                                                                                    <option value="<?php echo e($x); ?>">YEAR <?php echo e($x); ?></option>
                                                                                <?php endfor; ?>
                                                                            </select>
                                                                            <label>YEAR OF STUDY</label>
                                                                        </div>
                                                                        <div class="form-floating mb-2">
                                                                            <select CLASS="form-select" name="semester">
                                                                                <option value="<?php echo e($pattern->pattern_id); ?>"> <?php echo e($pattern->pattern->season); ?> </option>
                                                                                <?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <option value="<?php echo e($season->id); ?>"><?php echo e($season->season); ?></option>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </select>
                                                                            <label>SEMESTER OF STUDY</label>
                                                                        </div>

                                                                        <input type="hidden" value="<?php echo e($class->name); ?>" name="code">
                                                                        
                                                                    </div>

                                                                    <div class="row row-cols-sm-2 g-2">

                                                                        <div class="form-floating mb-2">
                                                                            <input type="date" class="form-control" name="start_date">
                                                                            <label>SEMESTER START DATE</label>
                                                                        </div>

                                                                        <div class="form-floating mb-2">
                                                                            <input type="date" class="form-control" name="end_date">
                                                                            <label>SEMESTER END DATE</label>
                                                                        </div>

                                                                    </div>

                                                                    <div class="d-flex justify-content-center mt-4 mb-4">
                                                                        <button class="btn btn-outline-success">UPDATE CLASS PATTERN</button>
                                                                    </div>

                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

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



    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><?php echo e($class->name); ?> Class Pattern</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                        $semester = explode(' ', $class->classCourse->courseRequirements->course_duration)[0]*3-1;

                        $stage = explode(' ', $class->classCourse->courseRequirements->course_duration)[0];
                    ?>

                    <form method="POST" action="<?php echo e(route('cod.storeClassPattern')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="row row-cols-sm-4 g-2">


                                <div class="form-floating mb-2">
                                    <select class="form-select" name="year">
                                        <option selected disabled class="text-center">-- academic year --</option>
                                        <?php for($z = 2020; $z <= 2100; $z++): ?>
                                            <option value="<?php echo e($z.'/'.$z+1); ?>"><?php echo e($z.'/'.$z+1); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <label>ACADEMIC YEAR</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <select class="form-select" name="period">
                                        <option selected disabled class="text-center"> -- select semester --</option>
                                        <option value="SEP/DEC">SEP/DEC</option>
                                        <option value="JAN/APR">JAN/APR</option>
                                        <option value="MAY/AUG">MAY/AUG</option>
                                    </select>
                                    <label>ACADEMIC SEMESTER</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <select class="form-select" name="stage">
                                        <option selected disabled class="text-center">-- year of study --</option>
                                        <?php for($x = 1; $x <= $stage; $x++): ?>
                                            <option value="<?php echo e($x); ?>">YEAR <?php echo e($x); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <label>YEAR OF STUDY</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <select CLASS="form-select" name="semester">
                                        <option selected disabled class="text-center">-- semester of study --</option>
                                        <?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($season->id); ?>"><?php echo e($season->season); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <label>SEMESTER OF STUDY</label>
                                </div>

                                <input type="hidden" value="<?php echo e($class->name); ?>" name="code">

                        </div>

                        <div class="d-flex justify-content-center mt-4 mb-4">
                            <button class="btn btn-outline-success">CREATE CLASS PATTERN</button>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cod::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Registrar/application/Modules/COD/Resources/views/classes/classPattern.blade.php ENDPATH**/ ?>