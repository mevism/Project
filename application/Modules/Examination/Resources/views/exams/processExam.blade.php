@extends('examination::layouts.backend')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>

<style>
    .cellText {
        font-weight: bold;
        font-family: Calibri, serif;
        background-color: #f2f4fb;
    }
    .make-me-red{
        color: red !important;
    }
    .toast-container {
        bottom: 5vh;
    }
    .handsontable .htDimmed .htHighlight {
        background-color: transparent !important;
        box-shadow: none !important;
        outline: none !important;
    }
</style>
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0">
                        STUDENT MARKS
                    </h6>
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
                {{--                <small class="text-danger text-center"> Where cells are in red </small> check if you used <span class="fw-semibold">O</span> instead of <span class="fw-semibold">0</span> or the value is less than 0 or more than the set value for CAT/ASSIGNMENT/PRACTICAL/EXAM--}}
                <div class="col-lg-12">
                    <div id="example" style="width: 100% !important; overflow: hidden !important;"></div>
                    <div class="d-flex justify-content-center mt-4">
                        <button id="save" class="btn btn-col-md-7 btn-outline-secondary">Submit Student Marks</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>--}}

    <div class="toast-container position-fixed bottom-90 end-0 p-3">
        <div id="liveToast" class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fa fa-exclamation-triangle text-danger"></i>  <span>&nbsp;</span>
                {{--                <img src="..." class="rounded me-2" alt="...">--}}
                <strong class="me-auto">Error</strong>
                <small>{{ Carbon\Carbon::now()->diffForHumans() }}</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div>
    </div>
    <script>
        function showError(){
            const toastTrigger = document.getElementById('liveToastBtn')
            const toastLiveExample = document.getElementById('liveToast')

            if (toastTrigger) {
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                toastTrigger.addEventListener('click', () => {
                    toastBootstrap.show()
                })
            }
        }
    </script>


@endsection
<script type="module">

    $(document).ready(function() {

        const data = JSON.parse('<?php echo json_encode($students) ?>');
        let weight = [];
        const weights = JSON.parse('<?php echo json_encode($weights) ?>');
        const unit = JSON.parse('<?php echo json_encode($unit) ?>');

        weight = {cat: weights.total_cat, exam: weights.total_exam};

        let table = [];

        for (let i = 0; i < data.length; i++) {
            var grade = null;
            var examType = null;
            var total_mark = parseInt(data[i].total_cat) + parseInt(data[i].total_exam)

            if(isNaN(total_mark)){
                total_mark = 'ABSENT';
            }

            if(total_mark > 70 ){
                grade = 'A';
            }else if(total_mark >= 60){
                grade = 'B';
            }else if(total_mark >= 50){
                grade = 'C';
            }else if(total_mark >= 40){
                grade = 'D';
            }else if(total_mark >= 1) {
                grade = 'E';
            }else if (isNaN(total_mark)){
                grade = 'ABSENT';
            }else {
                grade = 'ABSENT';
            }

            var columnFormat = data[i].attempt;
            var firstNumber = parseInt(columnFormat.split(".")[0]);
            var secondNumber = parseInt(columnFormat.split(".")[1]);
            var thirdNumber = parseInt(columnFormat.split(".")[2]);

            if (firstNumber >= 1 && firstNumber <= 7 && (secondNumber === 1 || secondNumber === 2) && isNaN(thirdNumber)) {
                examType = 'ORDINARY EXAM';
            } else if (thirdNumber !== null && thirdNumber === 1) {
                examType = 'SPECIAL EXAM';
            } else if (thirdNumber !== null && thirdNumber === 2) {
                examType = 'SUPPLEMENTARY EXAM';
            } else if (thirdNumber !== null && thirdNumber === 3) {
                examType = 'RETAKE EXAM';
            }

            const tableData = [data[i].student_number, data[i].sname + ' ' + data[i].fname + ' ' + data[i].mname, data[i].total_cat, data[i].total_exam, total_mark, grade, examType]

            table.push(tableData)
        }
        console.log(table)

        const container = document.querySelector('#example');
        const save = document.querySelector('#save');

        function negativeValueRenderer(instance, td, row, col, prop, value, cellProperties, ) {

            Handsontable.renderers.TextRenderer.apply(this, arguments);
            // Handsontable.TextCell.renderer.apply(this, arguments);

            if (col === 2 || col === 3 || col === 4 || col === 5){
                if (value === '0' ){
                    td.innerHTML = 0;
                }
                if (value === "" || value === null){
                    td.innerHTML = "-";
                }
                if (value === 'ABSENT'){
                    td.innerHTML = 'ABSENT';
                }
            }

            if(col === 4 || col === 5 || col === 6){
                td.style.background = '#EEE';
            }
        }

        Handsontable.renderers.registerRenderer(negativeValueRenderer );

        const hot = new Handsontable(container, {
            data:table,

            width: '100%',
            height: 'auto',
            stretchH: 'all',
            colWidths: [120, 300, 80, 90, 80, 60, 140],
            className: 'htCenter',
            columns: [
                {readOnly: true, className: 'htLeft htMiddle cellText htReadOnly'},
                {readOnly: true, className: 'htLeft htMiddle cellText htReadOnly'},
                {type: 'numeric',
                    validator: function(value, callback) {
                        if (value <= weight.cat && value >= 0) {
                            callback(true);
                        } else {
                            callback(false);
                            showNotification('Oops! Entered marks out of your set range ', 'error');
                        }
                    },
                },
                {type: 'numeric',
                    validator: function(value, callback) {
                        if (value <= weight.exam && value >= 0) {
                            callback(true);
                        } else {
                            callback(false);
                            showNotification('Oops! Entered marks out of your set range ', 'error');
                        }
                    }
                },
                {readOnly: true, },
                {readOnly: true},
                {readOnly: true, className: 'htCenter htMiddle cellText'}
            ],
            rowHeights: 30,
            rowHeaders: true,
            colHeaders: ['STUDENT NUMBER', 'STUDENT NAME', 'TOTAL CAT', 'TOTAL EXAM', 'TOTAL MARKS', 'GRADE', 'ATTEMPT'],
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
                        var a, b, sum, i, value, grade, total;
                        for (var i = 0; i < changes.length; i++) {
                            // console.log(changes.length)
                            var change = changes[i];
                            var line = change[0];

                            a = parseInt(this.getDataAtCell(line, 2));
                            b = parseInt(this.getDataAtCell(line, 3));

                            if( !a ){ a = 0; } if( !b ){ b = 0; }

                            value = a;
                            total = b + value;

                            if (total >= 70) {
                                grade = 'A';
                            } else if (total >= 60) {
                                grade = 'B';
                            } else if (total >= 50) {
                                grade = 'C';
                            } else if (total >= 40) {
                                grade = 'D';
                            } else if (total >= 1) {
                                grade = 'E';
                            } else {
                                grade = 'ABSENT';
                            }

                            // We want to programmatically update the table.
                            // Let's update it, and associate the source 'sum' to the event.
                            this.setDataAtCell(change[0], 4, total, 'sum');
                            this.setDataAtCell(change[0], 5, grade, 'sum');
                        }

                    }
                }
            },
            beforeRenderer: function (td, row, col, prop, value, cellProperties) {
                if (cellProperties.readOnly) {
                    td.classList.add('no-highlight'); // Add a custom CSS class
                }
            },
        });

        save.addEventListener('click', () => {

            var marks = hot.getData();
            var classUnit = JSON.parse('<?php echo json_encode($unit) ?>');
            var workload = JSON.parse('<?php echo json_encode($semester) ?>');

            $.ajax({
                type: 'get',
                url: '{{ route('examination.updateMarks') }}',
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

    function showNotification(message, errorMessage = '') {
        const toastTrigger = document.getElementById('liveToastBtn');
        const toastLiveExample = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastLiveExample);

        toastBootstrap.hide(); // Hide any existing toast before showing a new one

        toastLiveExample.querySelector('.toast-body').textContent = message;
        toastLiveExample.classList.remove('bg-success');
        toastLiveExample.classList.add('bg-danger');

        if (errorMessage) {
            const errorElement = document.createElement('div');
            errorElement.classList.add('text-danger');
            errorElement.textContent = errorMessage;
            toastLiveExample.querySelector('.toast-body').appendChild(errorElement);
        }

        toastBootstrap.show();
    }
</script>
