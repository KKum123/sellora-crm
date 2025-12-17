<!DOCTYPE html>
<html lang="en">

<head>
  <!--Title-->
  <title>

    @if(session()->has('admin'))
    Super Admin
  @elseif(session()->has('branch'))
  Branch
@elseif(session()->has('team'))
  Team
@endif
  </title>

  <!-- Meta -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="keywords" content="">
  <meta name="description" content="">

  <!-- MOBILE SPECIFIC -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- FAVICONS ICON -->
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
  <link href="{{ url('admin') }}/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
  <link href="{{ url('admin') }}/vendor/swiper/css/swiper-bundle.min.css" rel="stylesheet">
  <link href="{{ url('admin') }}/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="{{ url('admin') }}/vendor/datatables/css/buttons.dataTables.min.css" rel="stylesheet">
  <link href="{{ url('admin') }}/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
  <!-- Style css -->
  <link class="main-css" href="{{ url('admin') }}/css/style.css" rel="stylesheet">
  <link class="main-css" href="{{ url('admin') }}/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ url('admin') }}/css/icomoon.css">
  <link rel="stylesheet" href="{{ url('admin') }}/css/remixicon.css">
  <style>
    .apexcharts-legend-series:nth-child(2) {
      opacity: 0;
    }


    .loader-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      /* background: rgba(103, 97, 97, 0.5);  */
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
      /* Ensures it appears above other content */
    }

    /* Existing Loading Spinner */
    .loadingspinner {
      --square: 26px;
      --offset: 30px;

      --duration: 2.4s;
      --delay: 0.2s;
      --timing-function: ease-in-out;

      --in-duration: 0.4s;
      --in-delay: 0.1s;
      --in-timing-function: ease-out;

      width: calc(3 * var(--offset) + var(--square));
      height: calc(2 * var(--offset) + var(--square));
      position: relative;
    }

    .loadingspinner div {
      display: inline-block;
      background: darkorange;
      /*background: var(--text-color);*/
      /*box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);*/
      border: none;
      border-radius: 2px;
      width: var(--square);
      height: var(--square);
      position: absolute;
      padding: 0px;
      margin: 0px;
      font-size: 6pt;
      color: black;
    }

    .loadingspinner #square1 {
      left: calc(0 * var(--offset));
      top: calc(0 * var(--offset));
      animation: square1 var(--duration) var(--delay) var(--timing-function) infinite,
        squarefadein var(--in-duration) calc(1 * var(--in-delay)) var(--in-timing-function) both;
    }

    .loadingspinner #square2 {
      left: calc(0 * var(--offset));
      top: calc(1 * var(--offset));
      animation: square2 var(--duration) var(--delay) var(--timing-function) infinite,
        squarefadein var(--in-duration) calc(1 * var(--in-delay)) var(--in-timing-function) both;
    }

    .loadingspinner #square3 {
      left: calc(1 * var(--offset));
      top: calc(1 * var(--offset));
      animation: square3 var(--duration) var(--delay) var(--timing-function) infinite,
        squarefadein var(--in-duration) calc(2 * var(--in-delay)) var(--in-timing-function) both;
    }

    .loadingspinner #square4 {
      left: calc(2 * var(--offset));
      top: calc(1 * var(--offset));
      animation: square4 var(--duration) var(--delay) var(--timing-function) infinite,
        squarefadein var(--in-duration) calc(3 * var(--in-delay)) var(--in-timing-function) both;
    }

    .loadingspinner #square5 {
      left: calc(3 * var(--offset));
      top: calc(1 * var(--offset));
      animation: square5 var(--duration) var(--delay) var(--timing-function) infinite,
        squarefadein var(--in-duration) calc(4 * var(--in-delay)) var(--in-timing-function) both;
    }

    @keyframes square1 {
      0% {
        left: calc(0 * var(--offset));
        top: calc(0 * var(--offset));
      }

      8.333% {
        left: calc(0 * var(--offset));
        top: calc(1 * var(--offset));
      }

      100% {
        left: calc(0 * var(--offset));
        top: calc(1 * var(--offset));
      }
    }

    @keyframes square2 {
      0% {
        left: calc(0 * var(--offset));
        top: calc(1 * var(--offset));
      }

      8.333% {
        left: calc(0 * var(--offset));
        top: calc(2 * var(--offset));
      }

      16.67% {
        left: calc(1 * var(--offset));
        top: calc(2 * var(--offset));
      }

      25.00% {
        left: calc(1 * var(--offset));
        top: calc(1 * var(--offset));
      }

      83.33% {
        left: calc(1 * var(--offset));
        top: calc(1 * var(--offset));
      }

      91.67% {
        left: calc(1 * var(--offset));
        top: calc(0 * var(--offset));
      }

      100% {
        left: calc(0 * var(--offset));
        top: calc(0 * var(--offset));
      }
    }

    @keyframes square3 {

      0%,
      100% {
        left: calc(1 * var(--offset));
        top: calc(1 * var(--offset));
      }

      16.67% {
        left: calc(1 * var(--offset));
        top: calc(1 * var(--offset));
      }

      25.00% {
        left: calc(1 * var(--offset));
        top: calc(0 * var(--offset));
      }

      33.33% {
        left: calc(2 * var(--offset));
        top: calc(0 * var(--offset));
      }

      41.67% {
        left: calc(2 * var(--offset));
        top: calc(1 * var(--offset));
      }

      66.67% {
        left: calc(2 * var(--offset));
        top: calc(1 * var(--offset));
      }

      75.00% {
        left: calc(2 * var(--offset));
        top: calc(2 * var(--offset));
      }

      83.33% {
        left: calc(1 * var(--offset));
        top: calc(2 * var(--offset));
      }

      91.67% {
        left: calc(1 * var(--offset));
        top: calc(1 * var(--offset));
      }
    }

    @keyframes square4 {
      0% {
        left: calc(2 * var(--offset));
        top: calc(1 * var(--offset));
      }

      33.33% {
        left: calc(2 * var(--offset));
        top: calc(1 * var(--offset));
      }

      41.67% {
        left: calc(2 * var(--offset));
        top: calc(2 * var(--offset));
      }

      50.00% {
        left: calc(3 * var(--offset));
        top: calc(2 * var(--offset));
      }

      58.33% {
        left: calc(3 * var(--offset));
        top: calc(1 * var(--offset));
      }

      100% {
        left: calc(3 * var(--offset));
        top: calc(1 * var(--offset));
      }
    }

    @keyframes square5 {
      0% {
        left: calc(3 * var(--offset));
        top: calc(1 * var(--offset));
      }

      50.00% {
        left: calc(3 * var(--offset));
        top: calc(1 * var(--offset));
      }

      58.33% {
        left: calc(3 * var(--offset));
        top: calc(0 * var(--offset));
      }

      66.67% {
        left: calc(2 * var(--offset));
        top: calc(0 * var(--offset));
      }

      75.00% {
        left: calc(2 * var(--offset));
        top: calc(1 * var(--offset));
      }

      100% {
        left: calc(2 * var(--offset));
        top: calc(1 * var(--offset));
      }
    }

    @keyframes squarefadein {
      0% {
        transform: scale(0.75);
        opacity: 0;
      }

      100% {
        transform: scale(1);
        opacity: 1;
      }
    }
  </style>
  <style>
    .modal-open .deznav {
      z-index: 0 !important;
    }

    .modal-backdrop.show {
      z-index: -5 !important;
      background: transparent;
    }

    .modal-body .table-responsive table {
      min-width: 100% !important;
    }

    .modal-body .table-responsive {
      height: auto !important;
      max-height: 400px;
    }

    .modal.show:before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.3);
    }
  </style>
</head>

<body>

  <div id="main-wrapper">
    <div class="nav-header">
      @if(session()->has('admin'))
      <a href="{{ route('admin.dashboard') }}" class="brand-logo">
  @elseif(session()->has('branch'))
  <a href="{{ route('branch.dashboard') }}" class="brand-logo">
  @elseif(session()->has('team'))
    <a href="{{ route('team.dashboard') }}" class="brand-logo">
@endif
            <span class="logo-abbr"> <img src="{{ url('main') }}/assets/images/logo-01.png" alt=""> </span> <span
              class="brand-title"> <img src="{{ url('main') }}/assets/images/logo-01.png" alt=""> </span> </a>


          <div class="nav-control">
            <div class="hamburger"> <i class="ri-menu-3-line"></i> </div>
          </div>
    </div>

    @include('admin.layouts.header')

    @include('admin.layouts.sidebar')
    <div class="loader-overlay" id="spiner">
      <div class="loadingspinner">
        <div id="square1"></div>
        <div id="square2"></div>
        <div id="square3"></div>
        <div id="square4"></div>
        <div id="square5"></div>
      </div>
    </div>
    @yield('content')
    <!--**********************************
                    Content body end
                ***********************************-->
    <!--**********************************
                    Footer start
                ***********************************-->
    <div class="footer">
      <div class="copyright">
        <p>Copyright © 2024 Sellora | All Rights Reserved.</p>
      </div>
    </div>
    <!--**********************************
                   Footer end
               ***********************************-->

    <!--**********************************
                  Support ticket button start
               ***********************************-->

    <!--**********************************
                  Support ticket button end
               ***********************************-->

  </div>
  @include('admin.layouts.script')

  @yield('javascript')