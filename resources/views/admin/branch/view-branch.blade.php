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
                            <h4 class="card-title">View Branch</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <div class="needs-validation">
                                    <form method="get">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Filter By Country</label>
                                                    <select class="form-select" name="country" name="department">
                                                        <option value="">All</option>
                                                        @foreach($country as $key=>$val)
                                                        <option value="{{$val->name}}" {{ Request::get('country')==$val->name ? 'selected' : '' }}>{{$val->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Branch Name</label>
                                                    <input type="text" class="form-control" name="branch_name" value="{{ Request::get('branch_name') }}">
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-3">
                              <div class="form-group">
                                <label class="form-label">Manager Email</label>
                                <select class="form-select" name="department">
                                  <option value="">Select</option>
                                  <option>ankur@gmail.com</option>
                                  <option>Manoj@gmail.com</option>
                                </select>
                              </div>
                            </div> -->
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="form-label d-block">&nbsp;</label>
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>


                                </div>
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
                                                    <th width="50">SN.</th>
                                                    <th>Country</th>
                                                    <th>Branch Details</th>
                                                    <!-- <th>Sub Branch</th> -->
                                                    <th>Address</th>
                                                    <th>Password</th>
                                                    <th width="50">Action</th>
                                                    <th width="50">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($List as $key=>$val)
                                                <tr>
                                                    <td>{{ $key + $List->firstItem() }}.</td>
                                                    <td>{{ $val->country }}</td>
                                                    <td valign="top"><strong>{{ $val->branch_name }}</strong><br />
                                                        {{ $val->manager_name }}<br />
                                                        <i class="ri-mail-line"></i> {{ $val->email }}<br />
                                                        <i class="ri-smartphone-line"></i> {{ $val->mobile }}<br />
                                                    </td>
                                                    <!-- <td><a href="">Branch Sub Admin</a></td> -->
                                                    <td valign="top">{{ $val->complete_address }}</td>
                                                    
                                                    <td valign="top">{{ base64_decode($val->show_password) }}</td>
                                                    <td valign="top"><a href="{{ route($prefix.'.branch.updateBranch', $val->id) }}"> <i class="ri-edit-line"></i> </a>
                                                        <a href="{{ route($prefix.'.branch.deleteBranch', $val->id) }}" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a></td>
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
                                        <div class="pagination pagination-sm float-right paging"> </div>
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
