<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        @if (session()->has('admin'))
                            @if (session()->get('admin')->role == 'Admin')
                                Super Admin
                            @else
                                Sub Admin ({{session()->get('admin')->name}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<sapn
                                    style="color: rgb(220, 134, 59)">Emp Code - </sapn>{{session()->get('admin')->employeeCode}} )
                            @endif
                        @elseif(session()->has('branch'))
                            Branch - {{session()->get('branch')->branch_name}} ({{session()->get('branch')->manager_name}}
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<sapn style="color: rgb(220, 134, 59)">Branch Code - </sapn>
                            {{session()->get('branch')->branch_code}} )
                        @elseif(session()->has('team'))


                            @php 
                                $designationName = \App\Models\ERP\Designation::where('_id', new \MongoDB\BSON\ObjectId(session()->get('team')->designation))->value('name') ?? '';
                            @endphp
                            {{$designationName}} ({{session()->get('team')->name}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<sapn
                                style="color: rgb(220, 134, 59)">Emp Code - </sapn>{{session()->get('team')->employee_code}} )
                        @endif
                    </div>
                </div>
                <div class="header-right d-flex align-items-center">

                    <ul class="navbar-nav">
                        <li class="nav-item dropdown notification_dropdown"> <a class="nav-link"
                                href="javascript:void(0);" role="button" data-bs-toggle="dropdown"
                                title="Notifications"> <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M17.5 12H19C19.8284 12 20.5 12.6716 20.5 13.5C20.5 14.3284 19.8284 15 19 15H6C5.17157 15 4.5 14.3284 4.5 13.5C4.5 12.6716 5.17157 12 6 12H7.5L8.05827 6.97553C8.30975 4.71226 10.2228 3 12.5 3C14.7772 3 16.6903 4.71226 16.9417 6.97553L17.5 12Z"
                                        fill="#222B40" />
                                    <path opacity="0.3"
                                        d="M14.5 18C14.5 16.8954 13.6046 16 12.5 16C11.3954 16 10.5 16.8954 10.5 18C10.5 19.1046 11.3954 20 12.5 20C13.6046 20 14.5 19.1046 14.5 18Z"
                                        fill="#222B40" />
                                </svg> </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div id="DZ_W_Notification1" class="widget-media dz-scroll p-2" style="height:380px;">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2"> <img alt="image" width="50"
                                                        src="{{ url('/admin') }}/images/avatar/1.jpg"> </div>
                                                <div class="media-body">
                                                    <h6 class="mb-1">Dr sultads Send you Photo</h6>
                                                    <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <a class="all-notification" href="javascript:void(0);">See all
                                    notifications <i class="ti-arrow-end"></i></a>
                            </div>
                        </li>
                        <li class="nav-item ps-3">
                            <div class="dropdown header-profile2"> <a class="nav-link" href="javascript:void(0);"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="header-info2 d-flex align-items-center">
                                        <div class="header-media"> <img src="{{ url('/admin') }}/images/user.jpg"
                                                alt=""> </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="card border-0 mb-0">
                                        <div class="card-header py-2">
                                            <div class="products"><img src="{{ url('/admin') }}/images/user.jpg"
                                                    class="avatar avatar-md" alt="">
                                                <div>
                                                    @if(session()->has('team'))
                                                        {{session()->get('team')->name}} Emp
                                                        ID-{{session()->get('team')->employee_code}}
                                                    @else
                                                        @if(session()->has('branch'))
                                                        {{ session()->get('branch')->manager_name }} <br>Code- {{session()->get('branch')->branch_code}}
                                                        @else
                                                         <h6>Super Admin </h6>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer px-0 py-2">
                                            @if (session()->has('admin'))
                                                <a href="{{ route('admin.change.password') }}" class="dropdown-item ai-icon"> <i class="fa fa-lock"
                                                        style="color: #fc7035;"></i> <span class="ms-2 text-danger">Change
                                                        Password</span></a>

                                                <a href="{{ route('admin.logout') }}" class="dropdown-item ai-icon">
                                                    <svg class="logout-svg" xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4">
                                                        </path>
                                                        <polyline points="16 17 21 12 16 7"></polyline>
                                                        <line x1="21" y1="12" x2="9" y2="12">
                                                        </line>
                                                    </svg> <span class="ms-2 text-danger">Logout </span>
                                                </a>
                                            @elseif(session()->has('branch'))
                                                <a href="{{ route('branch.change.password') }}" class="dropdown-item ai-icon"> <i class="fa fa-lock"
                                                        style="color: #fc7035;"></i> <span class="ms-2 text-danger">Change
                                                        Password</span></a>

                                                <a href="{{ route('branch.logout') }}" class="dropdown-item ai-icon">
                                                    <svg class="logout-svg" xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4">
                                                        </path>
                                                        <polyline points="16 17 21 12 16 7"></polyline>
                                                        <line x1="21" y1="12" x2="9" y2="12">
                                                        </line>
                                                    </svg> <span class="ms-2 text-danger">Logout </span>
                                                </a>
                                            @elseif(session()->has('team'))
                                                <a href="{{ route('team.change.password') }}" class="dropdown-item ai-icon"> <i class="fa fa-lock"
                                                        style="color: #fc7035;"></i> <span class="ms-2 text-danger">Change
                                                        Password</span></a>

                                                <a href="{{ route('team.logout') }}" class="dropdown-item ai-icon">
                                                    <svg class="logout-svg" xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4">
                                                        </path>
                                                        <polyline points="16 17 21 12 16 7"></polyline>
                                                        <line x1="21" y1="12" x2="9" y2="12">
                                                        </line>
                                                    </svg> <span class="ms-2 text-danger">Logout </span>
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>