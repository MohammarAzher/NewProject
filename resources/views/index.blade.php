@extends('layouts.main')
@section('css')
<style>
.feed-item::after{
content: unset !important;
}
.feed-item{
    border: unset !important;
    padding-left: 0px !important;
    margin-top: 0px !important;

}

/* .bg-2{
    background: url({{asset('assets/cover.png')}}) !important;
    background-position: center !important;
    height: 40vh !important;
    background-size: 100% 100% !important;
} */
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
        Dashboard
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
    <div class="col-xl-2 col-sm-6 col-12">
        <div class="card mb-3">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center">
              <div class="icon-box md rounded-5 bg-primary mb-3">
                <i class="ri-walk-line fs-4 lh-1"></i>
              </div>
              <h6>Total Students</h6>
              <h2 class="text-primary m-0"></h2>
            </div>
          </div>
        </div>
      </div>

    <div class="col-xl-2 col-sm-6 col-12">
      <div class="card mb-3">
        <div class="card-body">
          <div class="d-flex flex-column align-items-center">
            <div class="icon-box md rounded-5 bg-primary mb-3">
              <i class="ri-stethoscope-line fs-4 lh-1"></i>
            </div>
            <h6>Present Students</h6>
            <h2 class="text-primary m-0"></h2>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-sm-6 col-12">
        <div class="card mb-3">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center">
              <div class="icon-box md rounded-5 bg-primary mb-3">
                <i class="ri-verified-badge-line fs-4 lh-1"></i>
              </div>
              <h6>Absent Students</h6>
              <h2 class="text-primary m-0"></h2>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-2 col-sm-6 col-12">
        <div class="card mb-3">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center">
              <div class="icon-box md rounded-5 bg-primary mb-3">
                <i class="ri-walk-line fs-4 lh-1"></i>
              </div>
              <h6>Total Teachers</h6>
              <h2 class="text-primary m-0"></h2>
            </div>
          </div>
        </div>
      </div>

    <div class="col-xl-2 col-sm-6 col-12">
      <div class="card mb-3">
        <div class="card-body">
          <div class="d-flex flex-column align-items-center">
            <div class="icon-box md rounded-5 bg-primary mb-3">
              <i class="ri-stethoscope-line fs-4 lh-1"></i>
            </div>
            <h6>Present Teachers</h6>
            <h2 class="text-primary m-0"></h2>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-sm-6 col-12">
        <div class="card mb-3">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center">
              <div class="icon-box md rounded-5 bg-primary mb-3">
                <i class="ri-verified-badge-line fs-4 lh-1"></i>
              </div>
              <h6>Absent Teachers</h6>
              <h2 class="text-primary m-0"></h2>
            </div>
          </div>
        </div>
      </div>




      <div class="col-xl-12 col-sm-6">
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">NOTICE BOARD</h4>
              </div>
        </div>
      </div>




  </div>
  <!-- Row ends -->

  </div>

@endsection
