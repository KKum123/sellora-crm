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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">View Sales Manager</h4>
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
                         

                            <div class="row" style="margin-bottom: 10px;">
                         
                            </div>
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
                                                    <th>SalesPulse Manager</th>
                                                    <th>User ID</th>
                                                    <th>Password</th>
                                                    <th>Team</th>
                                                    {{-- <th width="50">Action</th> --}}
                                                    <th width="50">Status</th>
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
                                                    <td>
                                                      
                                                        <a href="#" style="color: blue; margin-right: 10px;"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal{{$val->_id}}"><i
                                                                class="ri-add-line"></i> Add Team</a>
                                                        <a href="#" style="color: blue" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal2{{$val->_id}}"><i class="ri-eye-line"></i> View
                                                            Team</a>

                                                            <!-- Modal -->
                                                                <div class="modal fade followpopup" id="exampleModal{{$val->_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Assign Team</h1>
                                                                        
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form class="assign-team-form" action="{{route($prefix.'.sales.assignTeamSalesManager')}}" method="post" data-parsley-validate>
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <div class="col-xl-12">
                                                                                        <span>{{$val->name}} Emp Code - {{$val->employee_code}}</span>
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Team Member</label>
                                                                                        @php 
                                                                                                $branchId = '';
                                                                                        @endphp
                                                                                        @if(session()->has('branch'))
                                                                                            @php 
                                                                                                    $branchId = session()->get('branch')->_id;
                                                                                            @endphp
                                                                                            @else
                                                                                            @php 
                                                                                                    $branchId = $val->branchId;
                                                                                            @endphp
                                                                                        @endif
                                                                                        @php 
                                                                                            $teamAssignList = \App\Models\ERP\Team::where('status','1')
                                                                                                    ->where('department',new ObjectId('6790b8962ef8f2064c61d076'))
                                                                                                    ->when($branchId, function($query) use($branchId){
                                                                                                        $query->where('branchId', new ObjectId($branchId));
                                                                                                    })
                                                                                                    ->whereNull('createdByTeamId') // this is a unassign employee or team
                                                                                                    ->get();    
                                                                                        @endphp
                                                                                        
                                                                                        <input type="hidden" name="salesManagerId" value="{{$val->_id}}">
                                                                                        <select class="form" name="teamId" required>
                                                                                            <option value="">Select</option>
                                                                                            @foreach ($teamAssignList as $ta=>$tav)
                                                                                                    <option value="{{$tav->_id}}">{{$tav->name}} ({{$tav->employee_code}})</option> 
                                                                                            @endforeach
                                                                                            
                                                                                        </select>
                                                                                    
                                                                                    </div>
                                                                                    </div>
                                                                                    
                                                                                    <div class="col-xl-12"></div>
                                                                                    <div class="col-xl-12">
                                                                                    <div class="mt-0 text-end">
                                                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                                                        <!-- <button type="submit" class="btn btn-secondary">Cancel</button> -->
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <!-- modal body end --> 
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Modal End --> 
                                                                
                                                                <!-- Modal -->
                                                                <div class="modal fade followpopup" id="exampleModal2{{$val->_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{$val->name}} Emp Code - {{$val->employee_code}}</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                        <div class="table-responsive">
                                                                            <table style="width: 100%;" class="table table-striped table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                <th width="30">S.N.</th>
                                                                                <th>Team Name</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="appendBodyData">
                                                                            @php $branchId = '' @endphp
                                                                            @if(session()->has('branch'))
                                                                                @php $branchId = session()->get('branch')->_id @endphp
                                                                            @elseif(session()->has('team'))
                                                                            @php $branchId = $val->branchId @endphp
                                                                            @endif
                                                                                @php 
                                                                                   $teamList = \App\Models\ERP\Team::where('status','1')
                                                                                                            ->where('createdByTeamId', new ObjectId($val->_id))
                                                                                                            
                                                                                                            ->get();    
                                                                                @endphp
                                                                                @foreach($teamList as $k=>$v)
                                                                                <tr>
                                                                                <td>{{$k+1}}</td>
                                                                                <td style="text-align: left;">
                                                                                    <strong>{{$v->name}} ({{$v->employee_code}})</strong>
                                                                                 </td>
                                                                                </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                            </table>
                                                                        </div>
                                                                        </div>
                                                                        <!-- modal body end --> 
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Modal End -->
                                                           
                                                    </td>
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
                                            {!!$List->links()!!} </div>
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
<script>
     $(function() {
        $('.assign-team-form').each(function() {
            $(this).parsley().on('field:validated', function() {
                var ok = $(this).find('.parsley-error').length === 0;
                $(this).find('.bs-callout-info').toggleClass('hidden', !ok);
                $(this).find('.bs-callout-warning').toggleClass('hidden', ok);
            }).on('form:submit', function() {
                $('#spiner').css('display', 'flex');
            });
        });
      });
</script>
@endsection
