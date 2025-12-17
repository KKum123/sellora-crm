@extends('admin.layouts.master')
@section('content')
@if(session()->has('admin'))
@php $prefix = 'admin'; @endphp
@elseif(session()->has('branch'))
@php $prefix = 'branch'; @endphp
@elseif(session()->has('team')) 
@php $prefix = 'team'; @endphp
@endif
<div class="content-body">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">View (S&O) Team</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <form method="get">
                  <div class="row">
                    
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Filter By Name</label>
                        <input type="text" class="form-control" name="name" value="{{ Request::get('name') }}" >
                      </div>
                    </div>
                    @if(session()->has('team') && (string) session()->get('team')->designation=='6790b9662ef8f2064c61d07e')
                            <!-- sales manager if login dont show action -->
                    @else
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Department</label>                        
                        <select class="form-select" name="department">
                             <option value="">All</option>
                            @foreach ($department as $key=>$val)
                                <option value="{{ $val->_id }}" {{ Request::get('department') == $val->_id ? 'selected' : '' }}>{{ $val->name }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    @endif
                    <div class="col-md-2">
                      <label class="form-label d-block">&nbsp;</label>
                      <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end -->
        
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">List</h4>
            </div>
            <div class="card-body"> 
            

              <div class="row">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-styling table-hover table-striped table-primary">
                      <thead>
                        <tr>
                          <th width="50">SN.</th>
                          @if(session()->has('admin'))
                           <th width="230">Branch</th>
                          @endif
                           <th width="230">Employee Code</th>
                          
                           @if(session()->has('team') && (string) session()->get('team')->designation=='6790b9662ef8f2064c61d07e')
                            <!-- sales manager if login dont show action -->
                           @else
                           <th width="50">Action</th>
                           @endif
                          <th width="230">Details</th>
                          <!-- <th width="100">Employee Code</th> -->
                          <th width="200">Designation</th>
                          <th width="200">Department</th>
                          <th>Password</th>
                          
                          
                          <th width="50">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                       @foreach($List as $key=>$val)
                       @if(session()->has('team') && (string) session()->get('team')->designation == '6790b9662ef8f2064c61d07e' &&  session()->has('team') && (string) session()->get('team')->_id == (string) $val->_id)
                            <!-- sales manager if self login don't show action -->
                          @continue
                        @endif
                        <tr>
                          <td>{{ $key + $List->firstItem() }}.</td>
                          @if(session()->has('admin'))
                          <td>{{ !empty($val->branches) ? $val->branches->branch_name : '--' }}</td>
                          @endif
                          <td>
                            @if(session()->has('admin') || session()->has('branch') || session()->has('team') && session()->get('team')->department == '6790b8df2ef8f2064c61d079') 
                            <!-- team only  Hr-->
                                <a href="{{ route($prefix.'.team.profileView', $val->_id) }}" style="color: {{ empty($val->joinDate) ? '#fc7035' : '#178715'}};">{{!empty($val->employee_code) ? $val->employee_code : '---'}}</a>
                            @else
                                {{!empty($val->employee_code) ? $val->employee_code : '---'}}
                            @endif
                          </td>
                         
                      @if(session()->has('team') && (string) session()->get('team')->designation=='6790b9662ef8f2064c61d07e')
                      <!-- sales manager if login dont show action -->
                      @else  
                      <td valign="top">
                          @if(session()->has('team')  && (string) session()->get('team')->department == '6790b8df2ef8f2064c61d079')
                            <a href="{{ route($prefix.'.opsPemployeeManagementuls.updateTeam', $val->_id) }}"> <i class="ri-edit-line"></i></a>
                            <a href="{{ route($prefix.'.opsPemployeeManagementuls.deleteTeam', $val->_id) }}" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                           @else   

                          <a href="{{ route($prefix.'.team.updateTeam', $val->_id) }}"> <i class="ri-edit-line"></i></a>
                          <a href="{{ route($prefix.'.team.deleteTeam', $val->_id) }}" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                          </td> 
                          @endif
                         
                      @endif
                            
                          <td valign="top"><strong>{{ $val->name }}</strong><br>
                            <i class="ri-mail-line"></i> {{ $val->email }}<br>
                            <i class="ri-smartphone-line"></i> {{ $val->mobile }}<br></td>
                          <!-- <td valign="top">{{ $val->employee_code }}</td> -->
                          <td valign="top">{{ $val->designation1 ? $val->designation1->name : 'N/A' }}
                          @if(session()->has('team') && (string) session()->get('team')->designation=='6790b9662ef8f2064c61d07e')
                          <!-- sales manager if login dont show action -->
                          @else  
                            @if(session()->has('admin') || session()->has('branch') || session()->has('team') && session()->get('team')->department=='67bd6d68d4de44c0093ea46f' || session()->has('team') && session()->get('team')->department=='67bd3cd7d4de44c0093ea46d' || session()->has('team') && session()->get('team')->department=='67bd3ca8d4de44c0093ea46c' || session()->has('team') && session()->get('team')->department=='6790b9142ef8f2064c61d07d'  || session()->has('team') && session()->get('team')->department=='6790b8df2ef8f2064c61d079' || session()->has('team') && session()->get('team')->designation == '6790b9662ef8f2064c61d07e')
                          
                            <div class="d-flex"><a href="{{route($prefix.'.team.teamPermission')}}?team={{$val->_id}}&department={{$val->department}}">Get Permission</a></div>
                            @endif
                          @endif
                          </td>
                          <td valign="top">{{ $val->department1 ? $val->department1->name : 'N/A' }}</td>   
                          <td valign="top">{{ base64_decode($val->show_password) }}</td>
                          
                          
                          <td>
                        @if($val->status==1)
                            <a  style="color: green">Active</a>
                        @else
                        <a  style="color: red">Deactive</a>
                        @endif
                        </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    <br>
                    <div class="pagination pagination-sm float-right paging">
                    {!! $List->links() !!}  
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end --> 
        
      </div>
    </div>
  </div>
  
@endsection
@section('javascript')
@endsection