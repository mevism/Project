@extends('application::layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Update your personal details
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-1 mt-sm-0 ms-sm-1" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Profile</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Update profile
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
{{--        <div class="col-sm d-flex justify-content-center p-4">--}}
{{--            <span class="alert alert-danger"> <i class="fa fa-info-circle"></i> Please ensure that you update your profile within 72hours or the account will be deleted permanently. </span>--}}
{{--        </div>--}}
        <div class="block-content">
            <div class="block-content block-content-full">
                <div class="d-flex justify-content-center fs-sm">
                    <span class="col-md-12 mb-4 text-center text-danger">
                    <i class="fa fa-info-circle"></i>
                    Please ensure that you update your profile within 72hours or the account will be deleted permanently.
                </span>
                </div>
                <div class="row">
                        <!-- Form Grid with Labels -->
                        <form class="" method="POST" action="{{ route('application.updateDetails') }}">
                            @csrf
                            <div class="row row-cols-sm-3 g-2">
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="fname" required value="@if(Auth::user()->fname != null){{ Auth::user()->fname }}@else{{ old('fname') }}@endif" placeholder="FIRST NAME">
                                    <label class="form-label" for="fname">FIRST NAME</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="mname" value="@if(Auth::user()->mname != null){{ Auth::user()->mname }}@else{{ old('mname') }}@endif" placeholder="MIDDLE NAME">
                                    <label class="form-label" for="mname">MIDDLE NAME</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control" name="sname" value="@if(Auth::user()->sname != null){{ Auth::user()->sname }}@else{{ old('sname') }}@endif" required placeholder="SUR NAME">
                                    <label class="form-label" for="sname">SUR NAME</label>
                                </div>
                                <div class="form-floating col-12">
                                <select class="form-control text-muted" name="title" required>
                                    <option selected="selected" disabled class="text-center"> - select title - </option>
                                    <option @if(old('title') == 'Mr.') selected="selected" @endif value="Mr."> Mr.</option>
                                    <option @if(old('title') == 'Miss.') selected="selected" @endif value="Miss."> Miss. </option>
                                    <option @if(old('title') == 'Ms.') selected="selected" @endif value="Ms."> Ms. </option>
                                    <option @if(old('title') == 'Mrs.') selected="selected" @endif value="Mrs."> Mrs. </option>
                                    <option @if(old('title') == 'Dr.') selected="selected" @endif value="Dr.">Dr.</option>
                                    <option @if(old('title') == 'Prof.') selected="selected" @endif value="Prof."> Prof. </option>
                                </select>
                                <label class="form-label" for="title">TITTLE</label>
                            </div>
                            <div class="form-floating col-12">
                                    <select name="status" id="status" class="form-control text-muted" required>
                                        <option disabled selected class="text-center"> - select martial status - </option>
                                        <option @if(old('status') == 'Single') selected="selected" @endif value="single" >Single</option>
                                        <option @if(old('status') == 'Married') selected="selected" @endif value="married">Married</option>
                                        <option @if(old('status') == 'Divorced') selected="selected" @endif value="divorced" >Divorced</option>
                                        <option @if(old('status') == 'Separated') selected="selected" @endif value="separated" >Separated</option>
                                    </select>
                                    <label class="form-label" for="status">MARITAL STATUS</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="date" class="form-control" name="dob" value="{{ old('dob') }}" required>
                                    <label class="form-label">DATE OF BIRTH </label>
                                </div>
                                @if(Auth::user()->student_type ==2 )
                                    <div class="form-floating col-12">
                                        <input type="text" class="form-control text-uppercase" name="mobile"value="@if(Auth::user()->mobile != null ){{ Auth::user()->mobile }}@else{{ old('alt_number') }}@endif" required placeholder="PHONE">
                                        <label class="form-label">MOBILE NUMBER</label>
                                    </div>
                                    @else
                                    <div class="col-12 mb-4">
                                    <label class="form-label">GENDER</label>
                                    <div class="space-x-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" value="M" @if(old('gender') == 'Male') checked @endif @if(Auth::user()->gender != null) {{ (Auth::user()->gender == 'M') ? "checked" : "" }} @endif required>
                                                <label class="form-check-label">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" value="F" @if(old('gender') == 'Female') checked @endif @if(Auth::user()->gender != null) {{ (Auth::user()->gender == 'F') ? "checked" : "" }} @endif required>
                                                <label class="form-check-label">Female</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" value="O" @if(old('gender') == 'Other') checked @endif required>
                                                <label class="form-check-label">Other</label>
                                            </div>
                                    </div>
                                </div>
                                @endif

                            <div class="form-floating col-12">
                                <input type="text" class="form-control text-uppercase" name="id_number" value="{{ old('id_number') }}" required placeholder="ID/PASSPORT/BIRTH CERT">
                                <label class="form-label">ID/ BIRTH/ PASSPORT NUMBER</label>
                            </div>
                                @if(Auth::user()->student_type == 2)
                                    <div class="form-floating col-12">
                                        <input type="email" class="form-control text-lowercase" name="email" value=" @if(Auth::user()->email != null) {{ Auth::user()->email }} @else {{ old('alt_email') }} @endif" required placeholder="EMAIL">
                                        <label class="form-label">EMAIL ADDRESS</label>
                                    </div>
                                @else
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="index_number" value="{{ old('index_number') }}" required placeholder="INDEX">
                                    <label class="form-label" for="index_number">INDEX/REGISTRATION NUMBER</label>
                                </div>
                                @endif
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="alt_number" value="@if(Auth::user()->alt_mobile != null){{ Auth::user()->alt_mobile }}@else{{ old('alt_number') }}@endif" required placeholder="PHONE">
                                    <label class="form-label">ALTERNATIVE MOBILE NUMBER</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="email" class="form-control text-lowercase" name="alt_email" value="@if(Auth::user()->alt_email != null){{ Auth::user()->alt_email }}@else{{ old('alt_email') }}@endif" required placeholder="EMAIL">
                                    <label class="form-label">ALTERNATIVE EMAIL ADDRESS</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="address" value="@if(Auth::user()->address != null){{ Auth::user()->address }}@else{{ old('address') }}@endif" required placeholder="BOX">
                                    <label class="form-label">P.O BOX</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="postalcode" value="@if(Auth::user()->postal_code != null){{ Auth::user()->postal_code }}@else{{ old('address') }}@endif" required placeholder="POSTAL">
                                    <label class="form-label">POSTAL CODE</label>
                                </div>
                                <div class="form-floating col-12">
                                    <select class="form-control text-muted" name="nationality" required placeholder="FIRST NAME">
                                        <option value="" selected disabled class="text-center"> - select nationality -</option>
                                        <option value="KE">KENYAN</option>
                                        <option value="UG">UGANDAN</option>
                                        <option value="TZ">TANZANIAN</option>
                                    </select>
                                    <label class="form-label">NATIONALITY</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="county" required value="{{ old('county') }}" placeholder="COUNTY">
                                    <label class="form-label">COUNTY</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="subcounty" value="{{ old('subcounty') }}" placeholder="SUB COUNTY" required>
                                    <label class="form-label">SUB-COUNTY</label>
                                </div>
                                <div class="form-floating col-12">
                                    <input type="text" class="form-control text-uppercase" name="town" required value="@if(Auth::user()->town != null){{ Auth::user()->town }}@else{{ old('town') }}@endif" placeholder="TOWN">
                                    <label class="form-label">TOWN</label>
                                </div>
                            <div class="col-12">
                                <label class="form-label">ARE YOU DISABLED </label>
                                <div class="space-x-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="disabled" value="No" @if(old('disabled') == 'No') checked @endif required>
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="disabled" value="Yes" @if(old('disabled') == 'Yes') checked @endif required>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="desc form-floating col-12 mt-4">
                                <textarea class="form-control" name="disability" rows="4" placeholder="Describe here kind of disability" value="{{ old('disability') }}"></textarea>
                                <label class="form-label" for="disability">Nature of disability</label>
                            </div>
                                <div class="d-flex justify-content-center text-center mt-4">
                                        <button class="col-md-3 btn btn-alt-success" data-toggle="ripple" type="submit"> Update details </button>
                                </div>
                        </form>
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

                if(selectedValue == 'Yes') {
                    $('div.desc').show();
                }else if(selectedValue == 'No'){
                    $('div.desc').hide();
                }
            });
        });

    </script>

    <script src="{{ url('/js/oneui.app.js') }}"></script>
@endsection
