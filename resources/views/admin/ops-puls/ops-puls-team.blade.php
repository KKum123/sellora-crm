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
                            <h4 class="card-title">View Operation Team</h4>
                        </div>
                        <form>
                        <div class="card-body">
                            <div class="form-validation">
                                <div class="needs-validation">
                                    <div class="row">
                                        @if(session()->has('admin'))
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Filter By Branch</label>
                                                <select name="branchId"  class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach ($branch as $key=>$val)
                                                        <option value="{{$val->_id}}" {{!empty(Request::get('branchId')) && new ObjectId(Request::get('branchId')) == $val->_id ? 'selected' : ''}}>{{$val->branch_name}} ({{$val->branch_code}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" value="{{Request::get('name')}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Email</label>
                                                <input type="text" name="email" value="{{Request::get('email')}}" class="form-control">
                                            </div>
                                        </div>

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
                        <h4 class="card-title">List</h4>
                      </div>
                      <div class="card-body"> 
                        <!-- <h5>Project Listing</h5>
                                                 <hr> -->
                        
                        <!-- <div class="row" style="margin-bottom: 10px;">
                          <div class="col-sm-12 col-md-8">
                            <h5>Datatable</h5>
                          </div>
                          <div class="col-sm-12 col-md-3 col-9">
                            <div>
                              <select class="custom-select custom-select-sm form-control  form-select">
                                <option selected="">Move to Manager</option>
                                <option value="10">Mr. Pankaj</option>
                                <option value="25">Mr. Gaurav</option>
                                <option value="50">Mr. Sandeep</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-12 col-md-1 col-3">
                            <button type="submit" class="btn btn-primary" style="float:right;">Assign</button>
                          </div>
                        </div> -->
          
                        <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-styling table-hover table-striped table-primary">
                                            <thead>
                                                <tr>
                                                    <th width="50">SN.</th>
                                                    @if(session()->has('admin'))
                                                    <th>Branch</th>
                                                    @endif
                                                    <th>Operation Team</th>
                                                    <th>User ID</th>
                                                    <th>Password</th>
                                                    <th width="50">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($List as $key=>$val)
                                                <tr>
                                                    <td>{{$key + $List->firstItem()}}.</td>
                                                    @if(session()->has('admin'))
                                                    <td>{{!empty($val->branches) ? $val->branches->branch_name : ''}}</td>
                                                    @endif
                                                    <td valign="top"><strong>{{$val->name}}</strong><br>
                                                        <i class="ri-mail-line"></i> {{$val->email}}<br>
                                                        <i class="ri-smartphone-line"></i> {{$val->mobile}}<br>
                                                    </td>
                                                    <td valign="top">{{$val->email}}</td>
                                                    <td valign="top">{{base64_decode($val->show_password)}}</td>
                                                   
                                                    {{-- <td valign="top"><a href="#"> <i class="ri-edit-line"></i> </a>
                                                        <a href="#"> <i class="ri-close-line"></i> </a></td> --}}
                                                    <td>
                                                        @if($val->status=='1')
                                                        <a href="#" style="color: green">Active</a>
                                                        @else
                                                        <a href="#" style="color: red">Deactive</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                                
                                              
                                            </tbody>
                                        </table>
                                        <div class="pagination pagination-sm float-right paging"> 
                                        {!!$List->links()!!}
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
