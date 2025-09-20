@extends('dashboard.layouts.main')
{{-- Css work here --}}
@section('css')
<style>
    .form-group
    {margin-bottom: 1%;}
</style>
@endsection

{{-- main content --}}
@section('content')
   <!-- App hero header starts -->
 <div class="app-hero-header d-flex align-items-center">
    <!-- Breadcrumb starts -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <i class="ri-home-8-line lh-1 pe-3 me-3 border-end"></i>
        <a href="{{route('login')}}">Home</a>
      </li>
      <li class="breadcrumb-item text-primary" aria-current="page">
       Profile
      </li>
    </ol>
    <!-- Breadcrumb ends -->
  </div>
  <!-- App Hero header ends -->
  <!-- App body starts -->
  <div class="app-body">

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content p-3">
                        <div class="" id="edit">
                            <form class="ajaxForm" method="post" action="{{route('profile.update')}}">
                                @csrf
                                <input type="hidden" name="edit_id" value="{{ auth()->user()->id }}">
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label form-control-label">Username</label>
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="username"
                                            value="{{auth()->user()->name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label form-control-label">Email</label>
                                    <div class="col-lg-12">
                                        <input class="form-control" type="email" name="email"
                                            value="{{auth()->user()->email}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label form-control-label"></label>
                                    <div class="col-lg-12">
                                        <img src="{{asset(auth()->user()->image)}}" width="80px" alt="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label form-control-label">Image</label>
                                    <div class="col-lg-12">
                                        <input class="form-control" type="file" name="profile_image">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label form-control-label"></label>
                                    <div class="col-lg-12">
                                        <input type="submit" class="btn btn-primary" value="Save Changes">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<br><div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content p-3">
                        <div class="" id="edit">
                            <form class="ajaxForm" method="post" action="">
                                @csrf
                                <input type="hidden" name="edit_id" value="{{ auth()->user()->id }}">
                                <div class="form-group row">
                                <label class="col-lg-12 col-form-label form-control-label">Old Password</label>
                                <div class="col-lg-12">
                                    <input class="form-control" type="password" name="old_password" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label form-control-label">New password</label>
                                <div class="col-lg-12">
                                    <input class="form-control" type="password" name="new_password" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label form-control-label">Confirm password</label>
                                <div class="col-lg-12">
                                    <input class="form-control" type="password" name="c_password" >
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label form-control-label"></label>
                                    <div class="col-lg-12">
                                        <input type="submit" class="btn btn-primary" value="Save Changes">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
  </div>
@endsection

{{-- javascript work here --}}
@section('JScript')

@endsection
