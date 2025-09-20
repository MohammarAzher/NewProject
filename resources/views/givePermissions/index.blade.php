@extends('layouts.main')
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
        Give Permissions to Role
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
    <div class="row gx-3">
        <div class="col-xl-12 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="col-12 p-3">

                    <table class="table">
                       <thead>
                            <th>Model</th>
                            <th>Permissions</th>
                       </thead>
                       <tbody>
                            <form action="{{route('role.applyPermissions')}}" class="ajaxForm">
                            <input type="hidden" name="role_id" value="{{$role_id}}">
                            @foreach ($groupedPermissions as $model => $permissions)
                               <tr>
                                    <td>
                                        <span style="height: 30px; padding: 3px 15px 0px 15px; line-height: 23px;" class="badge bg-primary-subtle text-primary text-uppercase ">
                                            {{ $model }}
                                        </span>
                                    </td>
                                    <td>
                                        @foreach ($permissions as $permission)
                                        <div class="form-check form-check-inline" style="width:20%">
                                            <input {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}  class="form-check-input" type="checkbox" value="{{$permission->name}}" name="permissions[]" >
                                            <label class="form-check-label" for="flexCheckDefault">{{$permission->name}}</label>
                                        </div>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="right">
                        <input type="submit" class="btn btn-primary" name="" id="">
                    </div>
                    </form>


                </div>
            </div>
          </div>
    </div>
  </div>
@endsection
@section('JScript')

@endsection
