@extends('cod::layouts.backend')
<style>
    /* Custom CSS to make form-floating elements smaller */
    .form-floating .form-control {
        height: 2.95rem !important;
        padding: 0.75rem 0.75rem 0 0.75rem !important;
        font-size: 0.875rem !important;
    }

    .form-floating label {
        font-size: 0.875rem !important;
    }

    .checkbox-item {
        margin-bottom: 10px;
    }

    .checkbox-item input[type="checkbox"] {
        margin-right: 5px;
    }

    .checkbox-item label.strikethrough {
        text-decoration: line-through;
    }

    .unit-type-select {
        margin-left: 10px;
    }

    #selectedUnitList .row {
        border: 1px solid #ccc;
        padding: 5px;
    }
</style>
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        {{ $syllabus->CourseSyllabusVersion->course_code }} {{ $syllabus->syllabus_name }} Syllabus
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Course Syllabus</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Syllabus Version
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
                    <form id="unitSelectionForm" action="{{ route('department.submitSyllabusUnits') }}" method="POST">
                        @csrf
                        <div class="row row-cols-sm-4 g-2">
                            @php
                                $years = substr($syllabus->CourseSyllabusVersion->courseRequirements->course_duration, 0, 1);
                            @endphp
                            <div class="mb-2 form-floating">
                                <select class="form-control" name="stage" required>
                                    <option selected disabled class="text-center">-- select --</option>
                                    @for($i = 1 ; $i <= $years; $i++) <option value="{{ $i }}">Year {{ $i }} </option>
                                    @endfor
                                </select>
                                <label>Year of Study</label>
                            </div>
                            <div class="mb-2 form-floating">
                                <select class="form-control" name="semester" required>
                                    <option selected disabled class="text-center">-- select --</option>
                                    <option value="1">Semester 1</option>
                                    <option value="2">Semester 2</option>
                                    <option value="3">Semester 3</option>
                                </select>
                                <label>Semester of Study</label>
                            </div>
                            <div class="mb-2 form-floating">
                                <select required class="form-control" name="option" >
                                    <option selected disabled class="text-center">-- select --</option>
                                    <option required value="{{ $syllabus->CourseSyllabusVersion->course_id }}">{{ $syllabus->CourseSyllabusVersion->course_name }} (MAIN)</option>
                                    @foreach($syllabus->CourseSyllabusVersion->CourseOptions as $option)
                                        @php
                                            $selected = $option->option_id == old('option') ? 'selected' : '';
                                            $strikethrough = $option->option_id == old('option') ? 'strikethrough' : '';
                                        @endphp
                                        <option value="{{ $option->option_id }}" {{ $selected }} class="{{ $strikethrough }}">{{ $option->option_name }}</option>
                                    @endforeach
                                </select>
                                <label>Course Options</label>
                            </div>
                            <div class="mb-2 form-floating">
                                <input type="text" name="search" class="form-control" id="searchBox" placeholder="search">
                                <label>type to search</label>
                            </div>
                        </div>

                        <div id="selectedUnits">
                            <h6>Selected Units:</h6>
                            <ul id="selectedUnitList" class="list-unstyled"></ul>
                            <input type="hidden" name="course_code" value="{{ $syllabus->CourseSyllabusVersion->course_code }}">
                            <input type="hidden" name="version" value="{{ $syllabus->syllabus_name }}">
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-alt-success col-md-7">Submit</button>
                            </div>
                        </div>
                    </form>

                    <div class="col-md-8">
                        <div class="d-flex justify-content-center">
                            <div id="unitList"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchBox').on('input', function() {
            var query = $(this).val();

            if (query.length >= 4) {
                $.ajax({
                    url: '{{ route('department.searchUnit') }}',
                    method: 'GET',
                    data: {
                        search: query
                    },
                    success: function(response) {
                        var unitList = $('#unitList');
                        unitList.empty();

                        $.each(response, function(index, unit) {
                            var checkbox = $('<input>', {
                                type: 'checkbox',
                                name: 'unitCodes[]',
                                value: unit.unit_code,
                                'data-unit-name': unit.unit_name
                            });

                            var label = $('<label>').text([unit.unit_code + " - " + unit.unit_name]);
                            var listItem = $('<div>', {
                                class: 'checkbox-item'
                            }).append(checkbox, label);

                            unitList.append(listItem);
                        });
                    }
                });
            } else {
                $('#unitList').empty();
            }
        });

        function addSelectedUnit(unitCode, unitName) {
            var selectedUnitList = $('#selectedUnitList');
            var listItem = $('<li>', {
                class: 'row mb-2',
                'data-unit-code': unitCode
            });

            var unitCodeCol = $('<div>', {
                class: 'col-md-2'
            }).text(unitCode);

            var unitNameCol = $('<div>', {
                class: 'col-md-7'
            }).text(unitName);

            var selectTypeCol = $('<div>', {
                class: 'col-md-3'
            });

            var selectType = $('<select>', {
                class: 'form-control unit-type-select',
                name: 'units[][unit_code]'
            }).append($('<option>', {
                value: 'core'
            }).text('Core')).append($('<option>', {
                value: 'elective'
            }).text('Elective'));

            selectTypeCol.append(selectType);
            listItem.append(unitCodeCol, unitNameCol, selectTypeCol);
            selectedUnitList.append(listItem);
        }

        $(document).on('change', 'input[type="checkbox"]', function() {
            var unitCode = $(this).val();
            var unitName = $(this).data('unit-name');
            var listItem = $('li[data-unit-code="' + unitCode + '"]');

            if (this.checked) {
                if (listItem.length === 0) {
                    addSelectedUnit(unitCode, unitName);
                }
            } else {
                listItem.remove();
            }

            $(this).siblings('label').toggleClass('strikethrough');
        });

        $('#unitSelectionForm').submit(function() {
            var form = $(this);
            var selectedUnitCodes = [];

            $('#selectedUnitList li').each(function() {
                var unitCode = $(this).data('unit-code');
                var unitType = $(this).find('.unit-type-select').val();
                selectedUnitCodes.push({
                    unit_code: unitCode,
                    unit_type: unitType
                });
            });

            if (selectedUnitCodes.length > 0) {
                var unitsInput = $('<input>', {
                    type: 'hidden',
                    name: 'units',
                    value: JSON.stringify(selectedUnitCodes)
                });

                form.append(unitsInput);
            }

            return true;
        });
    });


    $(document).ready(function() {
        $('#unitSelectionForm').submit(function(e) {
            var stageSelect = $('[name="stage"]');
            if (!stageSelect.val()) {
                e.preventDefault(); // Prevent form submission
                stageSelect.addClass('is-invalid'); // Add 'is-invalid' class for Bootstrap validation styling
                // You can also display an error message here
            }
        });
    });

    $(document).ready(function() {
        $('#unitSelectionForm').submit(function(e) {
            var stageSelect = $('[name="semester"]');
            if (!stageSelect.val()) {
                e.preventDefault(); // Prevent form submission
                stageSelect.addClass('is-invalid'); // Add 'is-invalid' class for Bootstrap validation styling
                // You can also display an error message here
            }
        });
    });

    $(document).ready(function() {
        $('#unitSelectionForm').submit(function(e) {
            var stageSelect = $('[name="option"]');
            if (!stageSelect.val()) {
                e.preventDefault(); // Prevent form submission
                stageSelect.addClass('is-invalid'); // Add 'is-invalid' class for Bootstrap validation styling
                // You can also display an error message here
            }
        });
    });
</script>
