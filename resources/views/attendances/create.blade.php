@extends('dashboard.layouts.main')
@section('css')
<style>

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
        Attendances
      </li>
    </ol>
    <!-- Breadcrumb ends -->

    {{-- <!-- Sales stats starts -->
    <div class="ms-auto d-lg-flex d-none flex-row">
       <a href="{{route('course.create')}}"><button class="btn btn-primary" >Create</button></a>
    </div>
    <!-- Sales stats ends --> --}}

  </div>
  <!-- App Hero header ends -->



  <!-- App body starts -->
  <div class="app-body">
    <div class="row gx-3">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header" style="padding-bottom: 0">
              <h5 class="card-title">Attendances</h5>
            </div>
            <div class="card-body" style="padding-top: 0px">
                <form action="{{route('attendances.fetch')}}" class="ajaxFodrm row">
                    @csrf
                    @if(Auth::user()->hasRole('super-admin'))
                    <div class="col-xxl-3 col-lg-3 col-sm-6">
                        <label>Branches</label>
                        <select name="branch_id" id="" class="form-control">
                          <option value="">Please Select Branch</option>
                          @foreach ($branches as $branch)
                              <option value="{{$branch->id}}" >{{$branch->name}}</option>
                          @endforeach
                        </select>
                    </div>
                    @else
                    <input type="hidden" name="branch_id" value="{{Auth::user()->branch_id}}">
                    @endif

                    <div class="col-xxl-3 col-lg-3 col-sm-6">
                      <label>School Class <span class="text-danger">*</span></label>
                      <select name="class_id" id="classes" class="form-control">
                        <option value="">Please Select Class</option>
                        @foreach ($classes as $class)
                            <option value="{{$class->id}}" >{{$class->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-xxl-3 col-lg-3 col-sm-6">
                      <label>Sections <span class="text-danger">*</span></label>
                      <select name="section_id" id="sections" class="form-control">
                        <option value="">Select Class Before</option>
                      </select>
                    </div>
                    <div class="col-md-3 ">
                        <label>Course Name <span class="text-danger">*</span></label>
                        <input type="Date" class="form-control" name="date" value="">
                    </div>
                    @if(Auth::user()->hasRole('super-admin'))
                        <div class="col-md-10 "></div>
                    @endif
                    <div class="col-md-2 ">
                        <label></label>
                        <input type="submit" value="Search" class="form-control     btn btn-primary" >
                    </div>
                </form>

                <div class="table-outer mt-3">
                    <div class="table-responsive">
                        <form class="ajaxForm" action="{{route('attendance.store')}}" method="post">
                            @csrf
                            <div id="hidden_fields"></div>
                      <table class="table  m-0" id="students">
                        <thead>
                          <tr>
                            <th>S#</th>
                            <th>Student Name</th>
                            <th>Father Name</th>
                            <th>GR.No</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>

                        </tbody>
                      </table>



                    </div>
                  </div>
                  <div class="row mt-2 mb-2">
                    <div class="col-md-10 " ></div>
                    <div class="col-md-2 ">
                        <input type="submit" name="" class="form-control     btn btn-success">
                    </div>
                </div>
            </form>
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection
@section('JScript')
<script>
  $('#classes').change(function() {
    var classId = $(this).val();
    // Clear previous sections
    $('#sections').empty().append('<option value="">Please Select Section</option>');
    if (classId) {
        $.ajax({
            url: '{{ route('get.sections', '') }}/' + classId, // Adjust the URL according to your route
            method: 'GET',
            success: function(data) {
                // Assuming 'data' is an array of sections
                $.each(data, function(index, section) {
                    $('#sections').append('<option value="' + section.id + '">' + section.name + '</option>');
                });
            },
            error: function(xhr) {
                console.error(xhr);
                // Optionally handle errors here
            }
        });
    }
});

$('.ajaxFodrm').submit(function(e) {
    e.preventDefault();
    $('.ajaxForm button[type="submit"]').prop('disabled', true);
    var url = $(this).attr('action');
    var formData = new FormData(this);
    my_ajax(url, formData, 'post', function(res) {
        if(res.status == 200){
        var tableBody = $('#students tbody'); // Get the tbody element of the table
        tableBody.empty(); // Clear existing rows
        // console.log(res);
        // Loop through the response data and create table rows
        $('#hidden_fields').append(`
            <input type="hidden" value="${res.attendance_date}" name="date">
            <input type="hidden" value="${res.class_id}" name="class_id">
            <input type="hidden" value="${res.section_id}" name="section_id">
            <input type="hidden" value="${res.branch_id}" name="branch_id">
        `);

        $.each(res.students, function(index, student) {

            var row = `<tr>
                <input type="hidden" value="${student.id}" name="student_id[${index}]">

                <td>${index}</td>
                <td>${student.full_name}</td>
                <td>${student.father_name}</td>
                <td>${student.gr_no}</td>
                <td>
                    <div class="m-0">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status[${index}]" id="" value="1" checked="">
                        <label class="form-check-label" >Present</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status[${index}]" id="" value="0">
                        <label class="form-check-label" >Absent</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status[${index}]" id="" value="2">
                        <label class="form-check-label" >Leave</label>
                    </div>
                    </div>
                </td>
                </tr>`;
            tableBody.append(row); // Append the row to the table body
        });
        }

    }, true);
    $('.ajaxForm button[type="submit"]').prop('disabled', true);
});
</script>
@endsection

