@extends('admin.layouts.master')
@section('content')

@if(session()->has('admin'))
@php $prefix = 'admin'; @endphp
@elseif(session()->has('branch'))
@php $prefix = 'branch'; @endphp
@elseif(session()->has('team')) 
@php $prefix = 'team';@endphp
@endif

<div class="content-body" style="min-height: 235px;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Ex - Employee</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <form  method="get">
                  <div class="row">
                    <div class="col-md-3">

                      <div class="form-group">
                        <label class="form-label">Employee Name</label>
                        <div class="dropdown bootstrap-select default-select form-control wide">
                          <input type="text" name="name" class="form-control" value="{{Request::get('name')}}">
                      </div>
                      </div>
                  </div>
                     <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Email ID</label>
                        <div class="dropdown bootstrap-select default-select form-control wide">
                         
                        <input type="text" class="form-control" name="email" value="{{Request::get('email')}}">

                      </div>
                    </div>
                    </div>
                     <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Phone</label>
                        <div class="dropdown bootstrap-select default-select form-control wide">
                         <input type="text" maxlength="10" class="form-control"  onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" name="phone" value="{{Request::get('phone')}}">

                      </div>
                    </div>
                  </div>

                    
                    <div class="col-md-2">
                      <label class="form-label d-block">&nbsp;</label>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end -->
        
        <div class="col-lg-12">
          <div class="card">
            <!-- <div class="card-header">
              <h4 class="card-title">View All Lead</h4>
            </div> -->

            
            <div class="card-body"> 
              <h5>Employee List</h5><hr>
              
              <div class="row" style="margin-bottom: 10px;">
                <div class="col-sm-12 col-md-5">
                  <h5></h5>
                </div>
                <div class="col-sm-12 col-md-7">
                  <div class="row">
                    <div class="col-lg-4 offset-lg-5">
                                      
                    </div>
                    
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xl-12">
                  <div class="table-responsive">
                 

                    <table class="table table-bordered table-styling table-hover table-striped table-primary">
                      <thead>
                        <tr>
                          <th width="50">SN.</th>
                          <th>Employee Code</th>
                          <th width="230">Details</th>
                          <!-- <th width="100">Employee Code</th> -->
                          <th width="200">Designation</th>
                          <th width="200">Department</th>
                          <!-- <th>Password</th> -->
                          <th>Joining Date</th>
                          <th>Drop Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($exEmployee as $key=>$val)
                        
                        <tr>
                          <td>{{$key + $exEmployee->firstItem()}}.</td>
                          <td><a href="{{ route($prefix.'.team.profileView', $val->employee->_id) }}">#{{!empty($val->employee->employee_code) ? $val->employee->employee_code : '--'}}</a> </td>
                          <td valign="top"><strong>{{!empty($val->employee) ? $val->employee->name : ''}}</strong><br>
                            <i class="ri-mail-line"></i> {{!empty($val->employee) ? $val->employee->email : ''}}<br>
                            <i class="ri-smartphone-line"></i> {{!empty($val->employee) ? $val->employee->mobile : ''}}<br></td>
                          <!-- <td valign="top">{{!empty($val->employee) ? $val->employee->employee_code : ''}}</td> -->
                          <td valign="top">{{!empty($val->designations) ? $val->designations->name : '' }}</td>
                          <td valign="top">{{!empty($val->departments) ? $val->departments->name : ''}}</td>
                          <!-- <td valign="top">Sandeep@123</td> -->
                          <td><strong>{{!empty($val->employee->joinDate) ? date('d M Y', strtotime($val->employee->joinDate)) : '--'}}</strong></td>
                          <td><strong>{{date('d M Y', strtotime($val->LastWorkingDay))}}</strong></td>
                          
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                          {!! $exEmployee->links() !!}                                
                  </div>
                  <!-- responsive table end --> 
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end --> 
        
      </div>
  
@endsection
@section('javascript')
@endsection