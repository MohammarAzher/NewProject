@extends('layouts.main')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
label{
    margin-bottom: 1%;
    font-weight: 600;
}
.select2{
    display: block;
    width: 100% !important;
    /* padding: .375rem .75rem; */
    font-size: 0.9rem;
    font-weight: 400;
    line-height: 1.5;
    color: #0f1115;
    appearance: none;
    background-color: var(--bs-body-bg);
    background-clip: padding-box;
    border: var(--bs-border-width) solid #cdd6dc;
    border-radius: var(--bs-border-radius);
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
</style>
@endsection
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
        @if(!isset($user))Create User @else Update User @endif
      </li>
    </ol>
    <!-- Breadcrumb ends -->

    <!-- Sales stats starts -->
    <div class="ms-auto d-lg-flex d-none flex-row">
    </div>
    <!-- Sales stats ends -->

  </div>
  <!-- App Hero header ends -->




  <!-- App body starts -->
  <div class="app-body">
    <!-- Row starts -->
    <div class="row gx-3">
        <div class="col-sm-12">
          <div class="card">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="card">
                          <div class="card-body">
                              {{-- <h5 class="card-title">@if(!isset($user))Create User @else Update User @endif</h5> --}}
                              <form action="{{route('user.store')}}" class="ajaxForm row">
                                  @csrf
                                  <input type="hidden" name="edit_id" value="{{$user->id ?? ''}}">


                                    <div class="col-md-6 py-2">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="name" value="{{$user->name ?? ''}}">
                                    </div>
                                    <div class="col-md-6 py-2">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" value="{{$user->email ?? ''}}">
                                    </div>
                                    <div class="col-md-6  py-2">
                                        <label>Code</label>
                                        <input type="text" class="form-control" name="code" value="{{$user->code ?? ''}}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                    </div>
                                    <div class="col-md-6  py-2">
                                        <label>Cnic</label>
                                        <input type="text" class="form-control" name="cnic" value="{{$user->cnic ?? ''}}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                    </div>
                                    <div class="col-md-6  py-2">
                                        <label>Mobile</label>
                                        <input type="text" class="form-control" name="mobile" value="{{$user->mobile ?? ''}}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                    </div>

                                    <div class="col-md-6  py-2">
                                        <label>Joining Date</label>
                                        <input type="text" class="form-control" name="joining_date" value="{{$user->joining_date ?? ''}}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                    </div>
                                    <div class="col-md-6 py-2">
                                        <label >Designation</label>
                                        <select name="designation" id="designation" class="form-control">
                                            <option value="supervisor" {{ isset($user) && $user->designation == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                            <option value="recovery-officer" {{ isset($user) && $user->designation == 'recovery-officer' ? 'selected' : '' }}>Recovery Officer</option>
                                            <option value="lineman" {{ isset($user) && $user->designation == 'lineman' ? 'selected' : '' }}>Lineman</option>
                                            <option value="karkun" {{ isset($user) && $user->designation == 'karkun' ? 'selected' : '' }}>Karkun</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 py-2">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" value="12345678">
                                    </div>
                                    <div class="col-md-6 py-2">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="c_password" value="12345678" >
                                    </div>

                                    {{-- <div class="col-md-6 py-2">
                                        <label>IBC</label>
                                        <select class="js-example-basic-multiple"  name="area_id[]" id="area_id[]" class="form-control" multiple>
                                            <option value="">Please Select IBC</option>
                                            @foreach ($areas as $area)
                                                <option value="{{$area->id}}" >{{$area->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 py-2">
                                        <label >Role</label>
                                        <select name="role" id="role" class="form-control">
                                            <option value="">Please Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{$role->name}}" >{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}

                                    <div class="col-md-6 py-2">
                                    <label>IBC</label>
                                    <select class="js-example-basic-multiple form-control" name="area_id[]" id="area_id" multiple>
                                        <option value="">Please Select IBC</option>
                                        @php
                                            // Edit ke liye already assigned areas ka array
                                            $selectedAreas = old('area_id', isset($user) ? $user->areas->pluck('id')->toArray() : []);
                                        @endphp
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}" {{ in_array($area->id, $selectedAreas) ? 'selected' : '' }}>
                                                {{ $area->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 py-2">
                                    <label>Role</label>
                                    <select name="role" id="role" class="form-control">
                                        <option value="">Please Select Role</option>
                                        @php
                                            // Edit ke liye user ka first role
                                            $selectedRole = old('role', isset($user) && $user->roles->isNotEmpty() ? $user->roles->first()->name : '');
                                        @endphp
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ $selectedRole == $role->name ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                    {{-- @if(isset($user) && $user->image != null && $user->image != '' )
                                    <div class="col-md-6 py-2">
                                        <label></label>
                                        <img src="{{asset($user->image)}}" width="80px" height="80px" alt="">
                                    </div>
                                    @endif
                                    <div class="col-md-6 py-2">
                                        @if(!isset($user))<label>Image</label>@endif
                                        <input type="file" class="form-control" name="image">
                                    </div> --}}


                                    <div class="col-md-10 " style="margin-top: 1%" id="submit-div">
                                        <button type="submit" class="btn btn-success" name="" id="">Save</button>
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
  </div>
@endsection
@section('JScript')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $('.js-example-basic-multiple').select2();
    });


</script>
@endsection
