@extends('registrar::layouts.backend')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0" >
                        ADD USERS
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Add Users</a>
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
                <div class="col-md-6">
                    <fieldset class="border p-2 fs-sm" style="height: 100% !important;">
                        <legend class="float-none w-auto"><h5>Employee Details</h5></legend>
                        <h5>Personal Information</h5>
                        <div class="row mb-2">
                            <div class="col-3 fw-semibold">Staff Number </div>
                            <div class="col-9">: {{ $staff['dataPayload']['data']['staff_number'] }} </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3 fw-semibold">Staff Name </div>
                            <div class="col-9">: {{ $staff['dataPayload']['data']['full_name'] }} </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-3 fw-semibold">Gender </div>
                            <div class="col-9">: {{ $staff['dataPayload']['data']['gender'] }}</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-3 fw-semibold">ID Number </div>
                            <div class="col-9">: {{ $staff['dataPayload']['data']['id_number'] }} </div>
                        </div>

                        <h5>Contact Information</h5>

                        <div class="row mb-2">
                            <div class="col-3 fw-semibold">Phone Number </div>
                            <div class="col-9">: {{ $staff['dataPayload']['data']['mobile_number'] }} </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-3 fw-semibold">Alt. Number</div>
                            <div class="col-9">: {{ $staff['dataPayload']['data']['mobile_number'] }} </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-3 fw-semibold">Official Email</div>
                            <div class="col-9">: {{ $staff['dataPayload']['data']['work_email'] }} </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-3 fw-semibold">Personal Email</div>
                            <div class="col-9">: {{ $staff['dataPayload']['data']['personal_email'] }} </div>
                        </div>
                    </fieldset>
                </div>

                    <div class="col-md-6">
                        <form method="post" action="{{ route('admin.importUsers') }}">
                            @csrf
                        <fieldset class="border p-2" style="height: 100% !important;">
                        <legend class="float-none w-auto"><h6>Employment Details</h6></legend>
                            <div class="form-floating mb-2">
                                <select class="form-control" name="campus" id="#campus">
                                    <option disabled selected class="text-center">-- select campus --</option>
                                    @foreach($campuses as $campus)
                                        <option value="{{ $campus->campus_id }}">{{ $campus->name }}</option>
                                    @endforeach
                                </select>
                                <label>CAMPUS NAME</label>
                                <input type="hidden" name="userId" value="{{ $staff['dataPayload']['data']['id_number'] }}">
                                <input type="hidden" name="staffNumber" value="{{ $staff['dataPayload']['data']['staff_number'] }}">
                            </div>
                            <div class="form-floating mb-2">
                                <select class="form-control" name="division" id="division">
                                    <option disabled selected class="text-center">-- select division --</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->division_id }}">{{ $division->name }}</option>
                                    @endforeach
                                </select>
                                <label>DIVISION NAME</label>
                            </div>
                            <div class="form-floating mb-2">
                                <select class="form-control" name="department" id="department">
                                    <option disabled selected class="text-center">-- select department --</option>

                                </select>
                                <label>DEPARTMENT NAME</label>
                            </div>

                            <div class="form-floating mb-2">
                                <select class="form-control" name="station" id="station">
                                    <option disabled selected class="text-center">-- select station --</option>

                                </select>
                                <label>STATION NAME</label>
                            </div>

                            <div class="form-floating mb-2">
                                <select class="form-control" name="role" id="role">
                                    <option disabled selected class="text-center">-- select role --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <label>USER ROLE</label>
                            </div>

                            <div class="form-floating mb-2">
                                <select class="form-control" name="contract" id="contract">
                                    <option disabled selected class="text-center">-- select contract type --</option>
                                    <option value="FT">FULL TIME</option>
                                    <option value="PT">PART TIME</option>
                                </select>
                                <label>EMPLOYMENT TERMS</label>
                            </div>
                    </fieldset>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-md btn-alt-success col-md-7">CREATE USER</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    $(document).ready(function () {
        $(document).on('change', '#division', function () {
            var division = $(this).val();
            var departmentDropdown = $('#department');
            var stationDropdown = $('#station');

            // Clear previous options
            departmentDropdown.empty();
            stationDropdown.empty();

            // Add default option
            departmentDropdown.append('<option disabled selected class="text-center">-- select department --</option>');
            stationDropdown.append('<option disabled selected class="text-center">-- select station --</option>');

            // Make AJAX request
            $.ajax({
                type: 'get',
                url: '{{ route('admin.divisionDepartment') }}',
                data: { division: division },
                dataType: 'json',
                success: function (data) {
                    // Populate department dropdown
                    for (var i = 0; i < data.length; i++) {
                        departmentDropdown.append('<option value="' + data[i].department_id + '">' + data[i].name + '</option>');
                    }
                }
            });
        });

        $(document).on('change', '#department', function () {
            var departmentID = $(this).val();
            var stationDropdown = $('#station');

            // Clear previous options
            stationDropdown.empty();

            // Add default option
            stationDropdown.append('<option disabled selected class="text-center">-- select station --</option>');

            // Make AJAX request
            $.ajax({
                type: 'get',
                url: '{{ route('admin.getDepartment') }}',
                data: { deptID: departmentID },
                dataType: 'json',
                success: function (data) {
                    // Populate station dropdown
                    stationDropdown.append('<option value="' + data.department_id + '">' + data.name + '</option>');
                }
            });
        });
    });

</script>

{{--<script>--}}
{{--    $(document).ready(function () {--}}
{{--        $(document).on('change', '#division', function () {--}}

{{--            var division = $('#division').val();--}}
{{--            var op = '';--}}
{{--            $.ajax({--}}

{{--                type: 'get',--}}
{{--                url: '{{ route('admin.divisionDepartment') }}',--}}
{{--                data: {division: division},--}}
{{--                dataType: 'json',--}}
{{--                success: function (data) {--}}

{{--                    var op = '';--}}

{{--                    op += '<option value="0" selected disabled class="text-center"> -- select -- </option>';--}}

{{--                    for (var i = 0; i < data.length; i++) {--}}
{{--                        op += '<option value="' + data[i].department_id + '">' + data[i].name + '</input>';--}}
{{--                    }--}}

{{--                    $('#department').append(op);--}}

{{--                }--}}
{{--            });--}}

{{--            $(document).on('change', '#department', function () {--}}

{{--                var deptID = $('#department').val();--}}
{{--                var op1 = '';--}}

{{--                console.log(deptID)--}}

{{--                $.ajax({--}}

{{--                    type: 'get',--}}
{{--                    url: '{{ route('admin.getDepartment') }}',--}}
{{--                    data: {deptID: deptID},--}}
{{--                    dataType: 'json',--}}
{{--                    success: function (data) {--}}

{{--                        console.log(data)--}}

{{--                        op1 += '<option value="0" selected disabled class="text-center"> -- select section -- </option>';--}}

{{--                        op1 += '<option value="' + data.department_id + '"> ' + data.name + ' </option>';--}}

{{--                        $('#station').append(op1);--}}
{{--                    }--}}
{{--                });--}}

{{--            });--}}

{{--        });--}}

{{--    });--}}

{{--</script>--}}
