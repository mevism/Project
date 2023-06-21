
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<style>
    .cellText {
        font-weight: bold;
        font-family: Calibri;
        background-color: #f2f4fb;
    }
    .make-me-red{
        color: red !important;
    }
</style>
<?php $__env->startSection('content'); ?>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        STUDENT MARKS
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Exams</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Enter Marks
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="alert alert-info p-0">
                    <p class="text-center fs-9 mt-2 mb-1"> <sup class="text-danger">*</sup> Cells in red means that the value entered is either less than 0 or greater than the examined CAT/Assignment/Practical/Exam weights and can also mean you keyed in a letter instead of a digit. Please confirm your entries before submissions.</p>
                </div>

                <div class="col-lg-12">
                    <div id="example" style="width: 100% !important; overflow: hidden !important;"></div>
                    <div class="d-flex justify-content-center mt-4">
                        <button id="save" class="btn btn-col-md-7 btn-outline-secondary">Submit Student Marks</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<script type="module">

    $(document).ready(function() {

        const data = JSON.parse('<?php echo json_encode($students) ?>');
        let weight = [];
        const weights = JSON.parse('<?php echo json_encode($weights) ?>');
        const unit = JSON.parse('<?php echo json_encode($unit) ?>');

        if (weights === null) {

            weight = {cat: unit.cat, assignment: unit.assignment, practical: unit.practical, exam: unit.total_exam};

        } else {

            weight = {
                cat: weights.cat,
                assignment: weights.assignment,
                practical: weights.practical,
                exam: weights.exam
            };

        }

        let table = [];

        for (let i = 0; i < data.length; i++) {

            const tableData = [data[i].reg_number, data[i].sname + ' ' + data[i].fname + ' ' + data[i].mname, '0', '0', '0', '0', null, null, null, null, '1st ATTEMPT']

            table.push(tableData)
        }
            console.log(table)

            const container = document.querySelector('#example');
            const save = document.querySelector('#save');

            function negativeValueRenderer(instance, td, row, col, prop, value, cellProperties, ) {

                Handsontable.renderers.TextRenderer.apply(this, arguments);
                // Handsontable.TextCell.renderer.apply(this, arguments);

                if (!value || value === '' || value == null, value === '0') {
                    td.innerHTML = null;
                }

                if(col === 6 || col === 7 || col === 8 ){
                    td.innerHTML = Math.round(td.innerHTML)
                }

                if (!value || value === '' || value === null) {
                    td.style.background = '#EEE';

                } else {

                    td.style.background = '';
                }

            }

            let assignment =  unit.assignment;
            let assignmentColumn = false;
            if(assignment == null){
                assignmentColumn = 3;
            }

            let practical =  unit.practical;
            let practicalColumn = false;
            if(practical == null){
                practicalColumn = 4;
            }

            Handsontable.renderers.registerRenderer(negativeValueRenderer );

             const hot = new Handsontable(container, {
                data:table,

                width: '100%',
                height: 'auto',
                stretchH: 'all',
                colWidths: [120, 250, 60, 60, 60, 60, 60, 60, 80, 60, 150],
                className: 'htCenter',
                columns: [
                    {readOnly: true, className: 'htLeft htMiddle cellText'},
                    {readOnly: true, className: 'htLeft htMiddle cellText'},
                    {type: 'numeric',
                     validator: function(value, callback) {
                            if (value <= weight.cat && value >= 0) {
                                callback(true);
                            } else {
                                // callback(false);
                                document.querySelector('#save').disabled = true;

                            }
                        }
                    },
                    {type: 'numeric',
                     validator: function(value, callback) {
                            if (value <= weight.assignment && value >= 0) {
                                callback(true);
                            } else {
                                callback(false);
                            }
                        }
                    },
                    {type: 'numeric',
                     validator: function(value, callback) {
                            if (value <= weight.practical && value >= 0) {
                                callback(true);
                            } else {
                                callback(false);
                            }
                        }
                    },
                    {type: 'numeric',
                     validator: function(value, callback) {
                            if (value <= weight.exam && value >= 0) {
                                callback(true);
                            } else {
                                callback(false);
                            }
                        }
                    },
                    {readOnly: true, },
                    {readOnly: true, },
                    {readOnly: true, },
                    {readOnly: true},
                    {readOnly: true, className: 'htCenter htMiddle cellText'}
                ],

                 hiddenColumns: {

                    columns: [ assignmentColumn, practicalColumn ]
                 },

                rowHeights: 30,
                rowHeaders: true,
                colHeaders: ['STUDENT NUMBER', 'STUDENT NAME', 'CAT 1', 'CAT 2', 'CAT 3', 'EXAM', 'T. CAT', 'T. EXAM', 'T. MARKS', 'GRADE', 'ATTEMPT'],
                licenseKey: 'non-commercial-and-evaluation', // for non-commercial use only

                cells(row, col,  prop, value) {
                    const cellProperties = {};
                    const data = this.instance.getData();
                    cellProperties.renderer = negativeValueRenderer;
                    return cellProperties;

                },

                afterChange: function (changes, source) {

                    // If the source of the changes is named 'sum', we do not want to update the table. (we just did).
                    if(changes !== null){

                        if (source !== 'sum') {
                            var a, b, c, d, sum, i, value, grade, total;

                            var cats = (unit.cat / weight.cat);
                            var assignments = (unit.assignment / weight.assignment);
                            var practicals = (unit.practical / weight.practical);
                            var exam = (unit.total_exam / weight.exam);


                            if (assignments === null || assignments === "" || !assignments) {
                                assignments = 0;
                                b = 0;
                            }

                            if (practicals === null || practicals === "" || !practicals) {
                                practicals = 0;
                                c = 0;
                            }


                            for (var i = 0; i < changes.length; i++) {
                                // console.log(changes.length)
                                var change = changes[i];
                                var line = change[0];

                                a = parseInt(this.getDataAtCell(line, 2));
                                b = parseInt(this.getDataAtCell(line, 3));
                                c = parseInt(this.getDataAtCell(line, 4));
                                d = parseInt(this.getDataAtCell(line, 5));

                                value = a * cats + b * assignments + c * practicals;
                                total = d * exam + value;

                                if(total > 70 ){
                                    grade = 'A';
                                }else if(total >= 60){
                                    grade = 'B';
                                }else if(total >= 50){
                                    grade = 'C';
                                }else if(total >= 40){
                                    grade = 'D';
                                }else if(total >= 1) {
                                    grade = 'E';
                                }else{
                                    grade = '';
                                }

                                // We want to programmatically update the table.
                                // Let's update it, and associate the source 'sum' to the event.
                                this.setDataAtCell(change[0], 6, value, 'sum');
                                this.setDataAtCell(change[0], 7, d * exam, 'sum');
                                this.setDataAtCell(change[0], 8, total, 'sum');
                                this.setDataAtCell(change[0], 9, grade, 'sum');

                            }

                        }
                    }
                }
             });

             save.addEventListener('click', () => {

                 var marks = hot.getData();
                 var classUnit = JSON.parse('<?php echo json_encode($unit) ?>');
                 var workload = JSON.parse('<?php echo json_encode($semester) ?>');

                 $.ajax({

                     type: 'get',
                     url: '<?php echo e(route('lecturer.storeMarks')); ?>',
                     data: { data:marks, unit:classUnit, workload:workload},
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     success: function (data){

                         location.reload();
                         toastr.success("Student marks saved successfully");

                     }

                 });


                 
                 
                 
                 
                 
                 
                 
                 
             });
    });

</script>

<?php echo $__env->make('lecturer::layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\project\application\Modules/Lecturer\Resources/views/examination/exam.blade.php ENDPATH**/ ?>