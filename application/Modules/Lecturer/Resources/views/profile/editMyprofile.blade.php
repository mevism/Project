@extends('lecturer::layouts.backend')
@section('content')

@php
   $user = auth()->guard('user')->user();
@endphp

    <div class="bg-image" style="background-image: url( {{ url('media/photos/photo12@2x.jpg')}} );">
      <div class="bg-primary-dark-op">
        <div class="content content-full text-center">
          <div class="my-3">
            <img class="img-avatar img-avatar-thumb" src="{{ url('media/profile', auth()->guard('user')->user()->profile_image)}}" alt="">
          </div>
          <h1 class="h2 text-white mb-0">Edit Account</h1>
          <h2 class="h4 fw-normal text-white-75 mt-3">
            {{ auth()->guard('user')->user()->title }} {{ auth()->guard('user')->user()->last_name }} {{ auth()->guard('user')->user()->first_name }} {{ auth()->guard('user')->user()->middle_name }}
          </h2>
          <a class="btn btn-alt-secondary" href="{{route('lecturer.myProfile') }}">
            <i class="fa fa-fw fa-arrow-left text-danger"></i> Back to Profile
          </a>
        </div>
      </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content content-boxed">
      <!-- User Profile -->
      <div class="block block-rounded">
        <div class="block-header block-header-default">
          <h3 class="block-title">User Profile</h3>
        </div>
        <div class="block-content">
          <form action="{{ route('lecturer.updateMyprofile', $user->id) }}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="row push">
              <div class="col-lg-6">
                <div class="mb-4">
                    <label class="form-label" for="select">Select</label>
                    <select class="form-select" id="select" name="title">
                    <option value="" selected disabled>-- select level --</option>
                      <option @if ($user->title =='Prof') selected @endif value="Prof">Prof</option>
                      <option @if ($user->title =='Dr')  selected @endif value="Dr">Dr</option>
                      <option @if ($user->title =='Mr')  selected @endif value="Mr">Mr</option>
                      <option @if ($user->title =='Mrs') selected @endif value="Mrs">Mrs</option>
                      <option @if ($user->title =='MS')  selected @endif value="MS">Ms</option>
                      <option @if ($user->title =='Miss') selected @endif value="Miss">Miss</option>
                    </select>
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="profile-edit-name">Last Name</label>
                    <input type="text" value="{{ $user->last_name }}" class="form-control" name="lname" placeholder="Enter your name.." value="John Parker">
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="profile-edit-name">First Name</label>
                    <input type="text" value="{{ $user->first_name }}" class="form-control" name="fname" placeholder="Enter your first name.." value="John Parker">
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="profile-edit-name">Middle Name</label>
                    <input type="text" value="{{ $user->middle_name }}" class="form-control" name="mname" placeholder="Enter your middle name.." value="John Parker">
                  </div>
                  <div class="mb-4">
                    <label class="form-label">My profile Picture</label>
                    <div class="mb-4">
                      <label for="profile-edit-avatar" class="form-label">Choose a profile picture</label>
                      <input class="form-control" type="file" name="profile_image" id="profile-edit-avatar">
                    </div>
                  </div>
              </div>
              <div class="col-lg-6 col-xl-6">
                <div class="mb-4">
                    <label class="form-label" for="profile-edit-username">Username</label>
                    <input type="text" value="{{ $user->username }}" class="form-control" name="username" placeholder="Enter your username.." value="john.parker">
                  </div>
                <div class="mb-4">
                    <label class="form-label" for="phone-number">Phone Number</label>
                    <input type="text" value="{{ $user->phone_number }}" class="form-control"  name="phone_number" placeholder="Enter your Phone Number.." >
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="office-email">Official Email</label>
                    <input type="text" value="{{ $user->office_email }}" class="form-control" name="office_email" placeholder="Enter your Official Email.." >
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="email">Personal Email</label>
                    <input type="email" value="{{ $user->personal_email }}" class="form-control" name="personal_email" placeholder="Enter your Personal email.." >
                  </div>
                  <div class="mb-4">
                    <label class="form-label">Gender</label>
                    <div class="space-x-2">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="radio1" name="gender" @if ($user->gender=='F') checked @endif value="F" >
                        <label class="form-check-label" for="radio1">Female</label>
                      </div>
                      <div class="form-check form-check-inline">
                         <input class="form-check-input" type="radio" id="radio2" name="gender" @if ($user->gender=='M') checked @endif value="M">
                         <label class="form-check-label" for="radio2">Male</label>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            <div class="mb-4 d-flex justify-content-center">
                <button type="submit" class="btn btn-alt-success col-md-7">Update Profile </button>
            </div>
          </form>
        </div>
      </div>
      <!-- END User Profile -->

      <!-- Change Password -->
      <div class="block block-rounded">
        <div class="block-header block-header-default">
          <h3 class="block-title">Change Password</h3>
        </div>
        <div class="block-content">
          <form action="{{ route('lecturer.changePassword', $user->id) }}" method="POST" >
            @csrf
            <div class="row push">
              <div class="col-lg-4">
              </div>
              <div class="col-lg-8 col-xl-5">
                <div class="row mb-4">
                  <div class="col-12">
                    <label class="form-label" for="one-profile-edit-password-new">New Password</label>
                    <input type="password" class="form-control"  name="password">
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col-12">
                    <label class="form-label" for="one-profile-edit-password-new-confirm">Confirm New Password</label>
                    <input type="password" class="form-control"  name="password_confirmation">
                  </div>
                </div>
                <div class="mb-4">
                  <button type="submit" class="btn btn-alt-primary">
                    Update
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- END Change Password -->
    </div>
   
@endsection