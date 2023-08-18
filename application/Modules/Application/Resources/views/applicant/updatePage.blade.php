@extends('application::layouts.backend')
<style>
    .form-floating .form-control {
        height: 2.95rem !important;
        padding: 0.75rem 0.75rem 0 0.75rem !important;
        font-size: 0.875rem !important;
    }

    .form-floating label {
        font-size: 0.875rem !important;
    }

</style>
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h6 class="h6 fw-bold mb-0 text-uppercase">
                        Update your personal details
                    </h6>
                </div>
                <nav class="flex-shrink-0 mt-1 mt-sm-0 ms-sm-1" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item text-uppercase">
                            <a class="link-fx" href="javascript:void(0)">Profile</a>
                        </li>
                        <li class="breadcrumb-item text-uppercase" aria-current="page">
                            Update profile
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-content">
            <div class="block-content block-content-full">
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <div class="col-lg-10">
                            <!-- Block Tabs Animated Slide Up -->
                            <div class="block block-rounded">
                                <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                                    <li class="nav-item">
                                        @php
                                            $user = auth()->guard('web')->user();
                                        @endphp

                                        <button class="nav-link @if($user->student_type == 1 && $user->infoApplicant == null || $user->student_type == 2 && $user->infoApplicant->title == null) active @endif" id="btabs-animated-slideup-home-tab" data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-home" role="tab" aria-controls="btabs-animated-slideup-home" aria-selected="true">Personal Information @if($user->infoApplicant != null && $user->infoApplicant->title != null) <i class="fa fa-check text-success"></i> @endif </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link @if($user->student_type == 1 && $user->infoApplicant != null && $user->contactApplicant->alt_email == null || $user->student_type == 2 && $user->infoApplicant->title != null && $user->contactApplicant->alt_email == null) active @endif" id="btabs-animated-slideup-profile-tab" data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-profile" role="tab" aria-controls="btabs-animated-slideup-profile" aria-selected="false">Contact Information @if($user->infoApplicant != null && $user->contactApplicant->alt_email != null && $user->contactApplicant->alt_mobile != null) <i class="fa fa-check text-success"></i> @endif </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link @if($user->student_type == 1 && $user->infoApplicant != null && $user->contactApplicant->alt_email != null && $user->addressApplicant == null || $user->student_type == 2 && $user->infoApplicant->title != null && $user->contactApplicant->alt_email != null && $user->contactApplicant->alt_mobile != null && $user->addressApplicant->nationality == null) active @endif" id="btabs-animated-slideup-address-tab" data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-address" role="tab" aria-controls="btabs-animated-slideup-address" aria-selected="false">Address Information @if($user->addressApplicant != null && $user->addressApplicant->nationality != null && $user->infoApplicant->title != null) <i class="fa fa-check text-success"></i> @endif </button>
                                    </li>
                                    <li class="nav-item ms-auto">
                                        <span class="text-warning mt-4 fs-sm">
                                            <i class="fa fa-info-circle"></i>
                                               Fill all fields marked with <span class="text-danger">*</span>
                                        </span>
                                    </li>
                                </ul>
                                <div class="block-content tab-content overflow-hidden">
                                    <div class="tab-pane fade fade-up show @if($user->infoApplicant == null || $user->student_type == 2 && $user->infoApplicant->title == null) active @endif" id="btabs-animated-slideup-home" role="tabpanel" aria-labelledby="btabs-animated-slideup-home-tab">
                                        <form class="" method="POST" action="{{ route('applicant.personalInfo') }}">
                                            @csrf
                                            <div class="row row-cols-sm-2 g-2">
                                                <div class="form-floating col-12">
                                                    <select class="form-control text-muted" name="title" required>
                                                        <option selected="selected" disabled class="text-center"> - select title - </option>
                                                        <option @if($user->infoApplicant != null)
                                                                @if($user->infoApplicant->title == 'MR.') selected @endif @endif value="Mr."> Mr.</option>
                                                        <option @if($user->infoApplicant != null)
                                                                @if($user->infoApplicant->title == 'MISS.') selected @endif @endif value="Miss."> Miss. </option>
                                                        <option @if($user->infoApplicant != null)
                                                                @if($user->infoApplicant->title == 'MS.') selected @endif @endif value="Ms."> Ms. </option>
                                                        <option @if($user->infoApplicant != null)
                                                                @if($user->infoApplicant->title == 'MRS.') selected @endif @endif value="Mrs."> Mrs. </option>
                                                        <option @if($user->infoApplicant != null)
                                                                @if($user->infoApplicant->title == 'DR.') selected @endif @endif value="Dr.">Dr.</option>
                                                        <option @if($user->infoApplicant != null)
                                                                @if($user->infoApplicant->title == 'PROF.') selected @endif @endif value="Prof."> Prof. </option>
                                                    </select>
                                                    <label class="form-label" for="title"><span class="text-danger">*</span> TITTLE </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="fname" required value="@if($user->infoApplicant != null){{ $user->infoApplicant->first_name }}@else{{ old('fname') }}@endif" placeholder="FIRST NAME">
                                                    <label class="form-label" for="fname"><span class="text-danger">*</span> FIRST NAME </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="mname" value="@if($user->infoApplicant != null){{ $user->infoApplicant->middle_name }}@else{{ old('mname') }}@endif" placeholder="MIDDLE NAME">
                                                    <label class="form-label" for="mname">MIDDLE NAME</label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control" name="sname" value="@if($user->infoApplicant != null){{ $user->infoApplicant->surname }}@else{{ old('sname') }}@endif" required placeholder="SUR NAME">
                                                    <label class="form-label" for="sname"><span class="text-danger">*</span> SUR NAME </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <select name="status" id="status" class="form-control text-muted" required>
                                                        <option disabled selected class="text-center"> - select martial status - </option>
                                                        <option @if($user->infoApplicant != null)
                                                                @if($user->infoApplicant->marital_status == 'SINGLE') selected @endif @endif value="single" >Single</option>
                                                        <option @if($user->infoApplicant != null)
                                                                @if($user->infoApplicant->marital_status == 'MARRIED') selected @endif @endif value="married">Married</option>
                                                        <option @if($user->infoApplicant != null)
                                                                @if($user->infoApplicant->marital_status == 'DIVORCED') selected @endif @endif value="divorced" >Divorced</option>
                                                        <option @if($user->infoApplicant != null)
                                                                @if($user->infoApplicant->marital_status == 'SEPARATED') selected @endif @endif value="separated" >Separated</option>
                                                    </select>
                                                    <label class="form-label" for="status"><span class="text-danger">*</span> MARITAL STATUS </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="date" class="form-control" name="dob" value="@if($user->infoApplicant != null){{ Carbon\Carbon::parse($user->infoApplicant->dob)->format('Y-m-d') }}@else {{ old('dob') }}@endif" required placeholder="">
                                                    <label class="form-label"><span class="text-danger">*</span> DATE OF BIRTH </label>
                                                </div>
                                                <div class="col-12 mb-4">
                                                        <label class="form-label"><span class="text-danger">*</span> GENDER </label>
                                                        <div class="space-x-2">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" value="M" @if(old('gender') == 'Male') checked @endif @if($user->infoApplicant != null) {{ ($user->infoApplicant->gender == 'M') ? "checked" : "" }} @endif required>
                                                                <label class="form-check-label">MALE</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" value="F" @if(old('gender') == 'Female') checked @endif @if($user->infoApplicant != null) {{ ($user->infoApplicant->gender == 'F') ? "checked" : "" }} @endif required>
                                                                <label class="form-check-label">FEMALE</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" value="O" @if(old('gender') == 'Other') checked @endif required>
                                                                <label class="form-check-label">OTHER</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="index_number" value="@if($user->infoApplicant != null){{ $user->infoApplicant->index_number }}@else{{ old('index_number') }}@endif" required placeholder="INDEX">
                                                    <label class="form-label" for="index_number"><span class="text-danger">*</span> INDEX/REGISTRATION NUMBER </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <select class="form-control" name="idType">
                                                        <option selected disabled> -- select identification type -- </option>
                                                        <option value="1">NATIONAL ID NUMBER</option>
                                                        <option value="2">BIRTH CERTIFICATE</option>
                                                        <option value="3">PASSPORT NUMBER</option>
                                                        <option value="4">ALIEN ID NUMBER</option>
                                                    </select>
                                                    <label><span class="text-danger">*</span>IDENTIFICATION TYPE</label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="identification" value="@if($user->infoApplicant != null){{ $user->infoApplicant->identification }}@else{{ old('identification') }}@endif" required placeholder="ID/PASSPORT/BIRTH CERT">
                                                    <label class="form-label"><span class="text-danger">*</span> IDENTIFICATION NUMBER </label>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label"><span class="text-danger">*</span> ARE YOU DISABLED </label>
                                                    <div class="space-x-2">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="disabled" value="NO" @if($user->infoApplicant != null) {{ ($user->infoApplicant->disabled == 'NO') ? "checked" : "" }} @endif required>
                                                            <label class="form-check-label">NO</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="disabled" value="YES" @if($user->infoApplicant != null) {{ ($user->infoApplicant->disabled == 'YES') ? "checked" : "" }} @endif required>
                                                            <label class="form-check-label">YES</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="desc form-floating col-12 mt-4">
                                                <textarea class="form-control" name="disability" rows="4" placeholder="Describe here kind of disability" value="{{ old('disability') }}">@if($user->infoApplicant != null){{ $user->infoApplicant->disability }}@else{{ old('disability') }}@endif</textarea>
                                                <label class="form-label" for="disability">NATURE OF DISABILITY</label>
                                            </div>
                                            <div class="d-flex justify-content-center text-center mt-4">
                                                <button class="col-md-3 btn btn-alt-success" data-toggle="ripple" type="submit"> Submit & Continue </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade fade-up show @if($user->student_type == 1 && $user->infoApplicant != null && $user->contactApplicant->alt_email == null || $user->student_type == 2 && $user->infoApplicant->title != null && $user->contactApplicant->alt_email == null) active @endif" id="btabs-animated-slideup-profile" role="tabpanel" aria-labelledby="btabs-animated-slideup-profile-tab">
                                        <form class="" method="POST" action="{{ route('applicant.contactInfo') }}">
                                            @csrf
                                            <div class="row row-cols-sm-2 g-2">
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="mobile"value="@if($user->contactApplicant->mobile != null ){{ $user->contactApplicant->mobile }}@else{{ old('alt_number') }}@endif" required placeholder="PHONE">
                                                    <label class="form-label"><span class="text-danger">*</span> MOBILE NUMBER </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="email" class="form-control text-lowercase" name="email" value=" @if($user->contactApplicant->email != null) {{ $user->contactApplicant->email }} @else {{ old('email') }} @endif" required placeholder="EMAIL">
                                                    <label class="form-label"><span class="text-danger">*</span> EMAIL ADDRESS </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="alt_number" value="@if($user->contactApplicant->alt_mobile != null){{ $user->contactApplicant->alt_mobile }}@else{{ old('alt_number') }}@endif" required placeholder="PHONE">
                                                    <label class="form-label"><span class="text-danger">*</span> ALTERNATIVE MOBILE NUMBER </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="email" class="form-control text-lowercase" name="alt_email" value="@if($user->contactApplicant->alt_email != null){{ $user->contactApplicant->alt_email }}@else{{ old('alt_email') }}@endif" required placeholder="EMAIL">
                                                    <label class="form-label"><span class="text-danger">*</span> ALTERNATIVE EMAIL ADDRESS </label>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center text-center mt-4">
                                                <button class="col-md-3 btn btn-alt-success" data-toggle="ripple" type="submit"> Submit & Continue </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade fade-up show @if($user->student_type == 1 && $user->infoApplicant != null && $user->contactApplicant->alt_email != null && $user->addressApplicant == null || $user->student_type == 2 && $user->infoApplicant->title != null && $user->contactApplicant->alt_email != null && $user->contactApplicant->alt_mobile != null && $user->addressApplicant->nationality == null) active @endif" id="btabs-animated-slideup-address" role="tabpanel" aria-labelledby="btabs-animated-slideup-address-tab">
                                        <form class="" method="POST" action="{{ route('applicant.addressInfo') }}">
                                            @csrf
                                            <div class="row row-cols-sm-2 g-2">
                                                <div class="form-floating col-12">
                                                    <select class="form-control text-muted" name="nationality" required placeholder="FIRST NAME">
                                                        <option value="" selected disabled class="text-center"> - select nationality - </option>
                                                        <option @if($user->addressApplicant != null)
                                                                @if($user->addressApplicant->nationality == 'KE') selected  @endif @endif value="KE" >KENYAN</option>
                                                        <option @if($user->addressApplicant != null)
                                                                @if($user->addressApplicant->nationality == 'UG') selected @endif @endif value="UG" >UGANDAN</option>
                                                        <option @if($user->addressApplicant != null)
                                                                @if($user->addressApplicant->nationality == 'TZ') selected @endif @endif value="TZ"  >TANZANIAN</option>
                                                    </select>
                                                    <label class="form-label"><span class="text-danger">*</span> NATIONALITY </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="county" required value="@if($user->addressApplicant != null){{ $user->addressApplicant->county }} @else {{ old('county') }}@endif" placeholder="COUNTY">
                                                    <label class="form-label"><span class="text-danger">*</span> COUNTY </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="subcounty" value="@if($user->addressApplicant != null){{ $user->addressApplicant->sub_county }} @else {{ old('subcounty') }}@endif" placeholder="SUB COUNTY" required>
                                                    <label class="form-label"><span class="text-danger">*</span> SUB-COUNTY </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="town" required value="@if($user->addressApplicant != null){{ $user->addressApplicant->town }}@else{{ old('town') }}@endif" placeholder="TOWN">
                                                    <label class="form-label"><span class="text-danger">*</span> TOWN </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="address" value="@if($user->addressApplicant != null){{ $user->addressApplicant->address }}@else{{ old('address') }}@endif" required placeholder="BOX">
                                                    <label class="form-label"><span class="text-danger">*</span> P.O BOX </label>
                                                </div>
                                                <div class="form-floating col-12">
                                                    <input type="text" class="form-control text-uppercase" name="postalcode" value="@if($user->addressApplicant != null){{ $user->addressApplicant->postal_code }}@else{{ old('postalcode') }}@endif" required placeholder="POSTAL">
                                                    <label class="form-label">POSTAL CODE <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center text-center mt-4">
                                                <button class="col-md-3 btn btn-alt-success" data-toggle="ripple" type="submit"> Save & Continue </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- END Block Tabs Animated Slide Up -->

                        </div>
                </div>
                        <!-- Form Grid with Labels -->
                        <!-- END Form Grid with Labels -->
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function (){
            $('div.desc').hide();

            $('input[name=disabled]').on('click', function () {
                var selectedValue = $('input[name=disabled]:checked').val();

                if(selectedValue == 'YES') {
                    $('div.desc').show();
                }else if(selectedValue == 'NO'){
                    $('div.desc').hide();
                }
            });
        });

    </script>

{{--    <script src="{{ url('/js/oneui.app.js') }}"></script>--}}
@endsection
