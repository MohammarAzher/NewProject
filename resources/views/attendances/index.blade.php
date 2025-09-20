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

    <!-- Sales stats starts -->
    <div class="ms-auto d-lg-flex d-none flex-row">
       <a href="{{route('attendances.create')}}"><button class="btn btn-primary" >Add Attendance</button></a>
    </div>
    <!-- Sales stats ends -->

  </div>
  <!-- App Hero header ends -->



  <!-- App body starts -->
  <div class="app-body">
    <!-- Row start -->
    <div class="row gx-3">
        <div class="col-sm-12">
          <!-- Card start -->
          <div class="card">
            <div class="card-header">

              <!-- Row starts -->
              <div class="row gx-3 justify-content-end align-items-center">
                <div class="col-xl-4">
                  <div class="d-flex flex-wrap gap-3">

                        <div>
                            <i class="ri-checkbox-circle-fill text-success"></i>
                            <span class="fw-semibold ps-1">Present</span>
                        </div>
                        <div>
                            <i class="ri-checkbox-circle-fill text-danger"></i>
                            <span class="fw-semibold ps-1">Absent</span>
                        </div>
                        <div>
                            <i class="ri-checkbox-circle-fill text-primary"></i>
                            <span class="fw-semibold ps-1">Leave</span>
                          </div>
                        <div>
                          <i class="ri-checkbox-circle-fill text-secondary"></i>
                          <span class="fw-semibold ps-1">Weekend</span>
                        </div>
                  </div>
                </div>

                    <div class="col-xl-3">
                        <form class="row" action="" method="get">
                    <select name="classes" id="classes" class="form-select" name="class_id" onchange="document.forms[0].submit();">
                        <option value="">Please Select Class</option>
                        @foreach ($classes as $class)
                            <option {{ (request()->query('classes') == $class->id) ? 'selected':'' }} value="{{$class->id}}">{{$class->name}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="col-xl-3">
                        <select name="sections" id="sections" class="form-select" name="section_id" onchange="document.forms[0].submit();">
                            <option value="">Please Select Section</option>
                            @if(request()->query('classes'))
                                @php
                                    $sections = \App\Models\Section::where('class_id', request()->query('classes'))->get();
                                @endphp
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" {{ request()->query('sections') == $section->id ? 'selected' : '' }}>
                                        {{ $section->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-xl-2">

                        <select name="Month" id="Month" class="form-select"  onchange="document.forms[0].submit();">
                            <option value="">Select Date</option>
                            @for ($month = 1; $month <= 12; $month++)
                                <option value="{{ date('Y-m', strtotime("2024-$month-01")) }}">
                                    {{ date('F', strtotime("2024-$month-01")) }} 2024
                                </option>
                            @endfor
                        </select>
                    </div>
                </form>
              </div>
              <!-- Row ends -->

            </div>
            <div class="card-body">

              <!-- Table start -->
              <div class="table-responsive">
                <table id="attandance" class="table truncate m-0 align-middle">
                  <thead>
                    <tr>
                      <th>Students</th>
                      @foreach ($daysName as $days)
                      <th>{{ $days[0] }}</th>
                      @endforeach
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>&nbsp;</td>
                      @foreach ($daysName as $index => $days)
                        <th>{{ $index+1 }}</th>
                      @endforeach
                      {{-- <td class="small">Leaves</td> --}}
                    </tr>

                    @foreach ($attendances as $key => $value)
                    <tr>
                         <td>{{ $key }}</td>

                         @foreach ($value as $result)
                             @if($result['status'] == 1)
                             <td class="ri-checkbox-circle-fill text-success" ><span style="display: none">Present</span></td>
                             @elseif($result['status'] == 2)
                             <td class="ri-checkbox-circle-fill text-primary" ><span style="display: none">Leave</span></td>
                             @elseif($result['dayName'] == 'Sunday')
                             <td class="ri-checkbox-circle-fill text-secondary" ><span style="display: none">Sunday</span></td>
                             @else
                                <td class="ri-checkbox-circle-fill text-danger"><span style="display: none">Absent</span></td>
                                @endif
                        @endforeach

                        @endforeach
                  </tbody>
                </table>
              </div>
              <!-- Table end -->

            </div>
          </div>
          <!-- Card end -->

        </div>
      </div>
      <!-- Row end -->
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
                        <label class="form-check-label" >Absent</label>
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

