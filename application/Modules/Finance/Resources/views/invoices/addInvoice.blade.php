@extends('applications::layouts.backend')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>--}}

{{--<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">--}}
<style>
    /* Custom CSS to make form-floating elements smaller */
    .form-floating .form-control {
        height: 2.5rem !important;
        padding: 0.8rem 0.8rem 0 0.8rem !important;
        font-size: 0.875rem !important;
    }

    .form-floating label {
        font-size: 0.75rem !important;
    }
</style>

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0">
                        STUDENT FINANCE
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">STUDENT FINANCE</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            STUDENT INVOICES
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="d-flex justify-content-center">
                <div class="col-12">
                    <form method="POST" action="{{ route('finance.submitInvoice') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <select class="form-control form-select-lg" id="select2" name="code[]">
                                    <option class="text-center"> -- search for class/student -- </option>
                                    @foreach($students as $student)
                                        @php $code = '';
                                                if ($student->name != null){
                                                    $code = $student->name;
                                                }else{
                                                    $code = $student->student_number;
                                                }
                                        @endphp
                                        <option value="{{ $code }}">{{ $code }}</option>
                                    @endforeach
                                </select>
                                <div id="studentsClass"></div>

                            </div>
                            <div class="col-md-4 form-floating mb-3">
                                <input class="form-control"  name="type" readonly id="type" placeholder="type">
                                <label class="mx-3">INVOICE TYPE</label>
                            </div>
                            <div class="col-md-2 form-floating mb-3">
                                <input class="form-control" readonly name="name" id="stage" placeholder="stage">
                                <label class="mx-3">STAGE</label>
                            </div>
                            <div class="col-md-2 form-floating mb-3">
                                <input class="form-control" readonly name="name" id="semester" placeholder="semester">
                                <label class="mx-3">SEMESTER</label>
                            </div>
                        </div>
                        <div class="mb-3" id="invoiceDiv">
                            <input type="checkbox" checked disabled readonly>
                            <label id="invoice"></label>
                        </div>
                        <div class="row row-cols-sm-1 g-2">
                            <div class="form-floating mb-2">
                                <textarea name="description" class="form-control" style="height: 120px !important;" placeholder="Desc"></textarea>
                                <label class="mb-0">NARRATION</label>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-outline-success col-md-7" data-toggle="click-ripple">Save Invoice</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
<script>
   $(document).ready(function() {
        $('#select2').select2();
        $('#invoiceDiv').hide();

        $('#select2').on('change', function (){
            var code = $('#select2').val();
            $('#type').val('');
            $('#stage').val('');
            $('#semester').val('');
            $('#item').val('');
            $('#invoiceDiv').hide();
            $('#invoice').val('');

            $.ajax({
                type: 'get',
                url: '{{ route('finance.getInvoiceType') }}',
                data: { code:code },
                dataType: 'json',
                success:function (data){
                    if(data === ''){
                        toastr.error('Oops! Student/class must be on schedule and ongoing');
                    }
                    if (typeof data.student_id === 'undefined'){
                        $('#type').val('CLASS INVOICE');
                        $('#stage').val(data.stage);
                        $('#semester').val(data.pattern_id)
                        if (typeof data.class_id !== 'undefined'){
                            $('#invoiceDiv').show();
                        }
                        var className = 'STUDENTS : '+ data.name

                        // var className = 'CLASS CODE : '+ data.name + ' MODE OF STUDY : '+ data.attendance_id
                        // var resultsData = {!! json_encode($results) !!};

                        // var studentsClass = 'STUDENTS: ' + JSON.stringify(resultsData);
                        $('#invoice').text(className)
                    } else if (typeof data.class_id === 'undefined') {
                        $('#type').val('STUDENT INVOICE');
                        $('#stage').val(data.stage);
                        $('#semester').val(data.pattern_id)
                        if (typeof data.student_id !== 'undefined'){
                            $('#invoiceDiv').show();
                        }
                        var student = 'STUDENT NUMBER :' + data.student_number +' STUDENT NAME : '+ data.sname +' '+ data.fname + ' '+ data.mname +''
                        $('#invoice').text(student)
                    }
                }
            });
        });
   });
</script>
