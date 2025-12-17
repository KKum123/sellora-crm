@extends('admin.layouts.master')
@section('content')
    <div class="content-body">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 d-none">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Department Permission</h4>
                        </div>
                        
                    </div>
                </div>
                <!-- end -->

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">View Department List</h4>
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
                                                    <th>Department Name</th>
                                                    <th>Module</th>
                                                    <th>Permission</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($departmentsWithPermissions as $key=>$item)
                                                <tr>
                                                    <td>{{ $key + 1 }}.</td>
                                                    <td>{{ $item['department']->name }}</td>
                                                    <td>
                                                        <ul>
                                                        @foreach($item['permissions'] as $permission)
                                                        
                                                        <li><i class="fa fa-user"></i> {{ $permission->name }}</li>
                                                    @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <a href="{{route('admin.rolePermission')}}?department={{$item['department']->_id}}" class="btn btn-primary">Get Permission</a>
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
