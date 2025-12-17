  @if (session()->has('admin'))
  @if(session()->get('admin')->role == 'Sub Admin')
      <div class="deznav">
          <div class="deznav-scroll">
              <ul class="metismenu" id="menu">
                  <li><a href="{{ route('admin.dashboard') }}" class="" aria-expanded="false"> <i
                              class="ri-home-2-line"></i> <span class="nav-text">Dashboard</span> </a> </li>
                   
                  <!-- <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i><span class="nav-text">Branch</span> </a>
                      <ul>
                          <li><a href="{{ route('admin.branch.addBranch') }}">Add Branch</a> </li>
                          <li><a href="{{ route('admin.branch.viewBranch') }}">View Branch</a> </li>
                      </ul>
                  </li> -->
                  <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                          <i class="ri-user-line"></i> <span class="nav-text"> Team</span>
                      </a>
                      <ul aria-expanded="false">
                          <li><a href="{{ route('admin.team.addTeam') }}">Add  Team</a></li>
                          <li><a href="{{ route('admin.team.listTeam') }}">View  Team</a></li>
                      </ul>
                  </li>
                  <li> <a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i>
                          <span class="nav-text">SalesPulse</span> </a>
                      <ul class="pcoded-submenu">
                          <li> <a href="{{ route('admin.sales.salePlusManager') }}">Sales Manager</a> </li>
                          <li> <a href="{{ route('admin.sales.salePlusTeam') }}">Sales Team</a> </li>
                          <li> <a href="{{ route('admin.sales.salePlusReport') }}">Sales Report</a> </li> 
                          <li> <a href="{{ route('admin.sales.untouched') }}">Untouched Lead</a> </li> 
                      </ul>
                  </li>
                  <li> <a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i>
                          <span class="nav-text">OpsPuls</span> </a>
                      <ul class="pcoded-submenu">
                          <li> <a href="{{ route('admin.opsPuls.OpsPulsManager') }}">Operation Manager</a></li>
                          <li> <a href="{{ route('admin.opsPuls.OpsPulsTeam') }}">Operation Team</a></li>
                          <li> <a href="{{ route('admin.task-pulse.taskFlowReport') }}">Client Report</a> </li>
                          <li> <a href="{{ route('admin.task-pulse.untuchedClient') }}">Untouched Client</a> </li>
                          
                          <li> <a href="{{ route('admin.task-pulse.taskGiven') }}">Client Given</a> </li>
                          
                          <li> <a href="{{ route('admin.opsPuls.addClient') }}">Add Client</a> </li>
                          <li> <a href="{{ route('admin.task-pulse.unassignedClient') }}">Unassigned Client</a> </li>
                          
                      </ul>
                  </li>
                  <li> <a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i>
                          <span class="nav-text">Lead Management</span> </a>
                      <ul class="pcoded-submenu">
                          <li><a href="{{ route('admin.lead.addLead') }}">Add Lead</a></li>
                          <li><a href="{{ route('admin.lead.listLead') }}">Unassigned Leads</a></li>
                          <li><a href="{{ route('admin.lead.leadTrack') }}">Lead Track Report</a></li>
                          
                      </ul>
                  </li>
                  
              </ul>
          </div>
      </div>
  @elseif(session()->get('admin')->role == 'Admin')
  <div class="deznav">
          <div class="deznav-scroll">
              <ul class="metismenu" id="menu">
                  <!-- <li class="menu-title">YOUR COMPANY</li> -->
                  <li><a href="{{ route('admin.dashboard') }}" class="" aria-expanded="false"> <i
                              class="ri-home-2-line"></i> <span class="nav-text">Dashboard</span> </a> </li>
                    <!-- <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i><span class="nav-text">Sub Admin</span> </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin.subadmin.sub-admin') }}">Create Sub Admin</a></li>
                            <li><a href="{{ route('admin.subadmin.list') }}">View Sub Admin</a></li>
                        </ul>
                     </li>  -->
                  <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i><span class="nav-text">Branch</span> </a>
                      <ul>
                          <li><a href="{{ route('admin.branch.addBranch') }}">Add Branch</a> </li>
                          <li><a href="{{ route('admin.branch.viewBranch') }}">View Branch</a> </li>
                      </ul>
                  </li>
                  <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                          <i class="ri-user-line"></i> <span class="nav-text"> Team</span>
                      </a>
                      <ul aria-expanded="false">
                          <li><a href="{{ route('admin.team.addTeam') }}">Add  Team</a></li>
                          <li><a href="{{ route('admin.team.listTeam') }}">View  Team</a></li>
                      </ul>
                  </li>
                  <li> <a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i>
                          <span class="nav-text">SalesPulse</span> </a>
                      <ul class="pcoded-submenu">
                          <li> <a href="{{ route('admin.sales.salePlusManager') }}">Sales Manager</a> </li>
                          <li> <a href="{{ route('admin.sales.salePlusTeam') }}">Sales Team</a> </li>
                          <li> <a href="{{ route('admin.sales.salePlusReport') }}">Sales Report</a> </li> 
                          <li> <a href="{{ route('admin.sales.untouched') }}">Untouched Lead</a> </li> 
                    
                    </ul>
                  </li>
                  <li> <a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i>
                          <span class="nav-text">OpsPuls</span> </a>
                      <ul class="pcoded-submenu">
                          <li> <a href="{{ route('admin.opsPuls.OpsPulsManager') }}">Operation Manager</a></li>
                          <li> <a href="{{ route('admin.opsPuls.OpsPulsTeam') }}">Operation Team</a></li>
                          <li> <a href="{{ route('admin.task-pulse.taskFlowReport') }}">Client Report</a> </li>
                          <li> <a href="{{ route('admin.task-pulse.untuchedClient') }}">Untouched Client</a> </li>
                          
                          <li> <a href="{{ route('admin.task-pulse.taskGiven') }}">Given Task</a> </li>
                          
                          <li> <a href="{{ route('admin.opsPuls.addClient') }}">Add Client</a> </li>
                          <li> <a href="{{ route('admin.task-pulse.unassignedClient') }}">Unassigned Client</a> </li>
                          
                        </ul>
                  </li>
                  <li> <a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i>
                          <span class="nav-text">Lead Management</span> </a>
                      <ul class="pcoded-submenu">
                          <li><a href="{{ route('admin.lead.addLead') }}">Add Lead</a></li>
                          <li><a href="{{ route('admin.lead.listLead') }}">Unassigned Leads</a></li>
                          <li><a href="{{ route('admin.lead.leadTrack') }}">Lead Track Report</a></li>
                          
                      </ul>
                  </li>
                  <li> <a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i>
                          <span class="nav-text">Assign Task</span> </a>
                      <ul class="pcoded-submenu">
                          <li><a href="{{ route('admin.task.addTask') }}">Add Task</a></li>
                          <li><a href="{{ route('admin.task.listTask') }}">Task List</a></li>
                      </ul>
                  </li>
                  <li> <a href="{{ route('admin.departmentPermission')}}">
                    <i class="ri-user-line"></i>
                        Department Permission
                    </a> 
                </li>
              </ul>
          </div>
      </div>
  @endif
  @elseif (session()->has('branch'))
      <div class="deznav">
          <div class="deznav-scroll">
              <ul class="metismenu" id="menu">

                  <li><a href="{{ route('branch.dashboard') }}" class="" aria-expanded="false"> <i
                              class="ri-home-2-line"></i> <span class="nav-text">Dashboard</span> </a> </li>

                <!-- <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i><span class="nav-text">Branch Sub Admin</span> </a>
                      <ul>
                          <li><a href="{{ route('branch.branch.addBranch') }}">Add Sub Branch</a> </li>
                          <li><a href="{{ route('branch.branch.viewBranch') }}">View View Branch</a> </li>
                      </ul>
                  </li> -->
                  <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                          <i class="ri-user-line"></i> <span class="nav-text"> Team</span>
                      </a>
                      <ul aria-expanded="false">
                          <li><a href="{{ route('branch.team.addTeam') }}">Add  Team</a></li>
                          <li><a href="{{ route('branch.team.listTeam') }}">View  Team</a></li>
                      </ul>
                  </li>
                  <li> <a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i>
                          <span class="nav-text">SalesPulse</span> </a>
                      <ul class="pcoded-submenu">
                          <li> <a href="{{ route('branch.sales.salePlusManager') }}">Sales Manager</a> </li>
                          <li> <a href="{{ route('branch.sales.salePlusTeam') }}">Sales Team</a> </li>
                          <li> <a href="{{ route('branch.sales.salePlusReport') }}">Sales Report</a> </li> 
                          <li> <a href="{{ route('branch.sales.untouched') }}">Untouched Lead</a> </li> 
                      </ul>
                  </li>
                  <li> <a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i>
                          <span class="nav-text">OpsPuls</span> </a>
                      <ul class="pcoded-submenu">
                          <li> <a href="{{ route('branch.opsPuls.OpsPulsManager') }}">Operation Manager</a></li>
                          <li> <a href="{{ route('branch.opsPuls.OpsPulsTeam') }}">Operation Team</a></li>
                          <li> <a href="{{ route('branch.task-pulse.taskFlowReport') }}">Client Report</a> </li>
                          <li> <a href="{{ route('branch.task-pulse.moveBranchTaskFlowReport') }}">Move Branch Client Report</a> </li>
                          
                          <li> <a href="{{ route('branch.task-pulse.untuchedClient') }}">Untouched Client</a> </li>
                          
                          <li> <a href="{{ route('branch.task-pulse.taskGiven') }}">Given Task</a> </li>
                          
                          <li> <a href="{{ route('branch.opsPuls.addClient') }}">Add Client</a> </li>
                          <li> <a href="{{ route('branch.task-pulse.unassignedClient') }}">Unassigned Client</a> </li>
                          
                        </ul>
                  </li>

                  <li> <a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i>
                          <span class="nav-text">Lead Management</span> </a>
                      <ul class="pcoded-submenu">
                          <li><a href="{{ route('branch.lead.addLead') }}">Add Lead</a></li>
                          <li><a href="{{ route('branch.lead.listLead') }}">Unassigned Leads</a></li>
                          <li><a href="{{ route('branch.lead.leadTrack') }}">Lead Track Report</a></li>
                      </ul>
                  </li>

                  <li> <a class="has-arrow" href="javascript:void(0);" aria-expanded="false"> <i
                              class="ri-user-line"></i>
                          <span class="nav-text">Assign Task</span> </a>
                      <ul class="pcoded-submenu">
                          <li><a href="{{ route('branch.task.addTask') }}">Add Task</a></li>
                          <li><a href="{{ route('branch.task.listTask') }}">Task List</a></li>
                      </ul>
                  </li>
              </ul>
          </div>
      </div>
  @elseif (session()->has('team'))
      
      
          <div class="deznav">
              <div class="deznav-scroll">
                  <ul class="metismenu" id="menu">
                   
                    
                    @php 
                        $team_id = session()->get('team')->id;
                        $teamPermissionData = \App\Models\ERP\TeamPermission::where('teamId', new \MongoDB\BSON\ObjectId($team_id))->first();
                       
                        $menuList = \App\Models\ERP\Menu::whereIn('_id', $teamPermissionData->parentId)->orderBy('orderByM','asc')->get();
                       
                    @endphp

                        @foreach($menuList as $key=>$menu)
                        @if(empty($menu->routeName) )
                            <li>
                              
                                <a href="{{ !empty($menu->routeName) ? route('team.'.$menu->routeName) : 'javascript:void(0);' }}" class="has-arrow" aria-expanded="false">
                                     <i class="ri-user-line"></i> <span class="nav-text">{{$menu->name}}</span> </a> 
                             <ul>
                                    @php
                                        $childData = \App\Models\ERP\MenuRoute::where('parentId', new \MongoDB\BSON\ObjectId($menu->_id))->whereIn('_id', $teamPermissionData->childId)->where(['isMenu'=>'1','isVisible'=>'1'])->orderBy('orderByS','asc')->get();
                                    @endphp
                                    @foreach ($childData as $k=>$v)
                                    <li>
                                     
                                    <a href="{{!empty($v->routeName)? route('team.'.$v->routeName):'#' }}">{{$v->name}}</a></li> 
                                    @endforeach
                                </ul>
                            </li>
                                @else
                                <li>
                                
                                    <a href="{{ !empty($menu->routeName) ? route('team.'.$menu->routeName) : 'javascript:void(0);' }}" class="" aria-expanded="false"> <i
                                        class="ri-home-2-line"></i> <span class="nav-text">{{$menu->name}}</span> </a> 
                                </li>
                                @endif
                        @endforeach
                   
                  </ul>
              </div>
          </div>
      
  @endif