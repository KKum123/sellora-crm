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
use \MongoDB\BSON\ObjectId;
@endphp

<div class="content-body">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Unassigned Client</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <div class="needs-validation">
                  <form>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-label">Filter By From Date</label>
                        <input type="date" name="fromDate" value="{{Request::get('fromDate')}}" maxlength="{{date('Y-m-d')}}" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-label">To Date</label>
                        <input type="date" name="toDate" value="{{Request::get('toDate')}}" maxlength="{{date('Y-m-d')}}" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Client's Mobile</label>
                        <input type="text" class="form-control" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" maxlength="10" name="phoneNo" value="{{Request::get('phoneNo')}}" >
                      </div>
                    </div>
                    {{-- <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="projectStatus" id="" class="form-select">
                             <option value="">Select</option>
                             <option value="Pitch In Progress" {{Request::get('projectStatus') == 'Pitch In Progress' ? 'selected' :''}}>Pitch In Progress</option>
                             <option value="Not Interested" {{Request::get('projectStatus') == 'Not Interested' ? 'selected' :''}}>Not Interested</option>
                             <option value="Not Reachable" {{Request::get('projectStatus') == 'Not Reachable' ? 'selected' :''}}>Not Reachable</option>
                             <option value="Cancelled" {{Request::get('projectStatus') == 'Cancelled' ? 'selected' :''}}>Cancelled</option>
                        </select>
                      </div>
                    </div> --}}
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
              <h4 class="card-title">Total Unassigned  ({{ $List->total() }})</h4>
            </div>
            <div class="card-body"> 
              <!-- <h5>Project Listing</h5><hr> -->              
              <div class="row" style="margin-bottom: 10px;"> 
              
              </div>
              <div class="row">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-styling table-hover table-striped table-primary">
                      <thead>
                        <tr>                          
                          <th>Requester Details</th>
                          <th>Sales Person</th>
                          <th>Date</th>
                          <th>Follow Up</th>
                         
                          @if(session()->has('admin') || session()->has('branch') || session()->has('team') && session()->get('team')->department=='67bd3ca8d4de44c0093ea46c' || session()->has('team') && session()->get('team')->department=='67bd3cd7d4de44c0093ea46d')
                          <!-- admin sub admin branch and sub branch login -->
                           
                          <th>Move To Operation Manager</th>
                          @else
                          <th>Move To Team</th>
                          @endif
                          @if(session()->has('branch'))
                          <th>Move To Other Branch</th>
                          @endif
                          <th>Request ID</th>
                          <th>City</th>
                          <th>Service Category</th>
                          <th>Requester Location</th>
                          
                          @if(session()->has('admin') || session()->has('branch') ||session()->has('team') && session()->get('team')->department=='67bd3ca8d4de44c0093ea46c' || session()->has('team') && session()->get('team')->department=='67bd3cd7d4de44c0093ea46d')
                          <!-- admin sub admin branch and sub branch login -->
                          @else
                          <th width="50">Action</th>
                          @endif
                          <!-- <th>Assign to Sales Person</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($List as $key=>$val)
                          @php 
                            $team = session()->has('team') ? session()->get('team') : null;
                            $adminOrBranch = session()->has('admin') || session()->has('branch') ? true : null;

                            $operationalTeam = \App\Models\ERP\Team::where('department', new ObjectId('6790b8b82ef8f2064c61d077')) // Operation
                                                ->when(isset($val), function ($query) use ($val) {
                                                    return $query->where('branchId', new ObjectId($val->branchId));
                                                })
                                                ->when($team, function ($query) use ($team) {
                                                    if ($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d') {
                                                        // Sub admin / Sub branch login
                                                        $query->where('designation', new ObjectId('6797015d1af1e9898db5951d')); // Operation manager
                                                    } elseif ($team->designation == '6797015d1af1e9898db5951d') {
                                                        // Operation manager login
                                                        $query->where(function ($q) use ($team) {
                                                            $q->where('operationManagerId', new ObjectId($team->_id))
                                                              ->orWhere('_id', new ObjectId($team->_id)); // Manager's team or self
                                                        });
                                                    }
                                                })
                                                ->when($adminOrBranch, function ($query) {
                                                    $query->where('designation', new ObjectId('6797015d1af1e9898db5951d')); // Operation manager
                                                })
                                                ->where('status', "1")
                                                ->orderBy("name", "asc")
                                                ->get();
                          @endphp
                        <tr>
                          <td valign="top"><strong>{{$val->requestName}}</strong><br>
                            <i class="ri-mail-line"></i> {{$val->emailId}}<br>
                            <i class="ri-smartphone-line"></i> {{$val->phoneNo}}<br>
                            
                          </td>
                          <td valign="top">
                          @if(!empty($val->salseData))
                            <strong>{{!empty($val->salseData) ? $val->salseData->name : ''}}</strong><br>
                            <i class="ri-mail-line"></i> {{!empty($val->salseData) ? $val->salseData->email : ''}}<br>
                            <i class="ri-smartphone-line"></i> {{!empty($val->salseData) ? $val->salseData->mobile : '' }}<br>
                          @endif
                          </td>
                          <td><i class="ri-calendar-line"></i> {{date('d-m-Y', strtotime($val->created_at))}}</td>
                          
                          <td>
                            @if(!empty($val->salseData))
                            <a href="#" style="color: blue" data-bs-toggle="modal" data-bs-target="#exampleModal{{$val->_id}}"><i class="ri-eye-line"></i> View</a>
                            
                              <!-- Modal -->
                              <div class="modal fade followpopup" id="exampleModal{{$val->_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="exampleModalLabel">Request ID: #{{$val->requestId}}</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="table-responsive">
                                        <table style="width: 100%;" class="table table-striped table-bordered">
                                          <thead>
                                            <tr>
                                              <th>S.N.</th>
                                              <th>Activity Date</th>
                                              <th>Next Follow Up Date</th>
                                              <th>Remarks</th>
                                              <th>Status</th>
                                            </tr>
                                          </thead>
                                          <tbody id="appendBodyData">
                                            @php $leadStatus1 @endphp
                                            @if(count($val->leadFollowupData)>0)
                                              @foreach ($val->leadFollowupData  as $k=>$v )
                                              <tr>
                                                <td>{{$k+1}}</td>
                                                <td>{{date('d-m-Y', strtotime($v->created_at))}}</td>
                                                <td>{{date('d-m-Y', strtotime($v->FollowUpDate))}}</td>
                                                
                                                <td><span>
                                                  {{$v->remarks}}
                                                </span></td>
                                                <td>
                                                  
                                                  @php 
                                                    $leadStatus1 = \App\Helpers\Helpers::statusColor($v->projectStatus);
                                                  @endphp
                                                  {!!$leadStatus1!!}
                                                </td>
                                              </tr>
                                              @endforeach
                                            @endif
                                            

                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                    <!-- modal body end --> 
                                  </div>
                                </div>
                              </div>
                              <!-- Modal End -->
                            <br>
                           @if(!empty($leadStatus1)) {!! $leadStatus1 !!}  @endif

                            @endif
                          </td>
                         
                          <td valign="top">
                            <form class="formSubmit" action="{{route($prefix.'.task-pulse.moveToTeam')}}" method="post" data-parsley-validate>
                              @csrf
                              <input type="hidden" name="clientId" value="{{$val->_id}}">
                              <select name="assignOperationId" required onchange="this.form.submit()">
                                <option value="">Select</option>
                                @foreach ($operationalTeam as $k=>$v)
                                <option value="{{$v->_id}}">{{$v->name}}</option>
                                @endforeach
                              
                               </select>
                              </form>
                          </td>
                          @if(session()->has('branch'))
                            <td>
                            <form class="formSubmit" action="{{route($prefix.'.task-pulse.moveToOtherBranch')}}" method="post" data-parsley-validate>
                              @csrf
                              <input type="hidden" name="clientId" value="{{ $val->_id }}">
                              <input type="hidden" name="moveFromBranchId" value="{{ $val->branchId }}">
                              <select name="branchId" required onchange="this.form.submit()">
                                <option value="">Select Branch</option>
                                @foreach ($brnachList as $k=>$v)
                                <option value="{{ $val->countryName }}|{{$v->_id}}">{{$v->branch_name}}</option>
                                @endforeach
                              
                               </select>
                              </form>
                            </td>
                          @endif      

                          <td valign="top">{{$val->requestId}}</td>
                          
                          <td valign="top">{{$val->city}}</td>
                          <td valign="top">{{$val->serviceCategory}}</td>
                          <td valign="top">{{$val->requestLocation}}</td>
                          @if(session()->has('admin') || session()->has('branch') ||session()->has('team') && session()->get('team')->department=='67bd3ca8d4de44c0093ea46c' || session()->has('team') && session()->get('team')->department=='67bd3cd7d4de44c0093ea46d')
                          <!-- admin sub admin branch and sub branch login -->
                         
                          @else
                          <td valign="top">
                            <a href="{{route($prefix.'.task-pulse.updateClient',$val->_id)}}"> <i class="ri-edit-line"></i> </a> 
                            <!-- <a href="{{route($prefix.'.task-pulse.deleteClient',$val->_id)}}" onclick="return confirm('Are you sure delete this item?')"> <i class="ri-close-line"></i> </a> -->
                          </td>
                          @endif
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
<script>
$(function() {
  $('.formSubmit').each(function() {
      $(this).parsley().on('field:validated', function() {
          var ok = $('.parsley-error').length === 0;
          $('.bs-callout-info').toggleClass('hidden', !ok);
          $('.bs-callout-warning').toggleClass('hidden', ok);
      }).on('form:submit', function(e) {
          $('#spiner').css('display', 'flex');
      });
  });

  $('.formSubmit').on('submit', function(e) {
      e.preventDefault(); 
      var form = $(this);

      if (form.parsley().validate()) {
          $('#spiner').css('display', 'flex'); 
          form.unbind('submit').submit(); 
      }
  });
});

</script>
@endsection