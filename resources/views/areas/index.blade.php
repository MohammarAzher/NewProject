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
        Areas
      </li>
    </ol>
    <!-- Breadcrumb ends -->

    <!-- Sales stats starts -->
    <div class="ms-auto d-lg-flex d-none flex-row">
        {{-- @if(auth()->user()->can('Create Areas')) --}}
        <button class="btn btn-primary" id="create" data-bs-toggle="modal" data-bs-target="#areaModel">Create</button>
        {{-- @endif --}}
    </div>
    <!-- Sales stats ends -->

  </div>
  <!-- App Hero header ends -->


      <!-- Modal -->
      <div class="modal fade" id="areaModel" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="areaModelLabel">
                Create Area
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="ajaxForm" action="{{route('area.store')}}" method="post">
            @csrf
            <input type="hidden" name="edit_id" value="" id="edit_id">
            <div class="modal-body">
                <div class="col-12 mt-2">
                    <label for="">Area Name</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Close
              </button>
              <button type="submit" class="btn btn-primary" >
                Save changes
              </button>
            </div>
            </form>
          </div>
        </div>
      </div>

  <!-- App body starts -->
  <div class="app-body">
    <div class="row gx-3">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header" style="padding-bottom: 0">
              <h5 class="card-title">Areas</h5>
            </div>
            <div class="card-body" style="padding-top: 0px">
              <div class="table-outer">
                <div class="table-responsive">
                  <table class="table  m-0">
                    <thead>
                      <tr>
                        <th>S#</th>
                        <th>Name</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($areas as $area)
                        <tr >
                            <td>{{$loop->index+1}}</td>
                            <td>{{$area->name}}</td>
                            <td>
                                <a href="javaScript:void();" data-data="{{$area}}" id="edit_area" class="btn btn-outline-info btn-sm" >
                                    <i class="ri-edit-box-line"></i>
                                </a>
                                {{-- <a href="javaScript:void();" data-url="{{route('area.destroy',$area->id)}}" data-msg="" onclick="ajaxRequest(this)" class="btn btn-outline-danger btn-sm">
                                    <i class="ri-delete-bin-line"></i>
                                </a> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                  {{$areas->links()}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection
@section('JScript')
<script>
   $(document).on('click','#edit_area',function(){
        var data = $(this).data('data');
        $('#areaModelLabel').html('Edit Area');
        $('#edit_id').val(data.id);
        $('#name').val(data.name);

         $('#areaModel').modal('show');
    });
    $(document).on('click','#create',function(){
        document.getElementsByClassName('ajaxForm')[0].reset();
        $('#edit_id').val(null);
        $('#areaModelLabel').html('Create Area');
    });
</script>
@endsection
