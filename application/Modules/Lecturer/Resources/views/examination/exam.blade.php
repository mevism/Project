@extends('lecturer::layouts.backend')
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
@section('content')
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
                <div class="col-lg-12">
                    <div id="example" style="width: 100% !important; overflow: hidden !important;"></div>
                    <div class="controls">
                        <button id="load" class="button button--primary button--blue">Load data</button>&nbsp;
                        <button id="save" class="button button--primary button--blue">Save data</button>
                        <label>
                            <input type="checkbox" name="autosave" id="autosave"/>
                            Autosave
                        </label>
                    </div>

                    <output class="console" id="output">Click "Load" to load data from server</output>
                </div>
            </div>
        </div>
    </div>

@endsection

<script type="module">

    $(document).ready(function() {

        var classCode = '{{ $class }}';
        var unit = '{{ $unit }}';

        $.ajax({

            type: 'get',
            url: '{{ route('lecturer.getStudentExams') }}',
            data: { classCode:classCode, unit:unit },
            dataType: 'json',
            success: function (data){

                const container = document.querySelector('#example');

                function negativeValueRenderer(instance, td, row, col, prop, value, cellProperties, ) {

                    Handsontable.renderers.TextRenderer.apply(this, arguments);

                    if (!value || value === '' || value == null, value === '0') {
                        td.innerHTML = null;
                    }

                    if(col === 6 || col === 7 || col === 8 ){
                        td.innerHTML = Math.round(td.innerHTML)
                    }

                    // if the row contains a negative number
                    if (parseInt(value, 10) < 0) {
                        // add class 'make-me-red'
                        td.className = 'htCenter make-me-red';
                    }

                    if (!value || value === '' || value === null) {
                        td.style.background = '#EEE';

                    } else {

                        td.style.background = '';
                    }

                }


                let table = [ ];

                for(let i = 0; i < data.length; i++){

                    const tableData = [data[i].reg_number, data[i].student_name, '0', '0', '0', '0', ]

                    table.push(tableData)

                    }

                let assignment =  data[0].assignment;
                let assignmentColumn = false;
                if(assignment == null){
                    assignmentColumn = true;
                }

                let practical =  data[0].practical;
                let practicalColumn = false;
                if(practical == null){
                    practicalColumn = true;
                }

                Handsontable.renderers.registerRenderer(negativeValueRenderer );
                const hot = new Handsontable(container, {
                    data:table,

                    fillHandle: false,
                    minSpareCols: 0,
                    minSpareRows: 0,
                    width: '100%',
                    height: 'auto',
                    stretchH: 'all',
                    colWidths: [120, 250, 60, 60, 60, 60, 60, 60, 60, 60, 150],
                    className: 'htCenter',
                    columns: [
                        {readOnly: true, className: 'htLeft htMiddle cellText'},
                        {readOnly: true, className: 'htLeft htMiddle cellText'},
                        {type: 'numeric'},
                        {type: 'numeric', readOnly:  assignmentColumn},
                        {type: 'numeric', readOnly: practicalColumn},
                        {type: 'numeric'},
                        {readOnly: true, },
                        {readOnly: true, },
                        {readOnly: true, },
                        {readOnly: true},
                        {readOnly: true, className: 'htCenter htMiddle cellText'}
                    ],

                    rowHeights: 30,
                    rowHeaders: true,
                    colHeaders: ['STUDENT NUMBER', 'STUDENT NAME', 'CAT 1', 'CAT 2', 'CAT 3', 'EXAM', 'CAT', 'EXAM', 'TOTAL', 'GRADE', 'ATTEMPT'],
                    licenseKey: 'non-commercial-and-evaluation', // for non-commercial use only

                    cells(row, col,  prop, value) {
                        const cellProperties = {};
                        const data = this.instance.getData();
                        cellProperties.renderer = negativeValueRenderer;
                        return cellProperties;

                        if (col === 3 && col === 'readOnly') {
                            cellProperties.allowRemoveColumn = true;
                        }

                    },

                    afterChange: function (changes, source) {

                        // If the source of the changes is named 'sum', we do not want to update the table. (we just did).
                        if (source !== 'sum') {
                            var a, b, c, d, sum, i, value;

                            var cats = (data[0].cat/data[0].user_cat);
                            var assignments = (data[0].assignment/data[0].user_assignment);
                            var practicals = (data[0].practical/data[0].user_practical);

                            if(assignments === null || assignments === "" || !assignments){
                                assignments = 0;
                                b = 0;
                            }

                            if(practicals === null || practicals === "" || !practicals){
                                practicals = 0;
                                c = 0;
                            }

                            for (var i = 0; i < changes.length; i++) {
                                var change = changes[i];
                                var line = change[0];

                                a = parseInt(this.getDataAtCell(line, 2));
                                b = parseInt(this.getDataAtCell(line, 3));
                                c = parseInt(this.getDataAtCell(line, 4));
                                d = parseInt(this.getDataAtCell(line, 5));

                                value = a*cats + b*assignments + c*practicals;

                                // We want to programmatically update the table.
                                // Let's update it, and associate the source 'sum' to the event.
                                this.setDataAtCell(change[0], 6, value, 'sum');
                                this.setDataAtCell(change[0], 7, (d/data[0].user_exam)*data[0].exam, 'sum');
                                this.setDataAtCell(change[0], 8, (d/data[0].user_exam)*data[0].exam + value, 'sum');

                            }

                        }

                        fetch('https://handsontable.com/docs/scripts/json/save.json', {
                            method: 'POST',
                            mode: 'no-cors',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ data: change })
                        })
                            .then(response => {
                                // exampleConsole.innerText = `Autosaved (${change.length} cell${change.length > 1 ? 's' : ''})`;
                                console.log(data);
                            });
                    }
                });
            }

        });

        save.addEventListener('click', () => {
            // save all cell's data
            fetch('https://handsontable.com/docs/scripts/json/save.json', {
                method: 'POST',
                mode: 'no-cors',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ data: hot.getData() })
            })
                .then(response => {
                    // exampleConsole.innerText = 'Data saved';
                    console.log(data);
                });
        });

    });

</script>
