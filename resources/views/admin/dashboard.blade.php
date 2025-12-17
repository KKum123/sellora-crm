@extends('admin.layouts.master')
@section('content')
    @if(session()->has('admin'))
        @php $prefix = 'admin'; @endphp
    @elseif(session()->has('branch'))
        @php $prefix = 'branch'; @endphp
    @elseif(session()->has('team')) 
        @php $prefix = 'team'; @endphp
    @endif
    @php 
        use MongoDB\BSON\ObjectId;
    @endphp
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                @if(session()->has('admin') || session()->has('branch'))
                @else
                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header flex-wrap mb-3 ps-0">
                                    <h2 class="heading mb-0" style="font-size: 1.3rem;">Attendance </h2>
                                </div>
                                <div class="d-flex align-items-center justify-content-between" style="flex-direction: column;">
                                    <img src="{{ url('admin') }}/images/calendericon.png" alt="" style="max-height: 115px;
    margin-bottom: 10px;">

                                    <div class="total-projects ms-3">
                                        <h4 class="text-success count" style="font-size: 18px; margin-bottom: 10px; text-align: center">
                                            @if($attendance)
                                                @if($attendance->goodMoringDateTime)

                                                Coming Time: {{ date('h:i A', strtotime($attendance->goodMoringDateTime)) }}
                                             @endif
                                             @if($attendance->goodNightDateTime)
                                                   Going Time: {{ date('h:i A', strtotime($attendance->goodNightDateTime)) }}
                                              
                                                @endif
                                            @else
                                                --:--
                                            @endif


                                        </h4>

                                    </div>
                                    @if($attendance)
                                        

                                            @if($attendance->goodNightDateTime)
                                                <!-- <button class="btn btn-success">Going Time</button> -->
                                            @else
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal20067b6aba993236d3851041b62"> Good Night </button>
                                            @endif

                                        
                                    @else
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal20067b6aba993236d3851041b62">
                                            Good Morning
                                        </button>

                                    @endif  
                                    <br>
                                    </span>
                                         <a href="{{ route($prefix.'.attendanceReport') }}" style="color:green;">View Attendance</a>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif

                @if(session()->has('admin') || session()->has('branch'))

                    <!-- 1 -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header flex-wrap mb-3 ps-0">
                                    <h2 class="heading mb-0" style="font-size: 1.3rem;">SalesPulse Performance</h2>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-success-light rounded-circle">
                                                                <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.9715 29.3168C15.7197 29.3168 9.52686 30.4132 9.52686 34.8043C9.52686 39.1953 15.6804 40.331 22.9715 40.331C30.2233 40.331 36.4144 39.2328 36.4144 34.8435C36.4144 30.4543 30.2626 29.3168 22.9715 29.3168Z"
                                                                        stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.9714 23.0537C27.7304 23.0537 31.5875 19.1948 31.5875 14.4359C31.5875 9.67694 27.7304 5.81979 22.9714 5.81979C18.2125 5.81979 14.3536 9.67694 14.3536 14.4359C14.3375 19.1787 18.1696 23.0377 22.9107 23.0537H22.9714Z"
                                                                        stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg> </div>
                                                                <a href="{{ route($prefix.'.sales.salePlusReport' )}}?dashboardStatus=newLead">
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-success count">{{ $dashboard['newLead'] }}</h3>
                                                                <span>New Leads</span>
                                                            </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-primary-light rounded-circle">
                                                                <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M32.8961 26.5849C34.1612 26.5849 35.223 27.629 35.0296 28.8783C33.8947 36.2283 27.6026 41.6855 20.0138 41.6855C11.6178 41.6855 4.8125 34.8803 4.8125 26.4862C4.8125 19.5704 10.0664 13.1283 15.9816 11.6717C17.2526 11.3579 18.5553 12.252 18.5553 13.5605C18.5553 22.4263 18.8533 24.7197 20.5368 25.9671C22.2204 27.2145 24.2 26.5849 32.8961 26.5849Z"
                                                                        stroke="var(--primary)" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M41.1733 19.2019C41.2739 13.5059 34.2772 4.32428 25.7509 4.48217C25.0877 4.49402 24.5568 5.04665 24.5272 5.70783C24.3121 10.3914 24.6022 16.4605 24.764 19.2118C24.8134 20.0684 25.4864 20.7414 26.341 20.7907C29.1693 20.9526 35.4594 21.1736 40.0759 20.4749C40.7035 20.3802 41.1634 19.8355 41.1733 19.2019Z"
                                                                        stroke="var(--primary)" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                                </svg> </div>
                                                                <a href="{{ route($prefix.'.sales.salePlusReport' )}}?dashboardStatus=activeLead">
                                                                    <div class="total-projects ms-3">
                                                                        <h3 class="text-primary count">{{ $dashboard['activeLead'] }}
                                                                        </h3>
                                                                        <span>Active Leads</span>
                                                                    </div>
                                                                </a>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-purple-light rounded-circle">
                                                                <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.9717 41.0539C22.9717 41.0539 37.3567 36.6983 37.3567 24.6908C37.3567 12.6814 37.878 11.7439 36.723 10.5889C35.5699 9.43391 24.858 5.69891 22.9717 5.69891C21.0855 5.69891 10.3736 9.43391 9.21863 10.5889C8.0655 11.7439 8.58675 12.6814 8.58675 24.6908C8.58675 36.6983 22.9717 41.0539 22.9717 41.0539Z"
                                                                        stroke="#BB6BD9" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path d="M26.4945 26.4642L19.4482 19.4179" stroke="#BB6BD9"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path d="M19.4487 26.4642L26.495 19.4179" stroke="#BB6BD9"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg> </div>
                                                                <a href="{{ route($prefix.'.sales.salePlusReport' )}}?dashboardStatus=pendingLead">
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-purple count">{{ $dashboard['pendingLead'] }}
                                                                </h3>
                                                                <span>Pending Lead</span>
                                                            </div>
                                                        </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-danger-light rounded-circle">
                                                                <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M34.0396 20.974C36.6552 20.6065 38.6689 18.364 38.6746 15.6471C38.6746 12.9696 36.7227 10.7496 34.1633 10.3296"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M37.4912 27.262C40.0243 27.6407 41.7925 28.5276 41.7925 30.3557C41.7925 31.6139 40.96 32.4314 39.6137 32.9451"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.7879 28.0373C16.7616 28.0373 11.6147 28.9504 11.6147 32.5973C11.6147 36.2423 16.7297 37.1817 22.7879 37.1817C28.8141 37.1817 33.9591 36.2779 33.9591 32.6292C33.9591 28.9804 28.846 28.0373 22.7879 28.0373Z"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.7876 22.8325C26.742 22.8325 29.9483 19.6281 29.9483 15.6719C29.9483 11.7175 26.742 8.51123 22.7876 8.51123C18.8333 8.51123 15.627 11.7175 15.627 15.6719C15.612 19.6131 18.7939 22.8194 22.7351 22.8325H22.7876Z"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M11.5344 20.974C8.91691 20.6065 6.90504 18.364 6.89941 15.6471C6.89941 12.9696 8.85129 10.7496 11.4107 10.3296"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M8.0825 27.262C5.54937 27.6407 3.78125 28.5276 3.78125 30.3557C3.78125 31.6139 4.61375 32.4314 5.96 32.9451"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg> </div>
                                                                <a href="{{ route($prefix.'.sales.salePlusReport' )}}?dashboardStatus=salseCloseLead">
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-danger count">{{ $dashboard['salseClose'] }}
                                                                </h3>
                                                                <span>Sales Closed</span>
                                                            </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-purple-light rounded-circle">
                                                                <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.9717 41.0539C22.9717 41.0539 37.3567 36.6983 37.3567 24.6908C37.3567 12.6814 37.878 11.7439 36.723 10.5889C35.5699 9.43391 24.858 5.69891 22.9717 5.69891C21.0855 5.69891 10.3736 9.43391 9.21863 10.5889C8.0655 11.7439 8.58675 12.6814 8.58675 24.6908C8.58675 36.6983 22.9717 41.0539 22.9717 41.0539Z"
                                                                        stroke="#BB6BD9" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path d="M26.4945 26.4642L19.4482 19.4179" stroke="#BB6BD9"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path d="M19.4487 26.4642L26.495 19.4179" stroke="#BB6BD9"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg> </div>
                                                                <a href="{{ route($prefix.'.sales.salePlusReport' )}}?dashboardStatus=closedLead">
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-purple count">{{ $dashboard['closeLead'] }}</h3>
                                                                <span>Closed Lead</span>
                                                            </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-primary-light rounded-circle">
                                                                <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M32.8961 26.5849C34.1612 26.5849 35.223 27.629 35.0296 28.8783C33.8947 36.2283 27.6026 41.6855 20.0138 41.6855C11.6178 41.6855 4.8125 34.8803 4.8125 26.4862C4.8125 19.5704 10.0664 13.1283 15.9816 11.6717C17.2526 11.3579 18.5553 12.252 18.5553 13.5605C18.5553 22.4263 18.8533 24.7197 20.5368 25.9671C22.2204 27.2145 24.2 26.5849 32.8961 26.5849Z"
                                                                        stroke="var(--primary)" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M41.1733 19.2019C41.2739 13.5059 34.2772 4.32428 25.7509 4.48217C25.0877 4.49402 24.5568 5.04665 24.5272 5.70783C24.3121 10.3914 24.6022 16.4605 24.764 19.2118C24.8134 20.0684 25.4864 20.7414 26.341 20.7907C29.1693 20.9526 35.4594 21.1736 40.0759 20.4749C40.7035 20.3802 41.1634 19.8355 41.1733 19.2019Z"
                                                                        stroke="var(--primary)" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                                </svg> </div>
                                                                <a href="{{ route($prefix.'.sales.salePlusReport' )}}?dashboardStatus=totalLead">
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-primary count">{{ $dashboard['totalLead'] }}
                                                                </h3>
                                                                <span>Total Leads</span>
                                                            </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- row end -->
                                    </div>
                                    <!-- dashboard left end -->

                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body" style="position: relative;overflow: hidden;">
                                                <div id="redial" style="min-height: 141px;">
                                                    <div id="apexchartslxqbyndvi"
                                                        class="apexcharts-canvas apexchartslxqbyndvi apexcharts-theme-light"
                                                        style="width: 350px; height: 141px;">
                                                        <svg id="SvgjsSvg1067" width="350" height="141"
                                                            xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg"
                                                            xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                                            style="background: transparent;">
                                                            <g id="SvgjsG1069" class="apexcharts-inner apexcharts-graphical"
                                                                transform="translate(100, -10)">
                                                                <defs id="SvgjsDefs1068">
                                                                    <clipPath id="gridRectMasklxqbyndvi">
                                                                        <rect id="SvgjsRect1071" width="156" height="162" x="-3"
                                                                            y="-1" rx="0" ry="0" opacity="1" stroke-width="0"
                                                                            stroke="none" stroke-dasharray="0" fill="#fff">
                                                                        </rect>
                                                                    </clipPath>
                                                                    <clipPath id="gridRectMarkerMasklxqbyndvi">
                                                                        <rect id="SvgjsRect1072" width="154" height="164" x="-2"
                                                                            y="-2" rx="0" ry="0" opacity="1" stroke-width="0"
                                                                            stroke="none" stroke-dasharray="0" fill="#fff">
                                                                        </rect>
                                                                    </clipPath>
                                                                    <linearGradient id="SvgjsLinearGradient1077" x1="1" y1="0"
                                                                        x2="0" y2="1">
                                                                        <stop id="SvgjsStop1078" stop-opacity="1"
                                                                            stop-color="rgba(241,234,255,1)" offset="0.64">
                                                                        </stop>
                                                                        <stop id="SvgjsStop1079" stop-opacity="1"
                                                                            stop-color="rgba(243,237,255,1)" offset="0.43">
                                                                        </stop>
                                                                        <stop id="SvgjsStop1080" stop-opacity="1"
                                                                            stop-color="rgba(243,237,255,1)" offset="0.64">
                                                                        </stop>
                                                                        <stop id="SvgjsStop1081" stop-opacity="1"
                                                                            stop-color="rgba(241,234,255,1)" offset="0.005">
                                                                        </stop>
                                                                    </linearGradient>
                                                                    <linearGradient id="SvgjsLinearGradient1088" x1="1" y1="0"
                                                                        x2="0" y2="1">
                                                                        <stop id="SvgjsStop1089" stop-opacity="1"
                                                                            stop-color="rgba(122,132,155,1)" offset="0.64">
                                                                        </stop>
                                                                        <stop id="SvgjsStop1090" stop-opacity="1"
                                                                            stop-color="rgba(142,150,170,1)" offset="0.43">
                                                                        </stop>
                                                                        <stop id="SvgjsStop1091" stop-opacity="1"
                                                                            stop-color="rgba(142,150,170,1)" offset="0.64">
                                                                        </stop>
                                                                        <stop id="SvgjsStop1092" stop-opacity="1"
                                                                            stop-color="rgba(122,132,155,1)" offset="0.005">
                                                                        </stop>
                                                                    </linearGradient>
                                                                </defs>
                                                                <g id="SvgjsG1073" class="apexcharts-radialbar">
                                                                    <g id="SvgjsG1074">
                                                                        <g id="SvgjsG1075" class="apexcharts-tracks">
                                                                            <g id="SvgjsG1076"
                                                                                class="apexcharts-radialbar-track apexcharts-track"
                                                                                rel="1">
                                                                                <path id="apexcharts-radialbarTrack-0"
                                                                                    d="M 74.99999999999999 127.71951219512195 A 52.71951219512196 52.71951219512196 0 1 1 75.0920128600705 127.71943189873346"
                                                                                    fill="none" fill-opacity="1"
                                                                                    stroke="rgba(241,234,255,0.85)"
                                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                                    stroke-width="11.634146341463415"
                                                                                    stroke-dasharray="0"
                                                                                    class="apexcharts-radialbar-area"
                                                                                    data:pathOrig="M 74.99999999999999 127.71951219512195 A 52.71951219512196 52.71951219512196 0 1 1 75.0920128600705 127.71943189873346">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                        <g id="SvgjsG1083">
                                                                            <g id="SvgjsG1087"
                                                                                class="apexcharts-series apexcharts-radial-series"
                                                                                seriesName="AveragexResults" rel="1"
                                                                                data:realIndex="0">
                                                                                <path id="SvgjsPath1093"
                                                                                    d="M 74.99999999999999 127.71951219512195 A 52.71951219512196 52.71951219512196 0 1 1 127.71951219512195 75"
                                                                                    fill="none" fill-opacity="0.85"
                                                                                    stroke="url(#SvgjsLinearGradient1088)"
                                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                                    stroke-width="11.634146341463415"
                                                                                    stroke-dasharray="0"
                                                                                    class="apexcharts-radialbar-area apexcharts-radialbar-slice-0"
                                                                                    data:angle="270" data:value="75" index="0"
                                                                                    j="0"
                                                                                    data:pathOrig="M 74.99999999999999 127.71951219512195 A 52.71951219512196 52.71951219512196 0 1 1 127.71951219512195 75">
                                                                                </path>
                                                                            </g>
                                                                            <circle id="SvgjsCircle1084" r="26.902439024390247"
                                                                                cx="75" cy="75"
                                                                                class="apexcharts-radialbar-hollow"
                                                                                fill="transparent"></circle>
                                                                            <g id="SvgjsG1085"
                                                                                class="apexcharts-datalabels-group"
                                                                                transform="translate(0, 0) scale(1)"
                                                                                style="opacity: 1;"><text id="SvgjsText1086"
                                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                                    x="75" y="80" text-anchor="middle"
                                                                                    dominant-baseline="auto" font-size="24px"
                                                                                    font-weight="600" fill="#000000"
                                                                                    class="apexcharts-text apexcharts-datalabel-value"
                                                                                    style="font-family: Helvetica, Arial, sans-serif;">{{ round($dashboard['lsr']) }}%</text>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <line id="SvgjsLine1094" x1="0" y1="0" x2="150" y2="0"
                                                                    stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                                                    class="apexcharts-ycrosshairs"></line>
                                                                <line id="SvgjsLine1095" x1="0" y1="0" x2="150" y2="0"
                                                                    stroke-dasharray="0" stroke-width="0"
                                                                    class="apexcharts-ycrosshairs-hidden"></line>
                                                            </g>
                                                            <g id="SvgjsG1070" class="apexcharts-annotations"></g>
                                                        </svg>
                                                        <div class="apexcharts-legend"></div>
                                                    </div>
                                                </div>
                                                <span class="right-sign">
                                                    <svg width="93" height="93" viewBox="0 0 93 93" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g filter="url(#filter0_d_3_700)">
                                                            <circle cx="46.5" cy="31.5" r="16.5" fill="#fc7035"></circle>
                                                        </g>
                                                        <g clip-path="url(#clip0_3_700)">
                                                            <path
                                                                d="M52.738 25.3524C53.0957 24.9315 53.7268 24.8804 54.1476 25.2381C54.5684 25.5957 54.6196 26.2268 54.2619 26.6476L45.7619 36.6476C45.3986 37.0751 44.7549 37.1201 44.3356 36.7474L39.8356 32.7474C39.4228 32.3805 39.3857 31.7484 39.7526 31.3356C40.1195 30.9229 40.7516 30.8857 41.1643 31.2526L44.9002 34.5733L52.738 25.3524Z"
                                                                fill="#222B40"></path>
                                                        </g>
                                                        <defs>
                                                            <filter id="filter0_d_3_700" x="0" y="0" width="93" height="93"
                                                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                                <feFlood flood-opacity="0" result="BackgroundImageFix">
                                                                </feFlood>
                                                                <feColorMatrix in="SourceAlpha" type="matrix"
                                                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                    result="hardAlpha"></feColorMatrix>
                                                                <feOffset dy="15"></feOffset>
                                                                <feGaussianBlur stdDeviation="15"></feGaussianBlur>
                                                                <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                                <feColorMatrix type="matrix"
                                                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0">
                                                                </feColorMatrix>
                                                                <feBlend mode="normal" in2="BackgroundImageFix"
                                                                    result="effect1_dropShadow_3_700"></feBlend>
                                                                <feBlend mode="normal" in="SourceGraphic"
                                                                    in2="effect1_dropShadow_3_700" result="shape"></feBlend>
                                                            </filter>
                                                            <clipPath id="clip0_3_700">
                                                                <rect width="24" height="24" fill="white"
                                                                    transform="translate(35 19)"></rect>
                                                            </clipPath>
                                                        </defs>
                                                    </svg> </span>
                                                <div class="redia-date text-center mt-0">
                                                    <h4>LSR (Leads To Sales Ratio)</h4>
                                                    <!-- <p> Lorem ipsum dolor sit amet, consectetur </p>
                                        <a href="#" class="btn btn-secondary text-black">More
                                        Details</a>  -->
                                                </div>
                                                <div class="resize-triggers">
                                                    <div class="expand-trigger">
                                                        <div style="width: 386px; height: 214px;"></div>
                                                    </div>
                                                    <div class="contract-trigger"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- colmn end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2 -->
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header flex-wrap mb-3 ps-0">
                                <h2 class="heading mb-0" style="font-size: 1.3rem;">OpsPulse Performance</h2>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-6">
                                            <div class="card mb-3" style="height: auto; min-height: 60px;">
                                                <div class="card-body" style="padding: 10px;">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="icon-box icon-box-lg bg-success-light rounded-circle"> <svg
                                                                width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M22.9715 29.3168C15.7197 29.3168 9.52686 30.4132 9.52686 34.8043C9.52686 39.1953 15.6804 40.331 22.9715 40.331C30.2233 40.331 36.4144 39.2328 36.4144 34.8435C36.4144 30.4543 30.2626 29.3168 22.9715 29.3168Z"
                                                                    stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M22.9714 23.0537C27.7304 23.0537 31.5875 19.1948 31.5875 14.4359C31.5875 9.67694 27.7304 5.81979 22.9714 5.81979C18.2125 5.81979 14.3536 9.67694 14.3536 14.4359C14.3375 19.1787 18.1696 23.0377 22.9107 23.0537H22.9714Z"
                                                                    stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg> </div>
                                                         <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=newTask">   
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-success count">
                                                                    {{ $dashboard['OpsPulse']['newTask'] }}</h3>
                                                                <span>New Task</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-sm-6">
                                            <div class="card mb-3" style="height: auto; min-height: 60px;">
                                                <div class="card-body" style="padding: 10px;">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="icon-box icon-box-lg bg-primary-light rounded-circle"> <svg
                                                                width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M32.8961 26.5849C34.1612 26.5849 35.223 27.629 35.0296 28.8783C33.8947 36.2283 27.6026 41.6855 20.0138 41.6855C11.6178 41.6855 4.8125 34.8803 4.8125 26.4862C4.8125 19.5704 10.0664 13.1283 15.9816 11.6717C17.2526 11.3579 18.5553 12.252 18.5553 13.5605C18.5553 22.4263 18.8533 24.7197 20.5368 25.9671C22.2204 27.2145 24.2 26.5849 32.8961 26.5849Z"
                                                                    stroke="var(--primary)" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M41.1733 19.2019C41.2739 13.5059 34.2772 4.32428 25.7509 4.48217C25.0877 4.49402 24.5568 5.04665 24.5272 5.70783C24.3121 10.3914 24.6022 16.4605 24.764 19.2118C24.8134 20.0684 25.4864 20.7414 26.341 20.7907C29.1693 20.9526 35.4594 21.1736 40.0759 20.4749C40.7035 20.3802 41.1634 19.8355 41.1733 19.2019Z"
                                                                    stroke="var(--primary)" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg> </div>
                                                            <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=activeTask">   
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-primary count">
                                                                    {{ $dashboard['OpsPulse']['activeTask'] }}</h3>
                                                                <span>Active Task</span>
                                                            </div>
                                                            </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-sm-6">
                                            <div class="card mb-3" style="height: auto; min-height: 60px;">
                                                <div class="card-body" style="padding: 10px;">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="icon-box icon-box-lg bg-purple-light rounded-circle"> <svg
                                                                    width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M34.0396 20.974C36.6552 20.6065 38.6689 18.364 38.6746 15.6471C38.6746 12.9696 36.7227 10.7496 34.1633 10.3296"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M37.4912 27.262C40.0243 27.6407 41.7925 28.5276 41.7925 30.3557C41.7925 31.6139 40.96 32.4314 39.6137 32.9451"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.7879 28.0373C16.7616 28.0373 11.6147 28.9504 11.6147 32.5973C11.6147 36.2423 16.7297 37.1817 22.7879 37.1817C28.8141 37.1817 33.9591 36.2779 33.9591 32.6292C33.9591 28.9804 28.846 28.0373 22.7879 28.0373Z"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.7876 22.8325C26.742 22.8325 29.9483 19.6281 29.9483 15.6719C29.9483 11.7175 26.742 8.51123 22.7876 8.51123C18.8333 8.51123 15.627 11.7175 15.627 15.6719C15.612 19.6131 18.7939 22.8194 22.7351 22.8325H22.7876Z"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M11.5344 20.974C8.91691 20.6065 6.90504 18.364 6.89941 15.6471C6.89941 12.9696 8.85129 10.7496 11.4107 10.3296"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M8.0825 27.262C5.54937 27.6407 3.78125 28.5276 3.78125 30.3557C3.78125 31.6139 4.61375 32.4314 5.96 32.9451"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg></div>
                                                            <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=pendingTask"> 
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-purple count">
                                                                        {{ $dashboard['OpsPulse']['pendingTask'] }}</h3>
                                                                    <span>Pending Task</span>
                                                                </div>
                                                            </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-sm-6">
                                            <div class="card mb-3" style="height: auto; min-height: 60px;">
                                                <div class="card-body" style="padding: 10px;">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="icon-box icon-box-lg bg-danger-light rounded-circle"> <svg
                                                                width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M34.0396 20.974C36.6552 20.6065 38.6689 18.364 38.6746 15.6471C38.6746 12.9696 36.7227 10.7496 34.1633 10.3296"
                                                                    stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path
                                                                    d="M37.4912 27.262C40.0243 27.6407 41.7925 28.5276 41.7925 30.3557C41.7925 31.6139 40.96 32.4314 39.6137 32.9451"
                                                                    stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M22.7879 28.0373C16.7616 28.0373 11.6147 28.9504 11.6147 32.5973C11.6147 36.2423 16.7297 37.1817 22.7879 37.1817C28.8141 37.1817 33.9591 36.2779 33.9591 32.6292C33.9591 28.9804 28.846 28.0373 22.7879 28.0373Z"
                                                                    stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M22.7876 22.8325C26.742 22.8325 29.9483 19.6281 29.9483 15.6719C29.9483 11.7175 26.742 8.51123 22.7876 8.51123C18.8333 8.51123 15.627 11.7175 15.627 15.6719C15.612 19.6131 18.7939 22.8194 22.7351 22.8325H22.7876Z"
                                                                    stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path
                                                                    d="M11.5344 20.974C8.91691 20.6065 6.90504 18.364 6.89941 15.6471C6.89941 12.9696 8.85129 10.7496 11.4107 10.3296"
                                                                    stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path
                                                                    d="M8.0825 27.262C5.54937 27.6407 3.78125 28.5276 3.78125 30.3557C3.78125 31.6139 4.61375 32.4314 5.96 32.9451"
                                                                    stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg> </div>
                                                            <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=closedTask"> 
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-danger count">
                                                                        {{ $dashboard['OpsPulse']['closedTask'] }}</h3>
                                                                    <span>Closed Task</span>
                                                                </div>
                                                            </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- row end -->
                                </div>
                                <!-- dashboard left end -->
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-body depostit-card">
                                                    <div class="depostit-card-media d-flex justify-content-between style-1">
                                                    <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=totalTask"> 
                                                        <div style="margin-bottom: 75px;">
                                                            <h3>Total Task</h3>
                                                            <h3>{{ $dashboard['OpsPulse']['totalTask'] }}</h3>
                                                        </div>
                                                        </a>

                                                        <div class="icon-box bg-secondary"
                                                            style="height: 7.5rem; width: 9.5rem; padding-top: 10px;">
                                                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <g clip-path="url(#clip0_3_566)">
                                                                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M8 3V3.5C8 4.32843 8.67157 5 9.5 5H14.5C15.3284 5 16 4.32843 16 3.5V3H18C19.1046 3 20 3.89543 20 5V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V5C4 3.89543 4.89543 3 6 3H8Z"
                                                                        fill="#222B40"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M10.875 15.75C10.6354 15.75 10.3958 15.6542 10.2042 15.4625L8.2875 13.5458C7.90417 13.1625 7.90417 12.5875 8.2875 12.2042C8.67083 11.8208 9.29375 11.8208 9.62917 12.2042L10.875 13.45L14.0375 10.2875C14.4208 9.90417 14.9958 9.90417 15.3792 10.2875C15.7625 10.6708 15.7625 11.2458 15.3792 11.6292L11.5458 15.4625C11.3542 15.6542 11.1146 15.75 10.875 15.75Z"
                                                                        fill="#222B40"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M11 2C11 1.44772 11.4477 1 12 1C12.5523 1 13 1.44772 13 2H14.5C14.7761 2 15 2.22386 15 2.5V3.5C15 3.77614 14.7761 4 14.5 4H9.5C9.22386 4 9 3.77614 9 3.5V2.5C9 2.22386 9.22386 2 9.5 2H11Z"
                                                                        fill="#222B40"></path>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_3_566">
                                                                        <rect width="24" height="24" fill="white"></rect>
                                                                    </clipPath>
                                                             </defs>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="progress-box mt-0">
                                                        <div class="d-flex justify-content-between">
                                                            <!-- <p class="mb-0">Complete Task</p> -->
                                                            <!-- <p class="mb-0">20/28</p> -->
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-secondary"
                                                                style="width:50%; height:5px; border-radius:4px;"
                                                                role="progressbar"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif



                @if(session()->has('team'))
                    {{-- operation --}}
                    @if(session()->get('team')->department == '6790b8b82ef8f2064c61d077')

                    <div class="col-md-9">
                        <!-- 2 -->
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header flex-wrap mb-3 ps-0">
                                    <h2 class="heading mb-0" style="font-size: 1.3rem;">OpsPulse Performance</h2>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mb-3" style="height: auto; min-height: 60px;">
                                                    <div class="card-body" style="padding: 10px;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-success-light rounded-circle"> <svg
                                                                    width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.9715 29.3168C15.7197 29.3168 9.52686 30.4132 9.52686 34.8043C9.52686 39.1953 15.6804 40.331 22.9715 40.331C30.2233 40.331 36.4144 39.2328 36.4144 34.8435C36.4144 30.4543 30.2626 29.3168 22.9715 29.3168Z"
                                                                        stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.9714 23.0537C27.7304 23.0537 31.5875 19.1948 31.5875 14.4359C31.5875 9.67694 27.7304 5.81979 22.9714 5.81979C18.2125 5.81979 14.3536 9.67694 14.3536 14.4359C14.3375 19.1787 18.1696 23.0377 22.9107 23.0537H22.9714Z"
                                                                        stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg> </div>
                                                                <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=newTask"> 
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-success count">
                                                                    {{ $dashboard['OpsPulse']['newTask'] }}</h3>
                                                                <span>New Task</span>
                                                            </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mb-3" style="height: auto; min-height: 60px;">
                                                    <div class="card-body" style="padding: 10px;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-primary-light rounded-circle"> <svg
                                                                    width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M32.8961 26.5849C34.1612 26.5849 35.223 27.629 35.0296 28.8783C33.8947 36.2283 27.6026 41.6855 20.0138 41.6855C11.6178 41.6855 4.8125 34.8803 4.8125 26.4862C4.8125 19.5704 10.0664 13.1283 15.9816 11.6717C17.2526 11.3579 18.5553 12.252 18.5553 13.5605C18.5553 22.4263 18.8533 24.7197 20.5368 25.9671C22.2204 27.2145 24.2 26.5849 32.8961 26.5849Z"
                                                                        stroke="var(--primary)" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M41.1733 19.2019C41.2739 13.5059 34.2772 4.32428 25.7509 4.48217C25.0877 4.49402 24.5568 5.04665 24.5272 5.70783C24.3121 10.3914 24.6022 16.4605 24.764 19.2118C24.8134 20.0684 25.4864 20.7414 26.341 20.7907C29.1693 20.9526 35.4594 21.1736 40.0759 20.4749C40.7035 20.3802 41.1634 19.8355 41.1733 19.2019Z"
                                                                        stroke="var(--primary)" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                                </svg> </div>
                                                                <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=activeTask"> 
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-primary count">
                                                                    {{ $dashboard['OpsPulse']['activeTask'] }}</h3>
                                                                <span>Active Task</span>
                                                            </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mb-3" style="height: auto; min-height: 60px;">
                                                    <div class="card-body" style="padding: 10px;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-purple-light rounded-circle"> <svg
                                                                    width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.9717 41.0539C22.9717 41.0539 37.3567 36.6983 37.3567 24.6908C37.3567 12.6814 37.878 11.7439 36.723 10.5889C35.5699 9.43391 24.858 5.69891 22.9717 5.69891C21.0855 5.69891 10.3736 9.43391 9.21863 10.5889C8.0655 11.7439 8.58675 12.6814 8.58675 24.6908C8.58675 36.6983 22.9717 41.0539 22.9717 41.0539Z"
                                                                        stroke="#BB6BD9" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path d="M26.4945 26.4642L19.4482 19.4179" stroke="#BB6BD9"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path d="M19.4487 26.4642L26.495 19.4179" stroke="#BB6BD9"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg> </div>
                                                                <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=pendingTask"> 
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-purple count">
                                                                    {{ $dashboard['OpsPulse']['pendingTask'] }}</h3>
                                                                <span>Pending Task</span>
                                                            </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mb-3" style="height: auto; min-height: 60px;">
                                                    <div class="card-body" style="padding: 10px;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-danger-light rounded-circle"> <svg
                                                                    width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M34.0396 20.974C36.6552 20.6065 38.6689 18.364 38.6746 15.6471C38.6746 12.9696 36.7227 10.7496 34.1633 10.3296"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M37.4912 27.262C40.0243 27.6407 41.7925 28.5276 41.7925 30.3557C41.7925 31.6139 40.96 32.4314 39.6137 32.9451"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.7879 28.0373C16.7616 28.0373 11.6147 28.9504 11.6147 32.5973C11.6147 36.2423 16.7297 37.1817 22.7879 37.1817C28.8141 37.1817 33.9591 36.2779 33.9591 32.6292C33.9591 28.9804 28.846 28.0373 22.7879 28.0373Z"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.7876 22.8325C26.742 22.8325 29.9483 19.6281 29.9483 15.6719C29.9483 11.7175 26.742 8.51123 22.7876 8.51123C18.8333 8.51123 15.627 11.7175 15.627 15.6719C15.612 19.6131 18.7939 22.8194 22.7351 22.8325H22.7876Z"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M11.5344 20.974C8.91691 20.6065 6.90504 18.364 6.89941 15.6471C6.89941 12.9696 8.85129 10.7496 11.4107 10.3296"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M8.0825 27.262C5.54937 27.6407 3.78125 28.5276 3.78125 30.3557C3.78125 31.6139 4.61375 32.4314 5.96 32.9451"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg> </div>
                                                                <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=closedTask"> 
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-danger count">
                                                                    {{ $dashboard['OpsPulse']['closedTask'] }}</h3>
                                                                <span>Closed Task</span>
                                                            </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- row end -->
                                    </div>
                                    <!-- dashboard left end -->
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="card">
                                                    <div class="card-body depostit-card">
                                                        <div class="depostit-card-media d-flex justify-content-between style-1">
                                                        <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=totalTask"> 
                                                            <div style="margin-bottom: 75px;">
                                                                <h3>Total Task</h3>
                                                                <h3>{{ $dashboard['OpsPulse']['totalTask'] }}</h3>
                                                            </div>
                                                            </a>
                                                            <div class="icon-box bg-secondary"
                                                                style="height: 7.5rem; width: 9.5rem; padding-top: 10px;">
                                                                <svg width="80" height="80" viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <g clip-path="url(#clip0_3_566)">
                                                                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M8 3V3.5C8 4.32843 8.67157 5 9.5 5H14.5C15.3284 5 16 4.32843 16 3.5V3H18C19.1046 3 20 3.89543 20 5V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V5C4 3.89543 4.89543 3 6 3H8Z"
                                                                            fill="#222B40"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M10.875 15.75C10.6354 15.75 10.3958 15.6542 10.2042 15.4625L8.2875 13.5458C7.90417 13.1625 7.90417 12.5875 8.2875 12.2042C8.67083 11.8208 9.29375 11.8208 9.62917 12.2042L10.875 13.45L14.0375 10.2875C14.4208 9.90417 14.9958 9.90417 15.3792 10.2875C15.7625 10.6708 15.7625 11.2458 15.3792 11.6292L11.5458 15.4625C11.3542 15.6542 11.1146 15.75 10.875 15.75Z"
                                                                            fill="#222B40"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M11 2C11 1.44772 11.4477 1 12 1C12.5523 1 13 1.44772 13 2H14.5C14.7761 2 15 2.22386 15 2.5V3.5C15 3.77614 14.7761 4 14.5 4H9.5C9.22386 4 9 3.77614 9 3.5V2.5C9 2.22386 9.22386 2 9.5 2H11Z"
                                                                            fill="#222B40"></path>
                                                                    </g>
                                                                    <defs>
                                                                        <clipPath id="clip0_3_566">
                                                                            <rect width="24" height="24" fill="white"></rect>
                                                                        </clipPath>
                                                                    </defs>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="progress-box mt-0">
                                                            <div class="d-flex justify-content-between">
                                                                <!-- <p class="mb-0">Complete Task</p> -->
                                                                <!-- <p class="mb-0">20/28</p> -->
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-secondary"
                                                                    style="width:50%; height:5px; border-radius:4px;"
                                                                    role="progressbar"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        </div>
                    @elseif(session()->get('team')->department == '6790b8df2ef8f2064c61d079')
                        <!-- hr -->
                        <div class="col-md-9">
                            <div class="row">
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="icon-box icon-box-lg bg-success-light rounded-circle"> <svg width="46"
                                                height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M22.9715 29.3168C15.7197 29.3168 9.52686 30.4132 9.52686 34.8043C9.52686 39.1953 15.6804 40.331 22.9715 40.331C30.2233 40.331 36.4144 39.2328 36.4144 34.8435C36.4144 30.4543 30.2626 29.3168 22.9715 29.3168Z"
                                                    stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M22.9714 23.0537C27.7304 23.0537 31.5875 19.1948 31.5875 14.4359C31.5875 9.67694 27.7304 5.81979 22.9714 5.81979C18.2125 5.81979 14.3536 9.67694 14.3536 14.4359C14.3375 19.1787 18.1696 23.0377 22.9107 23.0537H22.9714Z"
                                                    stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg> </div>

                                        <div class="total-projects ms-3">
                                            <h3 class="text-success count">{{ $dashboard['EmployeeRetentionRate'] }}</h3>
                                            <span>Employee Retention Rate </span>
                                        </div>
                              </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="icon-box icon-box-lg bg-primary-light rounded-circle"> <svg width="46"
                                                height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M32.8961 26.5849C34.1612 26.5849 35.223 27.629 35.0296 28.8783C33.8947 36.2283 27.6026 41.6855 20.0138 41.6855C11.6178 41.6855 4.8125 34.8803 4.8125 26.4862C4.8125 19.5704 10.0664 13.1283 15.9816 11.6717C17.2526 11.3579 18.5553 12.252 18.5553 13.5605C18.5553 22.4263 18.8533 24.7197 20.5368 25.9671C22.2204 27.2145 24.2 26.5849 32.8961 26.5849Z"
                                                    stroke="var(--primary)" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M41.1733 19.2019C41.2739 13.5059 34.2772 4.32428 25.7509 4.48217C25.0877 4.49402 24.5568 5.04665 24.5272 5.70783C24.3121 10.3914 24.6022 16.4605 24.764 19.2118C24.8134 20.0684 25.4864 20.7414 26.341 20.7907C29.1693 20.9526 35.4594 21.1736 40.0759 20.4749C40.7035 20.3802 41.1634 19.8355 41.1733 19.2019Z"
                                                    stroke="var(--primary)" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg> </div>
                                        <a href="{{route($prefix.'.opsPemployeeManagementuls.listTeam') }}?dashbodStatus=activeEmployee">
                                            <div class="total-projects ms-3">
                                                <h3 class="text-primary count">{{ $dashboard['ActiveEmployee'] }}</h3>
                                                <span>Active Employee</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="icon-box icon-box-lg bg-purple-light rounded-circle"> <svg width="46"
                                                height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M22.9717 41.0539C22.9717 41.0539 37.3567 36.6983 37.3567 24.6908C37.3567 12.6814 37.878 11.7439 36.723 10.5889C35.5699 9.43391 24.858 5.69891 22.9717 5.69891C21.0855 5.69891 10.3736 9.43391 9.21863 10.5889C8.0655 11.7439 8.58675 12.6814 8.58675 24.6908C8.58675 36.6983 22.9717 41.0539 22.9717 41.0539Z"
                                                    stroke="#BB6BD9" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path d="M26.4945 26.4642L19.4482 19.4179" stroke="#BB6BD9" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                                <path d="M19.4487 26.4642L26.495 19.4179" stroke="#BB6BD9" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                            </svg> </div>
                                            <a href="{{route($prefix.'.opsPemployeeManagementuls.exEmployee') }}">
                                                        <div class="total-projects ms-3">
                                                            <h3 class="text-purple count">{{ $dashboard['ResignationEmployee'] }}</h3>
                                                            <span>Resignation Employee</span>
                                                        </div>
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="icon-box icon-box-lg bg-danger-light rounded-circle"> <svg width="46"
                                                height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M34.0396 20.974C36.6552 20.6065 38.6689 18.364 38.6746 15.6471C38.6746 12.9696 36.7227 10.7496 34.1633 10.3296"
                                                    stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M37.4912 27.262C40.0243 27.6407 41.7925 28.5276 41.7925 30.3557C41.7925 31.6139 40.96 32.4314 39.6137 32.9451"
                                                    stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M22.7879 28.0373C16.7616 28.0373 11.6147 28.9504 11.6147 32.5973C11.6147 36.2423 16.7297 37.1817 22.7879 37.1817C28.8141 37.1817 33.9591 36.2779 33.9591 32.6292C33.9591 28.9804 28.846 28.0373 22.7879 28.0373Z"
                                                    stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M22.7876 22.8325C26.742 22.8325 29.9483 19.6281 29.9483 15.6719C29.9483 11.7175 26.742 8.51123 22.7876 8.51123C18.8333 8.51123 15.627 11.7175 15.627 15.6719C15.612 19.6131 18.7939 22.8194 22.7351 22.8325H22.7876Z"
                                                    stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M11.5344 20.974C8.91691 20.6065 6.90504 18.364 6.89941 15.6471C6.89941 12.9696 8.85129 10.7496 11.4107 10.3296"
                                                    stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M8.0825 27.262C5.54937 27.6407 3.78125 28.5276 3.78125 30.3557C3.78125 31.6139 4.61375 32.4314 5.96 32.9451"
                                                    stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg> </div>
                                    <a href="{{ route($prefix.'.opsPemployeeManagementuls.listTeam') }}">
                                        <div class="total-projects ms-3">
                                            <h3 class="text-danger count">{{ $dashboard['TotalEmployee'] }}</h3>
                                            <span>Total Employee</span>
                                        </div>
                                    </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><i class="ri-cake-2-line" style="vertical-align: bottom;"></i> Upcoming
                                    Birthday</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="table">
                                            <table class="table table-styling table-hover table-striped table-primary">
                                                <thead>
                                                    <tr>
                                                        <th>Employee</th>
                                                        <th style="text-align: right;">Birthday Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($dashboard['birthdayEmp'] as $key=>$val)
                                                    <tr>
                                                        <td>
                                                            <h6 class="table-avatar">  <a href="{{ route($prefix.'.team.profileView', $val->_id) }}" target="_blank">{{ $val->name }}</a> </h6>
                                                        </td>
                                                        <td align="right">
                                                           <strong>
                                                            {{ !empty($val->dateOfBirth) ? date('d M Y', strtotime($val->dateOfBirth)) : '----' }}
                                                           </strong>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- responsive table end -->
                                    </div>
                                </div>
                            </div>
</div>
                        </div>
                        </div>
                        
                    @elseif(session()->get('team')->department == '67bd3ca8d4de44c0093ea46c' || session()->get('team')->department == '67bd3cd7d4de44c0093ea46d')
                        <!-- sub admin sub branch -->
                        <!-- 1 -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header flex-wrap mb-3 ps-0">
                                        <h2 class="heading mb-0" style="font-size: 1.3rem;">SalesPulse Performance</h2>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="icon-box icon-box-lg bg-success-light rounded-circle">
                                                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M22.9715 29.3168C15.7197 29.3168 9.52686 30.4132 9.52686 34.8043C9.52686 39.1953 15.6804 40.331 22.9715 40.331C30.2233 40.331 36.4144 39.2328 36.4144 34.8435C36.4144 30.4543 30.2626 29.3168 22.9715 29.3168Z"
                                                                            stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M22.9714 23.0537C27.7304 23.0537 31.5875 19.1948 31.5875 14.4359C31.5875 9.67694 27.7304 5.81979 22.9714 5.81979C18.2125 5.81979 14.3536 9.67694 14.3536 14.4359C14.3375 19.1787 18.1696 23.0377 22.9107 23.0537H22.9714Z"
                                                                            stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                    </svg> </div>
                                                                    <a href="{{ route($prefix.'.sales.salePlusReport' )}}?dashboardStatus=newLead">
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-success count">{{ $dashboard['newLead'] }}</h3>
                                                                    <span>New Leads</span>
                                                                </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="icon-box icon-box-lg bg-primary-light rounded-circle">
                                                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M32.8961 26.5849C34.1612 26.5849 35.223 27.629 35.0296 28.8783C33.8947 36.2283 27.6026 41.6855 20.0138 41.6855C11.6178 41.6855 4.8125 34.8803 4.8125 26.4862C4.8125 19.5704 10.0664 13.1283 15.9816 11.6717C17.2526 11.3579 18.5553 12.252 18.5553 13.5605C18.5553 22.4263 18.8533 24.7197 20.5368 25.9671C22.2204 27.2145 24.2 26.5849 32.8961 26.5849Z"
                                                                            stroke="var(--primary)" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M41.1733 19.2019C41.2739 13.5059 34.2772 4.32428 25.7509 4.48217C25.0877 4.49402 24.5568 5.04665 24.5272 5.70783C24.3121 10.3914 24.6022 16.4605 24.764 19.2118C24.8134 20.0684 25.4864 20.7414 26.341 20.7907C29.1693 20.9526 35.4594 21.1736 40.0759 20.4749C40.7035 20.3802 41.1634 19.8355 41.1733 19.2019Z"
                                                                            stroke="var(--primary)" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg> </div>
                                                                    <a href="{{ route($prefix.'.sales.salePlusReport' )}}?dashboardStatus=activeLead">
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-primary count">{{ $dashboard['activeLead'] }}
                                                                    </h3>
                                                                    <span>Active Leads</span>
                                                                </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="icon-box icon-box-lg bg-purple-light rounded-circle">
                                                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M22.9717 41.0539C22.9717 41.0539 37.3567 36.6983 37.3567 24.6908C37.3567 12.6814 37.878 11.7439 36.723 10.5889C35.5699 9.43391 24.858 5.69891 22.9717 5.69891C21.0855 5.69891 10.3736 9.43391 9.21863 10.5889C8.0655 11.7439 8.58675 12.6814 8.58675 24.6908C8.58675 36.6983 22.9717 41.0539 22.9717 41.0539Z"
                                                                            stroke="#BB6BD9" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path d="M26.4945 26.4642L19.4482 19.4179" stroke="#BB6BD9"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path d="M19.4487 26.4642L26.495 19.4179" stroke="#BB6BD9"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                    </svg> </div>
                                                                    <a href="{{ route($prefix.'.sales.salePlusReport' )}}?dashboardStatus=pendingLead">
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-purple count">{{ $dashboard['pendingLead'] }}
                                                                    </h3>
                                                                    <span>Pending Lead</span>
                                                                </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="icon-box icon-box-lg bg-danger-light rounded-circle">
                                                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M34.0396 20.974C36.6552 20.6065 38.6689 18.364 38.6746 15.6471C38.6746 12.9696 36.7227 10.7496 34.1633 10.3296"
                                                                            stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path
                                                                            d="M37.4912 27.262C40.0243 27.6407 41.7925 28.5276 41.7925 30.3557C41.7925 31.6139 40.96 32.4314 39.6137 32.9451"
                                                                            stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M22.7879 28.0373C16.7616 28.0373 11.6147 28.9504 11.6147 32.5973C11.6147 36.2423 16.7297 37.1817 22.7879 37.1817C28.8141 37.1817 33.9591 36.2779 33.9591 32.6292C33.9591 28.9804 28.846 28.0373 22.7879 28.0373Z"
                                                                            stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M22.7876 22.8325C26.742 22.8325 29.9483 19.6281 29.9483 15.6719C29.9483 11.7175 26.742 8.51123 22.7876 8.51123C18.8333 8.51123 15.627 11.7175 15.627 15.6719C15.612 19.6131 18.7939 22.8194 22.7351 22.8325H22.7876Z"
                                                                            stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path
                                                                            d="M11.5344 20.974C8.91691 20.6065 6.90504 18.364 6.89941 15.6471C6.89941 12.9696 8.85129 10.7496 11.4107 10.3296"
                                                                            stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path
                                                                            d="M8.0825 27.262C5.54937 27.6407 3.78125 28.5276 3.78125 30.3557C3.78125 31.6139 4.61375 32.4314 5.96 32.9451"
                                                                            stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                    </svg> </div>
                                                                    <a href="{{ route($prefix.'.sales.salePlusReport' )}}?dashboardStatus=salescloseLead">
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-danger count">{{ $dashboard['salseClose'] }}
                                                                    </h3>
                                                                    <span>Sales Closed</span>
                                                                </div>
                                                            </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="icon-box icon-box-lg bg-purple-light rounded-circle">
                                                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M22.9717 41.0539C22.9717 41.0539 37.3567 36.6983 37.3567 24.6908C37.3567 12.6814 37.878 11.7439 36.723 10.5889C35.5699 9.43391 24.858 5.69891 22.9717 5.69891C21.0855 5.69891 10.3736 9.43391 9.21863 10.5889C8.0655 11.7439 8.58675 12.6814 8.58675 24.6908C8.58675 36.6983 22.9717 41.0539 22.9717 41.0539Z"
                                                                            stroke="#BB6BD9" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path d="M26.4945 26.4642L19.4482 19.4179" stroke="#BB6BD9"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path d="M19.4487 26.4642L26.495 19.4179" stroke="#BB6BD9"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                    </svg> </div>
                                                                    <a href="{{ route($prefix.'.sales.salePlusReport' )}}?dashboardStatus=closedLead">
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-purple count">{{ $dashboard['closeLead'] }}</h3>
                                                                    <span>Closed Lead</span>
                                                                </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="icon-box icon-box-lg bg-primary-light rounded-circle">
                                                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M32.8961 26.5849C34.1612 26.5849 35.223 27.629 35.0296 28.8783C33.8947 36.2283 27.6026 41.6855 20.0138 41.6855C11.6178 41.6855 4.8125 34.8803 4.8125 26.4862C4.8125 19.5704 10.0664 13.1283 15.9816 11.6717C17.2526 11.3579 18.5553 12.252 18.5553 13.5605C18.5553 22.4263 18.8533 24.7197 20.5368 25.9671C22.2204 27.2145 24.2 26.5849 32.8961 26.5849Z"
                                                                            stroke="var(--primary)" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M41.1733 19.2019C41.2739 13.5059 34.2772 4.32428 25.7509 4.48217C25.0877 4.49402 24.5568 5.04665 24.5272 5.70783C24.3121 10.3914 24.6022 16.4605 24.764 19.2118C24.8134 20.0684 25.4864 20.7414 26.341 20.7907C29.1693 20.9526 35.4594 21.1736 40.0759 20.4749C40.7035 20.3802 41.1634 19.8355 41.1733 19.2019Z"
                                                                            stroke="var(--primary)" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg> </div>
                                                                    <a href="{{ route($prefix.'.sales.salePlusReport' )}}?dashboardStatus=totalLead">
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-primary count">{{ $dashboard['totalLead'] }}
                                                                    </h3>
                                                                    <span>Total Leads</span>
                                                                </div>
                                                            </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- row end -->
                                        </div>
                                        <!-- dashboard left end -->

                                        <div class="col-lg-4">
                                            <div class="card">
                                                <div class="card-body" style="position: relative;overflow: hidden;">
                                                    <div id="redial" style="min-height: 141px;">
                                                        <div id="apexchartslxqbyndvi"
                                                            class="apexcharts-canvas apexchartslxqbyndvi apexcharts-theme-light"
                                                            style="width: 350px; height: 141px;">
                                                            <svg id="SvgjsSvg1067" width="350" height="141"
                                                                xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg"
                                                                xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                                                style="background: transparent;">
                                                                <g id="SvgjsG1069" class="apexcharts-inner apexcharts-graphical"
                                                                    transform="translate(100, -10)">
                                                                    <defs id="SvgjsDefs1068">
                                                                        <clipPath id="gridRectMasklxqbyndvi">
                                                                            <rect id="SvgjsRect1071" width="156" height="162" x="-3"
                                                                                y="-1" rx="0" ry="0" opacity="1" stroke-width="0"
                                                                                stroke="none" stroke-dasharray="0" fill="#fff">
                                                                            </rect>
                                                                        </clipPath>
                                                                        <clipPath id="gridRectMarkerMasklxqbyndvi">
                                                                            <rect id="SvgjsRect1072" width="154" height="164" x="-2"
                                                                                y="-2" rx="0" ry="0" opacity="1" stroke-width="0"
                                                                                stroke="none" stroke-dasharray="0" fill="#fff">
                                                                            </rect>
                                                                        </clipPath>
                                                                        <linearGradient id="SvgjsLinearGradient1077" x1="1" y1="0"
                                                                            x2="0" y2="1">
                                                                            <stop id="SvgjsStop1078" stop-opacity="1"
                                                                                stop-color="rgba(241,234,255,1)" offset="0.64">
                                                                            </stop>
                                                                            <stop id="SvgjsStop1079" stop-opacity="1"
                                                                                stop-color="rgba(243,237,255,1)" offset="0.43">
                                                                            </stop>
                                                                            <stop id="SvgjsStop1080" stop-opacity="1"
                                                                                stop-color="rgba(243,237,255,1)" offset="0.64">
                                                                            </stop>
                                                                            <stop id="SvgjsStop1081" stop-opacity="1"
                                                                                stop-color="rgba(241,234,255,1)" offset="0.005">
                                                                            </stop>
                                                                        </linearGradient>
                                                                        <linearGradient id="SvgjsLinearGradient1088" x1="1" y1="0"
                                                                            x2="0" y2="1">
                                                                            <stop id="SvgjsStop1089" stop-opacity="1"
                                                                                stop-color="rgba(122,132,155,1)" offset="0.64">
                                                                            </stop>
                                                                            <stop id="SvgjsStop1090" stop-opacity="1"
                                                                                stop-color="rgba(142,150,170,1)" offset="0.43">
                                                                            </stop>
                                                                            <stop id="SvgjsStop1091" stop-opacity="1"
                                                                                stop-color="rgba(142,150,170,1)" offset="0.64">
                                                                            </stop>
                                                                            <stop id="SvgjsStop1092" stop-opacity="1"
                                                                                stop-color="rgba(122,132,155,1)" offset="0.005">
                                                                            </stop>
                                                                        </linearGradient>
                                                                    </defs>
                                                                    <g id="SvgjsG1073" class="apexcharts-radialbar">
                                                                        <g id="SvgjsG1074">
                                                                            <g id="SvgjsG1075" class="apexcharts-tracks">
                                                                                <g id="SvgjsG1076"
                                                                                    class="apexcharts-radialbar-track apexcharts-track"
                                                                                    rel="1">
                                                                                    <path id="apexcharts-radialbarTrack-0"
                                                                                        d="M 74.99999999999999 127.71951219512195 A 52.71951219512196 52.71951219512196 0 1 1 75.0920128600705 127.71943189873346"
                                                                                        fill="none" fill-opacity="1"
                                                                                        stroke="rgba(241,234,255,0.85)"
                                                                                        stroke-opacity="1" stroke-linecap="butt"
                                                                                        stroke-width="11.634146341463415"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-radialbar-area"
                                                                                        data:pathOrig="M 74.99999999999999 127.71951219512195 A 52.71951219512196 52.71951219512196 0 1 1 75.0920128600705 127.71943189873346">
                                                                                    </path>
                                                                                </g>
                                                                            </g>
                                                                            <g id="SvgjsG1083">
                                                                                <g id="SvgjsG1087"
                                                                                    class="apexcharts-series apexcharts-radial-series"
                                                                                    seriesName="AveragexResults" rel="1"
                                                                                    data:realIndex="0">
                                                                                    <path id="SvgjsPath1093"
                                                                                        d="M 74.99999999999999 127.71951219512195 A 52.71951219512196 52.71951219512196 0 1 1 127.71951219512195 75"
                                                                                        fill="none" fill-opacity="0.85"
                                                                                        stroke="url(#SvgjsLinearGradient1088)"
                                                                                        stroke-opacity="1" stroke-linecap="butt"
                                                                                        stroke-width="11.634146341463415"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-radialbar-area apexcharts-radialbar-slice-0"
                                                                                        data:angle="270" data:value="75" index="0"
                                                                                        j="0"
                                                                                        data:pathOrig="M 74.99999999999999 127.71951219512195 A 52.71951219512196 52.71951219512196 0 1 1 127.71951219512195 75">
                                                                                    </path>
                                                                                </g>
                                                                                <circle id="SvgjsCircle1084" r="26.902439024390247"
                                                                                    cx="75" cy="75"
                                                                                    class="apexcharts-radialbar-hollow"
                                                                                    fill="transparent"></circle>
                                                                                <g id="SvgjsG1085"
                                                                                    class="apexcharts-datalabels-group"
                                                                                    transform="translate(0, 0) scale(1)"
                                                                                    style="opacity: 1;"><text id="SvgjsText1086"
                                                                                        font-family="Helvetica, Arial, sans-serif"
                                                                                        x="75" y="80" text-anchor="middle"
                                                                                        dominant-baseline="auto" font-size="24px"
                                                                                        font-weight="600" fill="#000000"
                                                                                        class="apexcharts-text apexcharts-datalabel-value"
                                                                                        style="font-family: Helvetica, Arial, sans-serif;">{{ round($dashboard['lsr']) }}%</text>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <line id="SvgjsLine1094" x1="0" y1="0" x2="150" y2="0"
                                                                        stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                                                        class="apexcharts-ycrosshairs"></line>
                                                                    <line id="SvgjsLine1095" x1="0" y1="0" x2="150" y2="0"
                                                                        stroke-dasharray="0" stroke-width="0"
                                                                        class="apexcharts-ycrosshairs-hidden"></line>
                                                                </g>
                                                                <g id="SvgjsG1070" class="apexcharts-annotations"></g>
                                                            </svg>
                                                            <div class="apexcharts-legend"></div>
                                                        </div>
                                                    </div>
                                                    <span class="right-sign">
                                                        <svg width="93" height="93" viewBox="0 0 93 93" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <g filter="url(#filter0_d_3_700)">
                                                                <circle cx="46.5" cy="31.5" r="16.5" fill="#fc7035"></circle>
                                                            </g>
                                                            <g clip-path="url(#clip0_3_700)">
                                                                <path
                                                                    d="M52.738 25.3524C53.0957 24.9315 53.7268 24.8804 54.1476 25.2381C54.5684 25.5957 54.6196 26.2268 54.2619 26.6476L45.7619 36.6476C45.3986 37.0751 44.7549 37.1201 44.3356 36.7474L39.8356 32.7474C39.4228 32.3805 39.3857 31.7484 39.7526 31.3356C40.1195 30.9229 40.7516 30.8857 41.1643 31.2526L44.9002 34.5733L52.738 25.3524Z"
                                                                    fill="#222B40"></path>
                                                            </g>
                                                            <defs>
                                                                <filter id="filter0_d_3_700" x="0" y="0" width="93" height="93"
                                                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                                    <feFlood flood-opacity="0" result="BackgroundImageFix">
                                                                    </feFlood>
                                                                    <feColorMatrix in="SourceAlpha" type="matrix"
                                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                        result="hardAlpha"></feColorMatrix>
                                                                    <feOffset dy="15"></feOffset>
                                                                    <feGaussianBlur stdDeviation="15"></feGaussianBlur>
                                                                    <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                                    <feColorMatrix type="matrix"
                                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0">
                                                                    </feColorMatrix>
                                                                    <feBlend mode="normal" in2="BackgroundImageFix"
                                                                        result="effect1_dropShadow_3_700"></feBlend>
                                                                    <feBlend mode="normal" in="SourceGraphic"
                                                                        in2="effect1_dropShadow_3_700" result="shape"></feBlend>
                                                                </filter>
                                                                <clipPath id="clip0_3_700">
                                                                    <rect width="24" height="24" fill="white"
                                                                        transform="translate(35 19)"></rect>
                                                                </clipPath>
                                                            </defs>
                                                        </svg> </span>
                                                    <div class="redia-date text-center mt-0">
                                                        <h4>LSR (Leads To Sales Ratio)</h4>
                                                        <!-- <p> Lorem ipsum dolor sit amet, consectetur </p>
                                                <a href="#" class="btn btn-secondary text-black">More
                                                Details</a>  -->
                                                    </div>
                                                    <div class="resize-triggers">
                                                        <div class="expand-trigger">
                                                            <div style="width: 386px; height: 214px;"></div>
                                                        </div>
                                                        <div class="contract-trigger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- colmn end -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2 -->
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header flex-wrap mb-3 ps-0">
                                    <h2 class="heading mb-0" style="font-size: 1.3rem;">OpsPulse Performance</h2>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mb-3" style="height: auto; min-height: 60px;">
                                                    <div class="card-body" style="padding: 10px;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-success-light rounded-circle"> <svg
                                                                    width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.9715 29.3168C15.7197 29.3168 9.52686 30.4132 9.52686 34.8043C9.52686 39.1953 15.6804 40.331 22.9715 40.331C30.2233 40.331 36.4144 39.2328 36.4144 34.8435C36.4144 30.4543 30.2626 29.3168 22.9715 29.3168Z"
                                                                        stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.9714 23.0537C27.7304 23.0537 31.5875 19.1948 31.5875 14.4359C31.5875 9.67694 27.7304 5.81979 22.9714 5.81979C18.2125 5.81979 14.3536 9.67694 14.3536 14.4359C14.3375 19.1787 18.1696 23.0377 22.9107 23.0537H22.9714Z"
                                                                        stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg> </div>
                                                                <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=newTask"> 
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-success count">
                                                                    {{ $dashboard['OpsPulse']['newTask'] }}</h3>
                                                                <span>New Task</span>
                                                            </div>
                                                                </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mb-3" style="height: auto; min-height: 60px;">
                                                    <div class="card-body" style="padding: 10px;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-primary-light rounded-circle"> <svg
                                                                    width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M32.8961 26.5849C34.1612 26.5849 35.223 27.629 35.0296 28.8783C33.8947 36.2283 27.6026 41.6855 20.0138 41.6855C11.6178 41.6855 4.8125 34.8803 4.8125 26.4862C4.8125 19.5704 10.0664 13.1283 15.9816 11.6717C17.2526 11.3579 18.5553 12.252 18.5553 13.5605C18.5553 22.4263 18.8533 24.7197 20.5368 25.9671C22.2204 27.2145 24.2 26.5849 32.8961 26.5849Z"
                                                                        stroke="var(--primary)" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M41.1733 19.2019C41.2739 13.5059 34.2772 4.32428 25.7509 4.48217C25.0877 4.49402 24.5568 5.04665 24.5272 5.70783C24.3121 10.3914 24.6022 16.4605 24.764 19.2118C24.8134 20.0684 25.4864 20.7414 26.341 20.7907C29.1693 20.9526 35.4594 21.1736 40.0759 20.4749C40.7035 20.3802 41.1634 19.8355 41.1733 19.2019Z"
                                                                        stroke="var(--primary)" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                                </svg> </div>
                                                                <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=activeTask"> 
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-primary count">
                                                                    {{ $dashboard['OpsPulse']['activeTask'] }}</h3>
                                                                <span>Active Task</span>
                                                            </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mb-3" style="height: auto; min-height: 60px;">
                                                    <div class="card-body" style="padding: 10px;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-purple-light rounded-circle"> 
                                                            <svg
                                                                    width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M34.0396 20.974C36.6552 20.6065 38.6689 18.364 38.6746 15.6471C38.6746 12.9696 36.7227 10.7496 34.1633 10.3296"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M37.4912 27.262C40.0243 27.6407 41.7925 28.5276 41.7925 30.3557C41.7925 31.6139 40.96 32.4314 39.6137 32.9451"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.7879 28.0373C16.7616 28.0373 11.6147 28.9504 11.6147 32.5973C11.6147 36.2423 16.7297 37.1817 22.7879 37.1817C28.8141 37.1817 33.9591 36.2779 33.9591 32.6292C33.9591 28.9804 28.846 28.0373 22.7879 28.0373Z"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.7876 22.8325C26.742 22.8325 29.9483 19.6281 29.9483 15.6719C29.9483 11.7175 26.742 8.51123 22.7876 8.51123C18.8333 8.51123 15.627 11.7175 15.627 15.6719C15.612 19.6131 18.7939 22.8194 22.7351 22.8325H22.7876Z"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M11.5344 20.974C8.91691 20.6065 6.90504 18.364 6.89941 15.6471C6.89941 12.9696 8.85129 10.7496 11.4107 10.3296"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M8.0825 27.262C5.54937 27.6407 3.78125 28.5276 3.78125 30.3557C3.78125 31.6139 4.61375 32.4314 5.96 32.9451"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg>    
                                                        </div>
                                                                <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=pendingTask"> 
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-purple count">
                                                                    {{ $dashboard['OpsPulse']['pendingTask'] }}</h3>
                                                                <span>Pending Task</span>
                                                            </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mb-3" style="height: auto; min-height: 60px;">
                                                    <div class="card-body" style="padding: 10px;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="icon-box icon-box-lg bg-danger-light rounded-circle"> <svg
                                                                    width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M34.0396 20.974C36.6552 20.6065 38.6689 18.364 38.6746 15.6471C38.6746 12.9696 36.7227 10.7496 34.1633 10.3296"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M37.4912 27.262C40.0243 27.6407 41.7925 28.5276 41.7925 30.3557C41.7925 31.6139 40.96 32.4314 39.6137 32.9451"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.7879 28.0373C16.7616 28.0373 11.6147 28.9504 11.6147 32.5973C11.6147 36.2423 16.7297 37.1817 22.7879 37.1817C28.8141 37.1817 33.9591 36.2779 33.9591 32.6292C33.9591 28.9804 28.846 28.0373 22.7879 28.0373Z"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M22.7876 22.8325C26.742 22.8325 29.9483 19.6281 29.9483 15.6719C29.9483 11.7175 26.742 8.51123 22.7876 8.51123C18.8333 8.51123 15.627 11.7175 15.627 15.6719C15.612 19.6131 18.7939 22.8194 22.7351 22.8325H22.7876Z"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M11.5344 20.974C8.91691 20.6065 6.90504 18.364 6.89941 15.6471C6.89941 12.9696 8.85129 10.7496 11.4107 10.3296"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M8.0825 27.262C5.54937 27.6407 3.78125 28.5276 3.78125 30.3557C3.78125 31.6139 4.61375 32.4314 5.96 32.9451"
                                                                        stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg> </div>
                                                                <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=closedTask"> 
                                                            <div class="total-projects ms-3">
                                                                <h3 class="text-danger count">
                                                                    {{ $dashboard['OpsPulse']['closedTask'] }}</h3>
                                                                <span>Closed Task</span>
                                                            </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- row end -->
                                    </div>
                                    <!-- dashboard left end -->
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="card">
                                                    <div class="card-body depostit-card">
                                                        <div class="depostit-card-media d-flex justify-content-between style-1">
                                                        <a href="{{ route($prefix.'.task-pulse.taskGiven') }}?dashboardData=totalTask"> 
                                                            <div style="margin-bottom: 75px;">
                                                                <h3>Total Task</h3>
                                                                <h3>{{ $dashboard['OpsPulse']['totalTask'] }}</h3>
                                                            </div>
                                                        </a>
                                                            <div class="icon-box bg-secondary"
                                                                style="height: 7.5rem; width: 9.5rem; padding-top: 10px;">
                                                                <svg width="80" height="80" viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <g clip-path="url(#clip0_3_566)">
                                                                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M8 3V3.5C8 4.32843 8.67157 5 9.5 5H14.5C15.3284 5 16 4.32843 16 3.5V3H18C19.1046 3 20 3.89543 20 5V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V5C4 3.89543 4.89543 3 6 3H8Z"
                                                                            fill="#222B40"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M10.875 15.75C10.6354 15.75 10.3958 15.6542 10.2042 15.4625L8.2875 13.5458C7.90417 13.1625 7.90417 12.5875 8.2875 12.2042C8.67083 11.8208 9.29375 11.8208 9.62917 12.2042L10.875 13.45L14.0375 10.2875C14.4208 9.90417 14.9958 9.90417 15.3792 10.2875C15.7625 10.6708 15.7625 11.2458 15.3792 11.6292L11.5458 15.4625C11.3542 15.6542 11.1146 15.75 10.875 15.75Z"
                                                                            fill="#222B40"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M11 2C11 1.44772 11.4477 1 12 1C12.5523 1 13 1.44772 13 2H14.5C14.7761 2 15 2.22386 15 2.5V3.5C15 3.77614 14.7761 4 14.5 4H9.5C9.22386 4 9 3.77614 9 3.5V2.5C9 2.22386 9.22386 2 9.5 2H11Z"
                                                                            fill="#222B40"></path>
                                                                    </g>
                                                                    <defs>
                                                                        <clipPath id="clip0_3_566">
                                                                            <rect width="24" height="24" fill="white"></rect>
                                                                        </clipPath>
                                                                    </defs>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="progress-box mt-0">
                                                            <div class="d-flex justify-content-between">
                                                                <!-- <p class="mb-0">Complete Task</p> -->
                                                                <!-- <p class="mb-0">20/28</p> -->
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-secondary"
                                                                    style="width:50%; height:5px; border-radius:4px;"
                                                                    role="progressbar"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    @elseif(session()->get('team')->department == '6790b8962ef8f2064c61d076')
                        <!-- selse manager -->
                        <!-- 1 -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header flex-wrap mb-3 ps-0">
                                        <h2 class="heading mb-0" style="font-size: 1.3rem;">SalesPulse Performance</h2>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="icon-box icon-box-lg bg-success-light rounded-circle">
                                                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M22.9715 29.3168C15.7197 29.3168 9.52686 30.4132 9.52686 34.8043C9.52686 39.1953 15.6804 40.331 22.9715 40.331C30.2233 40.331 36.4144 39.2328 36.4144 34.8435C36.4144 30.4543 30.2626 29.3168 22.9715 29.3168Z"
                                                                            stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M22.9714 23.0537C27.7304 23.0537 31.5875 19.1948 31.5875 14.4359C31.5875 9.67694 27.7304 5.81979 22.9714 5.81979C18.2125 5.81979 14.3536 9.67694 14.3536 14.4359C14.3375 19.1787 18.1696 23.0377 22.9107 23.0537H22.9714Z"
                                                                            stroke="#3AC977" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                    </svg> </div>
                                                                    <a href="{{ route($prefix.'.lead.leadTrack' )}}?dashboardStatus=newLead">
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-success count">{{ $dashboard['newLead'] }}</h3>
                                                                    <span>New Leads</span>
                                                                </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="icon-box icon-box-lg bg-primary-light rounded-circle">
                                                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M32.8961 26.5849C34.1612 26.5849 35.223 27.629 35.0296 28.8783C33.8947 36.2283 27.6026 41.6855 20.0138 41.6855C11.6178 41.6855 4.8125 34.8803 4.8125 26.4862C4.8125 19.5704 10.0664 13.1283 15.9816 11.6717C17.2526 11.3579 18.5553 12.252 18.5553 13.5605C18.5553 22.4263 18.8533 24.7197 20.5368 25.9671C22.2204 27.2145 24.2 26.5849 32.8961 26.5849Z"
                                                                            stroke="var(--primary)" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M41.1733 19.2019C41.2739 13.5059 34.2772 4.32428 25.7509 4.48217C25.0877 4.49402 24.5568 5.04665 24.5272 5.70783C24.3121 10.3914 24.6022 16.4605 24.764 19.2118C24.8134 20.0684 25.4864 20.7414 26.341 20.7907C29.1693 20.9526 35.4594 21.1736 40.0759 20.4749C40.7035 20.3802 41.1634 19.8355 41.1733 19.2019Z"
                                                                            stroke="var(--primary)" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg> </div>
                                                                    <a href="{{ route($prefix.'.lead.leadTrack' )}}?dashboardStatus=activeLead">
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-primary count">{{ $dashboard['activeLead'] }}
                                                                    </h3>
                                                                    <span>Active Leads</span>
                                                                </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="icon-box icon-box-lg bg-purple-light rounded-circle">
                                                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M22.9717 41.0539C22.9717 41.0539 37.3567 36.6983 37.3567 24.6908C37.3567 12.6814 37.878 11.7439 36.723 10.5889C35.5699 9.43391 24.858 5.69891 22.9717 5.69891C21.0855 5.69891 10.3736 9.43391 9.21863 10.5889C8.0655 11.7439 8.58675 12.6814 8.58675 24.6908C8.58675 36.6983 22.9717 41.0539 22.9717 41.0539Z"
                                                                            stroke="#BB6BD9" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path d="M26.4945 26.4642L19.4482 19.4179" stroke="#BB6BD9"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path d="M19.4487 26.4642L26.495 19.4179" stroke="#BB6BD9"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                    </svg> </div>
                                                                    <a href="{{ route($prefix.'.lead.leadTrack' )}}?dashboardStatus=pendingLead">
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-purple count">{{ $dashboard['pendingLead'] }}
                                                                    </h3>
                                                                    <span>Pending Lead</span>
                                                                </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="icon-box icon-box-lg bg-danger-light rounded-circle">
                                                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M34.0396 20.974C36.6552 20.6065 38.6689 18.364 38.6746 15.6471C38.6746 12.9696 36.7227 10.7496 34.1633 10.3296"
                                                                            stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path
                                                                            d="M37.4912 27.262C40.0243 27.6407 41.7925 28.5276 41.7925 30.3557C41.7925 31.6139 40.96 32.4314 39.6137 32.9451"
                                                                            stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M22.7879 28.0373C16.7616 28.0373 11.6147 28.9504 11.6147 32.5973C11.6147 36.2423 16.7297 37.1817 22.7879 37.1817C28.8141 37.1817 33.9591 36.2779 33.9591 32.6292C33.9591 28.9804 28.846 28.0373 22.7879 28.0373Z"
                                                                            stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M22.7876 22.8325C26.742 22.8325 29.9483 19.6281 29.9483 15.6719C29.9483 11.7175 26.742 8.51123 22.7876 8.51123C18.8333 8.51123 15.627 11.7175 15.627 15.6719C15.612 19.6131 18.7939 22.8194 22.7351 22.8325H22.7876Z"
                                                                            stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path
                                                                            d="M11.5344 20.974C8.91691 20.6065 6.90504 18.364 6.89941 15.6471C6.89941 12.9696 8.85129 10.7496 11.4107 10.3296"
                                                                            stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path
                                                                            d="M8.0825 27.262C5.54937 27.6407 3.78125 28.5276 3.78125 30.3557C3.78125 31.6139 4.61375 32.4314 5.96 32.9451"
                                                                            stroke="#FF5E5E" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                    </svg> </div>
                                                                    <a href="{{ route($prefix.'.lead.leadTrack' )}}?dashboardStatus=salesCloseLead">
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-danger count">{{ $dashboard['salseClose'] }}
                                                                    </h3>
                                                                    <span>Sales Closed</span>
                                                                </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="icon-box icon-box-lg bg-purple-light rounded-circle">
                                                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M22.9717 41.0539C22.9717 41.0539 37.3567 36.6983 37.3567 24.6908C37.3567 12.6814 37.878 11.7439 36.723 10.5889C35.5699 9.43391 24.858 5.69891 22.9717 5.69891C21.0855 5.69891 10.3736 9.43391 9.21863 10.5889C8.0655 11.7439 8.58675 12.6814 8.58675 24.6908C8.58675 36.6983 22.9717 41.0539 22.9717 41.0539Z"
                                                                            stroke="#BB6BD9" stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path d="M26.4945 26.4642L19.4482 19.4179" stroke="#BB6BD9"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                        <path d="M19.4487 26.4642L26.495 19.4179" stroke="#BB6BD9"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                    </svg> </div>
                                                                    <a href="{{ route($prefix.'.lead.leadTrack' )}}?dashboardStatus=closedLead">
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-purple count">{{ $dashboard['closeLead'] }}</h3>
                                                                    <span>Closed Lead</span>
                                                                </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="icon-box icon-box-lg bg-primary-light rounded-circle">
                                                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M32.8961 26.5849C34.1612 26.5849 35.223 27.629 35.0296 28.8783C33.8947 36.2283 27.6026 41.6855 20.0138 41.6855C11.6178 41.6855 4.8125 34.8803 4.8125 26.4862C4.8125 19.5704 10.0664 13.1283 15.9816 11.6717C17.2526 11.3579 18.5553 12.252 18.5553 13.5605C18.5553 22.4263 18.8533 24.7197 20.5368 25.9671C22.2204 27.2145 24.2 26.5849 32.8961 26.5849Z"
                                                                            stroke="var(--primary)" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M41.1733 19.2019C41.2739 13.5059 34.2772 4.32428 25.7509 4.48217C25.0877 4.49402 24.5568 5.04665 24.5272 5.70783C24.3121 10.3914 24.6022 16.4605 24.764 19.2118C24.8134 20.0684 25.4864 20.7414 26.341 20.7907C29.1693 20.9526 35.4594 21.1736 40.0759 20.4749C40.7035 20.3802 41.1634 19.8355 41.1733 19.2019Z"
                                                                            stroke="var(--primary)" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg> </div>
                                                                    <a href="{{ route($prefix.'.lead.leadTrack' )}}?dashboardStatus=totalLead">
                                                                <div class="total-projects ms-3">
                                                                    <h3 class="text-primary count">{{ $dashboard['totalLead'] }}
                                                                    </h3>
                                                                    <span>Total Leads</span>
                                                                </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- row end -->
                                        </div>
                                        <!-- dashboard left end -->

                                        <div class="col-lg-4">
                                            <div class="card">
                                                <div class="card-body" style="position: relative;overflow: hidden;">
                                                    <div id="redial" style="min-height: 141px;">
                                                        <div id="apexchartslxqbyndvi"
                                                            class="apexcharts-canvas apexchartslxqbyndvi apexcharts-theme-light"
                                                            style="width: 350px; height: 141px;">
                                                            <svg id="SvgjsSvg1067" width="350" height="141"
                                                                xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg"
                                                                xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                                                style="background: transparent;">
                                                                <g id="SvgjsG1069" class="apexcharts-inner apexcharts-graphical"
                                                                    transform="translate(100, -10)">
                                                                    <defs id="SvgjsDefs1068">
                                                                        <clipPath id="gridRectMasklxqbyndvi">
                                                                            <rect id="SvgjsRect1071" width="156" height="162" x="-3"
                                                                                y="-1" rx="0" ry="0" opacity="1" stroke-width="0"
                                                                                stroke="none" stroke-dasharray="0" fill="#fff">
                                                                            </rect>
                                                                        </clipPath>
                                                                        <clipPath id="gridRectMarkerMasklxqbyndvi">
                                                                            <rect id="SvgjsRect1072" width="154" height="164" x="-2"
                                                                                y="-2" rx="0" ry="0" opacity="1" stroke-width="0"
                                                                                stroke="none" stroke-dasharray="0" fill="#fff">
                                                                            </rect>
                                                                        </clipPath>
                                                                        <linearGradient id="SvgjsLinearGradient1077" x1="1" y1="0"
                                                                            x2="0" y2="1">
                                                                            <stop id="SvgjsStop1078" stop-opacity="1"
                                                                                stop-color="rgba(241,234,255,1)" offset="0.64">
                                                                            </stop>
                                                                            <stop id="SvgjsStop1079" stop-opacity="1"
                                                                                stop-color="rgba(243,237,255,1)" offset="0.43">
                                                                            </stop>
                                                                            <stop id="SvgjsStop1080" stop-opacity="1"
                                                                                stop-color="rgba(243,237,255,1)" offset="0.64">
                                                                            </stop>
                                                                            <stop id="SvgjsStop1081" stop-opacity="1"
                                                                                stop-color="rgba(241,234,255,1)" offset="0.005">
                                                                            </stop>
                                                                        </linearGradient>
                                                                        <linearGradient id="SvgjsLinearGradient1088" x1="1" y1="0"
                                                                            x2="0" y2="1">
                                                                            <stop id="SvgjsStop1089" stop-opacity="1"
                                                                                stop-color="rgba(122,132,155,1)" offset="0.64">
                                                                            </stop>
                                                                            <stop id="SvgjsStop1090" stop-opacity="1"
                                                                                stop-color="rgba(142,150,170,1)" offset="0.43">
                                                                            </stop>
                                                                            <stop id="SvgjsStop1091" stop-opacity="1"
                                                                                stop-color="rgba(142,150,170,1)" offset="0.64">
                                                                            </stop>
                                                                            <stop id="SvgjsStop1092" stop-opacity="1"
                                                                                stop-color="rgba(122,132,155,1)" offset="0.005">
                                                                            </stop>
                                                                        </linearGradient>
                                                                    </defs>
                                                                    <g id="SvgjsG1073" class="apexcharts-radialbar">
                                                                        <g id="SvgjsG1074">
                                                                            <g id="SvgjsG1075" class="apexcharts-tracks">
                                                                                <g id="SvgjsG1076"
                                                                                    class="apexcharts-radialbar-track apexcharts-track"
                                                                                    rel="1">
                                                                                    <path id="apexcharts-radialbarTrack-0"
                                                                                        d="M 74.99999999999999 127.71951219512195 A 52.71951219512196 52.71951219512196 0 1 1 75.0920128600705 127.71943189873346"
                                                                                        fill="none" fill-opacity="1"
                                                                                        stroke="rgba(241,234,255,0.85)"
                                                                                        stroke-opacity="1" stroke-linecap="butt"
                                                                                        stroke-width="11.634146341463415"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-radialbar-area"
                                                                                        data:pathOrig="M 74.99999999999999 127.71951219512195 A 52.71951219512196 52.71951219512196 0 1 1 75.0920128600705 127.71943189873346">
                                                                                    </path>
                                                                                </g>
                                                                            </g>
                                                                            <g id="SvgjsG1083">
                                                                                <g id="SvgjsG1087"
                                                                                    class="apexcharts-series apexcharts-radial-series"
                                                                                    seriesName="AveragexResults" rel="1"
                                                                                    data:realIndex="0">
                                                                                    <path id="SvgjsPath1093"
                                                                                        d="M 74.99999999999999 127.71951219512195 A 52.71951219512196 52.71951219512196 0 1 1 127.71951219512195 75"
                                                                                        fill="none" fill-opacity="0.85"
                                                                                        stroke="url(#SvgjsLinearGradient1088)"
                                                                                        stroke-opacity="1" stroke-linecap="butt"
                                                                                        stroke-width="11.634146341463415"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-radialbar-area apexcharts-radialbar-slice-0"
                                                                                        data:angle="270" data:value="75" index="0"
                                                                                        j="0"
                                                                                        data:pathOrig="M 74.99999999999999 127.71951219512195 A 52.71951219512196 52.71951219512196 0 1 1 127.71951219512195 75">
                                                                                    </path>
                                                                                </g>
                                                                                <circle id="SvgjsCircle1084" r="26.902439024390247"
                                                                                    cx="75" cy="75"
                                                                                    class="apexcharts-radialbar-hollow"
                                                                                    fill="transparent"></circle>
                                                                                <g id="SvgjsG1085"
                                                                                    class="apexcharts-datalabels-group"
                                                                                    transform="translate(0, 0) scale(1)"
                                                                                    style="opacity: 1;"><text id="SvgjsText1086"
                                                                                        font-family="Helvetica, Arial, sans-serif"
                                                                                        x="75" y="80" text-anchor="middle"
                                                                                        dominant-baseline="auto" font-size="24px"
                                                                                        font-weight="600" fill="#000000"
                                                                                        class="apexcharts-text apexcharts-datalabel-value"
                                                                                        style="font-family: Helvetica, Arial, sans-serif;">{{ round($dashboard['lsr']) }}%</text>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <line id="SvgjsLine1094" x1="0" y1="0" x2="150" y2="0"
                                                                        stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                                                        class="apexcharts-ycrosshairs"></line>
                                                                    <line id="SvgjsLine1095" x1="0" y1="0" x2="150" y2="0"
                                                                        stroke-dasharray="0" stroke-width="0"
                                                                        class="apexcharts-ycrosshairs-hidden"></line>
                                                                </g>
                                                                <g id="SvgjsG1070" class="apexcharts-annotations"></g>
                                                            </svg>
                                                            <div class="apexcharts-legend"></div>
                                                        </div>
                                                    </div>
                                                    <span class="right-sign">
                                                        <svg width="93" height="93" viewBox="0 0 93 93" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <g filter="url(#filter0_d_3_700)">
                                                                <circle cx="46.5" cy="31.5" r="16.5" fill="#fc7035"></circle>
                                                            </g>
                                                            <g clip-path="url(#clip0_3_700)">
                                                                <path
                                                                    d="M52.738 25.3524C53.0957 24.9315 53.7268 24.8804 54.1476 25.2381C54.5684 25.5957 54.6196 26.2268 54.2619 26.6476L45.7619 36.6476C45.3986 37.0751 44.7549 37.1201 44.3356 36.7474L39.8356 32.7474C39.4228 32.3805 39.3857 31.7484 39.7526 31.3356C40.1195 30.9229 40.7516 30.8857 41.1643 31.2526L44.9002 34.5733L52.738 25.3524Z"
                                                                    fill="#222B40"></path>
                                                            </g>
                                                            <defs>
                                                                <filter id="filter0_d_3_700" x="0" y="0" width="93" height="93"
                                                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                                    <feFlood flood-opacity="0" result="BackgroundImageFix">
                                                                    </feFlood>
                                                                    <feColorMatrix in="SourceAlpha" type="matrix"
                                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                        result="hardAlpha"></feColorMatrix>
                                                                    <feOffset dy="15"></feOffset>
                                                                    <feGaussianBlur stdDeviation="15"></feGaussianBlur>
                                                                    <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                                    <feColorMatrix type="matrix"
                                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0">
                                                                    </feColorMatrix>
                                                                    <feBlend mode="normal" in2="BackgroundImageFix"
                                                                        result="effect1_dropShadow_3_700"></feBlend>
                                                                    <feBlend mode="normal" in="SourceGraphic"
                                                                        in2="effect1_dropShadow_3_700" result="shape"></feBlend>
                                                                </filter>
                                                                <clipPath id="clip0_3_700">
                                                                    <rect width="24" height="24" fill="white"
                                                                        transform="translate(35 19)"></rect>
                                                                </clipPath>
                                                            </defs>
                                                        </svg> </span>
                                                    <div class="redia-date text-center mt-0">
                                                        <h4>LSR (Leads To Sales Ratio)</h4>
                                                        <!-- <p> Lorem ipsum dolor sit amet, consectetur </p>
                                                    <a href="#" class="btn btn-secondary text-black">More
                                                    Details</a>  -->
                                                    </div>
                                                    <div class="resize-triggers">
                                                        <div class="expand-trigger">
                                                            <div style="width: 386px; height: 214px;"></div>
                                                        </div>
                                                        <div class="contract-trigger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- colmn end -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif
                @endif

            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal20067b6aba993236d3851041b62" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Attendance Entry Form 
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 text-center" bis_skin_checked="1">
                        <div class="mb-3" bis_skin_checked="1">
                            <label class="form-label">Today Time </label>
                            <input type="hidden" value="{{ date('d-m-Y H:i') }}" class="form-control" readonly required>
                            {{ date('h:i A') }}
                        </div>
                    </div>
                    <div class="col-xl-12" bis_skin_checked="1"></div>
                    <form id="formSubmit" action="{{ url($prefix . ('/attendance/good-morning-good-night')) }}"
                        data-parsley-validate method="post">
                        @csrf
                        @if($attendance)
                            @if($attendance->goodMoringDateTime)
                                <input type="hidden" name="attendanceId" value="{{ $attendance->_id }}">
                                <div class="col-xl-12" bis_skin_checked="1">
                                    <div class="mb-3" bis_skin_checked="1">
                                        <textarea class="form-control" name="goodNightMessage"
                                            placeholder="Enter Message,If Any?"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-12 text-center" bis_skin_checked="1">
                                    <button class="btn btn-primary ">Good Night</button>
                                </div>

                            @endif

                        @else
                            <div class="col-xl-12 text-center" bis_skin_checked="1">
                                <button class="btn btn-primary ">Good Morning</button>
                            </div>
                        @endif


                    </form>
                </div>
            </div>

        </div>
    </div>



@endsection
@section('javascript')
    <script>
        $(function () {
            $('#formSubmit').parsley().on('field:validated', function () {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            })
                .on('form:submit', function () {
                    $('#spiner').css('display', 'flex');
                });
        });
    </script>

@endsection