@extends('admin.layouts.master')
@section('content')
@if (session()->has('admin'))
@php $prefix = 'admin'; @endphp
@elseif(session()->has('branch'))
@php $prefix = 'branch'; @endphp
@elseif(session()->has('team'))
@php $prefix = 'team'; @endphp
@endif
@php 
use MongoDB\BSON\ObjectId;
@endphp
<div class="content-body" style="min-height: 235px;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Sales Person Report</h4>
            </div>
            <form >
            <div class="card-body">
              <div class="form-validation">
                <div class="needs-validation">
                  <div class="row">
                  @if(!session()->has('branch'))
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Filter Branch</label>
                        <select class="form-select" name="branch_id">
                             <option value="">Select</option>
                             @foreach ($branch as $key=>$val)
                                <option value="{{$val->_id}}" {{ Request::get('branch_id') == $val->_id ? 'selected' : ''}}>{{$val->branch_name}} ({{$val->branch_code}})</option>
                            @endforeach
                             
                        </select>
                      </div>
                    </div>
                  @endif
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Filter By Request Name</label>
                        
                        <input type="text" class="form-control" name="name" value="{{Request::get('name')}}">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Email</label>
                        
                        <input type="text" class="form-control" name="email" value="{{Request::get('email')}}">
                      </div>
                    </div>
                    @if(session()->has('admin') || session()->has('branch'))
                        @else
                        <div class="col-md-2">
                          <div class="form-group">
                              <label class="form-label">Client</label>
                              <select name="client" id="client" class="form-select">
                                  <option value="">All Client</option>
                                  <option value="My Client" {{ Request::get('client') == 'My Client' ? 'selected' : '' }}>My Client</option>
                              </select>
                          </div>
                        </div>
                        @endif
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-label d-block">&nbsp;</label>
                        <button type="submit" class="btn btn-primary">Search</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </form>
          </div>
        </div>
        <!-- end -->
        
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Total Not Assigned By Manager ({{ $List->total() }})</h4>
            </div>
            <div class="card-body"> 
              <!-- <h5>Project Listing</h5>
                                       <hr> -->
              
              <div class="row" style="margin-bottom: 10px;"> 
                <!-- <div class="col-sm-12 col-md-8">
                  <h5>Datatable</h5>
                </div> --> 
                <!-- <div class="col-sm-12 col-md-3 col-9">
                  <div>
                    <select class="custom-select custom-select-sm form-control  form-select">
                      <option selected="">Move to CEO</option>
                      <option value="10">Mr. Pankaj</option>
                      <option value="25">Mr. Gaurav</option>
                      <option value="50">Mr. Sandeep</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12 col-md-1 col-3">
                  <button type="submit" class="btn btn-primary" style="float:right;">Assign</button>
                </div> --> 
              </div>
              <div class="row">
                <div class="col-xl-12">
                    <div class="table-responsive">
                        <table
                            class="table table-bordered table-styling table-hover table-striped table-primary">
                            <thead>
                                <tr>
                                    @if(session()->has('admin'))
                                    {{-- <th>Country</th> --}}
                                    <th>Branch</th>
                                    @endif
                                    <th>Sales Person</th>
                                    <th>Requester Details</th>
                                    <th>Date</th>
                                    
                                   
                                    <th>Request ID</th>
                                    <!-- <th>Provider ID</th> -->
                                    <th>City</th>
                                    <th>Service Category</th>
                                    <th>Requester Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($List as $key=>$val)
                               
                                <tr>
                                    @if (session()->has('admin'))
                                    {{-- <td>{{$val->country}}</td> --}}
                                    <td>{{!empty($val->branches) ? $val->branches->branch_name : ''}}</td>
                                    @endif
                                    <td>
                                      {{!empty($val->assignByAdminOrBranch) ? $val->assignByAdminOrBranch->name : ''}}
                                    </td>
                                    
                                    <td valign="top"><strong>{{$val->requester_name}}</strong><br>
                                      <i class="ri-mail-line"></i> {{$val->email}}<br>
                                      <i class="ri-smartphone-line"></i> {{$val->phone}}<br>
                                    </td>
                                    <td><i class="ri-calendar-line"></i> {{date('d-m-Y', strtotime($val->created_at))}}</td>
                                    
                                    <td valign="top">{{$val->request_id}}</td>
                                    <!-- <td valign="top"></td> -->
                                    
                                    <td valign="top">{{$val->city}}</td>
                                    <td valign="top">{{$val->service_category}}</td>
                                    <td valign="top">{{$val->requester_location}}</td>
                                    {{-- <td valign="top"><a href="#"> <i class="ri-edit-line"></i> </a> <a href="#"> <i class="ri-close-line"></i> </a></td> --}}
                                    
                                  </tr> 
                                @endforeach
                                
                                  
                              </tbody>
                        </table>
                        <div class="pagination pagination-sm float-right paging"> 
                            {!! $List->Links()!!}
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