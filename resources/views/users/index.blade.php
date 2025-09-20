@extends('layouts.main')
@section('css')
<link rel="stylesheet" href="{{asset('')}}assets/plugins/datatables/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('')}}assets/plugins/datatables/buttons.bootstrap4.min.css">

<style>

  table {
    border-top: #cdd6dc !important;
  }
table.dataTable {
    border-collapse: collapse !important;

}

    tr{
        border-collapse: collapse !important;
        border-color: inherit !important;
        border-style: solid !important;
        border-width: 1px !important;
    }

    label {
        text-transform: uppercase; font-weight: 500; margin-left: 1%;
    }
   .dataTables_length {
        float: left !important;
        width: 150px !important;
        padding-top: .85em !important;
    }
    .dataTables_info{
        float: left !important;
        width: 200px !important;
        /* padding-top: 1.1em !important; */

    }
    .dataTables_paginate{
        /* padding-top: .85em !important; */
    }
    .dt-buttons
    {
        width: 400px !important;
        float: left !important;
        padding-bottom: .85em !important;
    }
    .dataTables_processing{
        z-index: 99 !important;
    }

    .select2-container .select2-search--inline .select2-search__field
    {
        height: 22px !important;
    }

    .table tr:last-child td {
        border: 1px solid #cdd6dc !important;
    }
    #users-table_length{
        padding-top: 0% !important;
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
        Users
      </li>
    </ol>
    <!-- Breadcrumb ends -->

    <!-- Sales stats starts -->
    <div class="ms-auto d-lg-flex d-none flex-row">
            <a href="{{route('user.create')}}"><button class="btn btn-primary" >Create</button></a>
    </div>
    <!-- Sales stats ends -->

  </div>
  <!-- App Hero header ends -->




  <!-- App body starts -->
  <div class="app-body">
    <div class="row gx-3">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header" style="padding-bottom: 0">
              {{-- <h5 class="card-title">Users</h5> --}}
            </div>
            <div class="card-body" style="padding-top: 0px">
                <div class="table-responsive">
                    <table id="users-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                {{-- <th>ID</th> --}}
                                <th>Name</th>
                                <th>Email</th>
                                <th>Code</th>
                                <th>Cnic</th>
                                <th>Mobile</th>
                                <th>Joining Date</th>
                                <th>Role</th>
                                <th>Areas</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection
@section('JScript')
<script src="{{asset('')}}assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/3.1.3/jszip.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/buttons.colVis.min.js"></script>
<script>
$(function () {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('users') }}',
        columns: [
            // { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'code', name: 'code' },
            { data: 'cnic', name: 'cnic' },
            { data: 'mobile', name: 'mobile' },
            { data: 'joining_date', name: 'joining_date' },
            { data: 'role', name: 'role', orderable: false, searchable: false },
            { data: 'areas', name: 'areas', orderable: false, searchable: false },
            { data: 'status',
                render: function(data, type, full, meta) {
                    return '<div class="form-check form-switch" style="margin: 0;min-height: 0;">' +
                        '<input class="form-check-input" type="checkbox" role="switch" id="' + full.id + '"' + (data == 1 ? ' checked' : '') + '>' +
                    '</div>';
                }
            },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});

$('#users-table').on('click', '.form-check-input', function(e) {
    e.preventDefault();
    var checkbox = $(this);
        var checkboxId = $(this).attr('id');
        var isChecked = checkbox.prop('checked');
    Swal.fire({
        title: "Are you sure?",
        text: "You want change user active status!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Confirm it!"
    }).then(function (t) {
        if (t.value){
            var id = checkboxId;
            var url = '{{route("user.status.update")}}'; // Construct the URL dynamically
            $.ajax({
                url: url,
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { id: id },
                dataType: "json",
                beforeSend: function() {
                    $("#loading-wrapper").fadeIn();
                },
                complete: function () {
                    $("#loading-wrapper").fadeOut();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    ajaxErrorHandling(jqXHR, errorThrown);
                },
                success: function (data) {
                    if(data == 1){
                        checkbox.prop('checked', true);
                    }
                    else{
                        checkbox.prop('checked', false);
                    }
                }
            });
        }
    });
});
</script>
@endsection

