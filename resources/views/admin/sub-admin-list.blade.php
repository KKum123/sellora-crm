@extends('admin.layouts.master')
@section('content')
@php 
    $prefix = 'admin';
@endphp
    <div class="content-body">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 d-none">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">View Sub Admin</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <div class="needs-validation">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Filter By Name</label>
                                                <select class="form-select" name="department">
                                                    <option value="">Select</option>
                                                    <option>Ankur</option>
                                                    <option>Manoj</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Email</label>
                                                <select class="form-select" name="department">
                                                    <option value="">Select</option>
                                                    <option>ankur@gmail.com</option>
                                                    <option>Manoj@gmail.com</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Mobile</label>
                                                <select class="form-select" name="department">
                                                    <option value="">Select</option>
                                                    <option>9873989898</option>
                                                    <option>9873989898</option>
                                                </select>
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
                    </div>
                </div>
                <!-- end -->

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">View Sub Admin</h4>
                        </div>
                        <div class="card-body">
                            <!-- <h5>Project Listing</h5>
                                               <hr> -->

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-styling table-hover table-striped table-primary">
                                            <thead>
                                                <tr>
                                                    <th width="50">SN.</th>
                                                    <th>Employee ID</th>
                                                    <th>Employee Code</th>
                                                    <th>Branch Name</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Password</th>
                                                    <th>Permission</th>
                                                    <th width="50">Action</th>
                                                    <th width="50">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($List as $key=>$val)
                                                <tr>
                                                    <td>{{ $key + $List->firstItem() }}.</td>
                                                    <th>{{ $val->employeeIdCode }}</th>
                                                    <td>{{ $val->employeeCode }}</td>
                                                    <td>{{ !empty($val->branch) ? $val->branch->branch_name : '' }}</td>
                                                    <td>{{ $val->name }}</td>
                                                    <td>{{ $val->email }}</td>
                                                    <td>{{ $val->phone }}</td>
                                                    <td>{{ base64_decode($val->show_password) }}</td>
                                                    <td>
                                                        <!-- <a href="{{route($prefix.'.team.teamPermission')}}?team={{$val->_id}}&department={{$val->department}}">Get Permission</a> -->
                                                    </td>
                          
                                                    <td>
                                                        <a href="{{ route('admin.subadmin.sub-admin-get-single',$val->id) }}"> <i class="ri-edit-line"></i> </a> <a
                                                            href="{{ route('admin.subadmin.delete',$val->id) }}" onclick="return confirm('Are you sure delete this item?')"> <i class="ri-close-line"></i> </a></td>
                                                    <td>
                                                        @if($val->status==1)
                                                        <span style="color: green">Active</span>
                                                        @else
                                                        <span style="color: red">Deactive</span>
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
            </div>
        </div>
    </div>
@endsection
@section('javascript')
@endsection
