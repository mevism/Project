@extends('registrar::layouts.backend')
<style>
    /* Custom CSS to make form-floating elements smaller */
    .form-floating .form-control {
        height: 2.5rem !important;
        padding: 0.5rem 0.5rem 0 0.5rem !important;
        font-size: 0.75rem !important;
    }

    .form-floating label {
        font-size: 0.65rem !important;
    }

    .selected-item{
        margin: 2px !important;
        padding: 5px !important;
        border: 1px solid #ccc;
    }

    .votehead-item {
        border-bottom: 1px solid #ccc;
        padding: 8px 0;
    }

    .votehead-item label {
        margin-left: 10px;
    }

    .strikethrough {
        text-decoration: line-through;
        color: red;
    }
</style>
@section('content')

<div class="bg-body-light">
  <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <div class="flex-grow-1">
            <h6 class="h6 fw-bold mb-0">
                ADD VOTEHEADS
            </h6>
        </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-alt">
                  <li class="breadcrumb-item">
                      <a class="link-fx" href="javascript:void(0)">VOTEHEADS</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a  href="showVoteheads">ADD VOTEHEADS</a>
                  </li>
              </ol>
          </nav>
      </div>
  </div>
</div>
<div class="block block-rounded">
    <div class="block-content block-content-full">
        <div class="content">
            <div class="d-flex justify-content-end mb-4">
                <div class="col-md-4">
                    <input class="form-control form-control-sm" type="text" name="search" id="search" placeholder="Search votehead">
                </div>
            </div>
            <div class="mb-4" id="filteredVoteheadsContainer"></div>
            <h6 class="h6 fw-semibold mb-2" id="selectedVoteheadsHeading">Selected Voteheads:</h6>
            <div id="selectedVoteheadsContainer"></div>
            <form id="voteheadForm" method="POST" action="{{ route('courses.storeVoteheads') }}">
                @csrf
                <div class="mt-4 d-flex justify-content-center">
                    <button id="submitBtn" type="submit" class="btn btn-alt-success col-md-7">Submit Selection</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#search').on('input', function () {
            var query = $(this).val();
            if (query.length >= 3) {
                $.ajax({
                    'type': 'GET',
                    'url': '{{ route('courses.getVoteheads') }}',
                    'data': { query: query },
                    success: function (response) {
                        // Clear previous content before appending new data
                        $('#filteredVoteheadsContainer').empty();

                        // Append the new filtered voteheads
                        var voteheadHTML = '';
                        response.data.forEach(function (item) {
                            voteheadHTML += `
                                <div class="row votehead-item">
                                    <div class="col-2">
                                        <input type="checkbox" value="${item.id}" data-name="${item.name}" class="votehead-checkbox"> ${item.id}
                                    </div>
                                    <div class="col-md-10"><label> ${item.name} </label></div>
                                </div>
                            `;
                        });

                        // Append the complete HTML to the container
                        $('#filteredVoteheadsContainer').append(voteheadHTML);
                    }
                });
            }
        });

        function checkSelectedVoteheads() {
            var selectedContainer = $('#selectedVoteheadsContainer');
            var filteredContainer = $('#filteredVoteheadsContainer');
            var submitBtn = $('#submitBtn');
            var selectedVoteheadsHeading = $('#selectedVoteheadsHeading');

            if (selectedContainer.children().length === 0) {
                submitBtn.hide();
                selectedVoteheadsHeading.hide();
            } else {
                submitBtn.show();
                selectedVoteheadsHeading.show();
            }

            if (filteredContainer.children().length === 0) {
                selectedVoteheadsHeading.hide();
            } else {
                selectedVoteheadsHeading.show();
            }
        }

        checkSelectedVoteheads();

        // Attach event handler for checkbox clicks
        $(document).on('click', '.votehead-checkbox', function() {
            var selectedValue = $(this).val();
            var selectedName = $(this).data('name');
            var selectedContainer = $('#selectedVoteheadsContainer');
            var selectedItemHTML = `
                <div class="row mb-4 selected-item" data-selected-value="${selectedValue}">
                    <div class="col-md-2">${selectedValue}</div>
                    <div class="col-md-4">${selectedName}</div>
                    <div class="form-floating col-md-3">
                        <select class="form-control unit-type-select" required name="units[][unit_code]" id="selected">
                            <option selected disabled class="text-center">-- select -- </option>
                            <option value="1">FEES</option>
                            <option value="2">FINES</option>
                            <option value="3">OTHERS</option>
                        </select>
                    <label class="mx-2">VOTEHEAD CATEGORY </label>
                    </div>
                    <div class="form-floating col-md-3">
                        <select class="form-control unit-type-select" required name="units[][unit_code]" id="selected">                           <option selected disabled class="text-center">-- select -- </option>
                            <option value="1">INCOME</option>
                            <option value="2">LIABILITY</option>
                        </select>
                    <label class="mx-2">VOTEHEAD TYPE </label>
                    </div>
                </div>
            `;

            if ($(this).is(':checked')) {
                // Check if the selected item is not already in the selectedContainer
                if (!selectedContainer.find(`[data-selected-value="${selectedValue}"]`).length) {
                    selectedContainer.append(selectedItemHTML);
                }
                $('.votehead-item').has(this).addClass('strikethrough');
            } else {
                // Remove the selected item from the container
                selectedContainer.find(`[data-selected-value="${selectedValue}"]`).remove();
                $('.votehead-item').has(this).removeClass('strikethrough');
            }

            checkSelectedVoteheads();
        });

        $('#voteheadForm').submit(function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Prepare the data to be submitted
            var formData = [];
            var isValid = true;

            $('#selectedVoteheadsContainer .selected-item').each(function () {
                var selectedValue = $(this).data('selected-value');
                var selectedName = $(this).find('.col-md-4').text();
                var voteheadCategory = $(this).find('[name="units[][unit_code]"]:eq(0)').val();
                var voteheadType = $(this).find('[name="units[][unit_code]"]:eq(1)').val();

                if (!voteheadCategory || !voteheadType) {
                    isValid = false;
                    // Display an error message to the user or add some visual indicator for the empty fields
                    // For example, you can add a class to the invalid fields to highlight them
                    $(this).find('select').addClass('is-invalid');
                } else {
                    $(this).find('select').removeClass('is-invalid');
                }

                // Add the data for the selected votehead to the formData array
                formData.push({
                    votehead: selectedValue,
                    voteheadName: selectedName,
                    voteheadCategory: voteheadCategory,
                    voteheadType: voteheadType,
                });
            });

                if (!isValid) {
                    alert('Please fill in all the required fields.');
                    return;
                }
            // Add a hidden input element to hold the JSON data in the form
            var jsonDataInput = $('<input>', {
                type: 'hidden',
                name: 'voteheads',
                value: JSON.stringify(formData)
            });

            // Append the jsonDataInput to the form
            $(this).append(jsonDataInput);

            // Now, the form is ready to be submitted with the selected voteheads data
            this.submit();
        });
    });
</script>








