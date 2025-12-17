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
              <h4 class="card-title">Client Report</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <div class="needs-validation">

                  <form class="formSubmit" data-parsley-validate>
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
                      <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Client</label>
                            <select name="client" id="client" class="form-select">
                                <option value="">All Client</option>
                                <option value="My Client" {{ Request::get('client') == 'My Client' ? 'selected' : '' }}>My Client</option>
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
              <h4 class="card-title">Total Client's ({{ $List->total() }})</h4>
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
                          <th>SalesPulse Person</th>
                          <th>Date</th>
                          <th>Follow Up</th>
                          <th>Assigned To</th>
                          <th>Request ID</th>
                          <th>City</th>
                          <th>Service Category</th>
                          <th>Requester Location</th>
                       
                        </tr>
                      </thead>
                      <tbody>
                         
                        @foreach ($List as $key=>$val)
                        @php 
                          $teamManager = \App\Models\ERP\Team::where('_id', new ObjectId($val->assignOperationId))->first();
                        
                        @endphp
                        <tr>
                          <td valign="top"><strong>{{$val->requestName}}</strong><br>
                            <i class="ri-mail-line"></i> {{$val->emailId}}<br>
                            <i class="ri-smartphone-line"></i> {{$val->phoneNo}}<br>

                            {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#statusModal"><span class="orangestatus">Pending</span></a>                             --}}
                          </td>
                          <td valign="top"><strong>{{!empty($val->salseData) ? $val->salseData->name : ''}}</strong></td>
                          <td><i class="ri-calendar-line"></i> {{date('d-m-Y', strtotime($val->created_at))}}</td>
                          
                          <td>
                            @if(!empty($val->assignOperationId))
                            <a href="#" style="color: blue" data-bs-toggle="modal" data-bs-target="#exampleModal2-{{$val->_id}}"><i class="ri-eye-line"></i> View</a>
                            
                              <!-- Modal -->
                              <div class="modal fade followpopup" id="exampleModal2-{{$val->_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                          @php
                                            $leadStatus1 = "";
                                          @endphp
                                            @if(count($val->leadFollowupData)>0)
                                            @foreach ($val->leadFollowupData as $l=>$lf )
                                           
                                              <tr>
                                                <td>{{$l+1}}</td>
                                                <td>{{date('d-m-Y', strtotime($lf->created_at))}}</td>
                                                <td>{{date('d-m-Y', strtotime($lf->FollowUpDate))}}</td>
                                                <td>{{$lf->remarks}}</td>
                                                <td>
                                                  
                                                  @php 
                                                    $leadStatus1 = \App\Helpers\Helpers::statusColor($lf->projectStatus);
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
                                @if(!empty($leadStatus1)) {!! $leadStatus1 !!} @endif
                               @endif
                          </td>
                          
                          <td valign="top">{{!empty($val->operationManagerTeam) ? $val->operationManagerTeam->name : ''}}</td>
                          <td valign="top">{{$val->requestId}}</td>
                          <td valign="top">{{$val->city}}</td>
                          <td valign="top">{{$val->serviceCategory}}</td>
                          <td valign="top">{{$val->requestLocation}}</td>
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
  
  @if(count($List) > 0)
  @foreach ($List as $kye => $val)
    @php 
      $assigntask = \App\Models\ERP\AssignTask::with('replyTask')->where([
                    'clientId' => new ObjectId($val->_id)
                  ])
                  ->when(session()->has('team'), function($query){
                    //$query->where(['oprationId' => new ObjectId(session()->get('team')->_id)]);
                  })
                  ->latest()->get();
   
  @endphp
    @if(count($assigntask) > 0)
    @foreach ($assigntask as $t => $ts)  
  

    <!-- Task Modal -->
    <div class="followpopup modal fade" id="exampleModal2001{{$ts->_id}}" aria-hidden="true"
    aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title text-white" id="exampleModalToggleLabel">Task Heading: {{$ts->taskHeading}}</h5>
      <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal200" aria-label="Close"></button> -->
      <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal200{{$val->_id}}" class="btn-close"
      aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="table-responsive">
      <table style="width: 100%;" class="table table-striped table-bordered">
      <thead>
      <tr>
      <th>S.N.</th>
      <th>Spent Time</th>
      <th>Remarks</th>
      <th>Status</th>
      </tr>
      </thead>
      <tbody id="appendBodyData">
      @php 
        $replyData = \App\Models\ERP\AssignTaskReplay::where('taskId', new ObjectId($ts->_id))->latest()->get();
      @endphp
      @foreach ($replyData as $rt=>$reply)
          <tr>
            <td>{{$rt+1}}</td>
            <td>{{$reply->spentTime}}</td>
            <td>{{$reply->remarks}}</td>
            <td>
            @php 
              $leadStatus12 = \App\Helpers\Helpers::statusColor($reply->taskStatus);
            @endphp
           {!!$leadStatus12!!}
            </td>
          </tr>
      @endforeach
      </tbody>
      </table>
      </div>
      </div>

    </div>
    </div>
    </div>

  @endforeach
  @endif
  @endforeach
@endif

@endsection
@section('javascript')
  <script>

  function formValidate(id){
      $('#formSubmit'+id).parsley().on('field:validated', function() {
              var ok = $('.parsley-error').length === 0;
              $('.bs-callout-info').toggleClass('hidden', !ok);
              $('.bs-callout-warning').toggleClass('hidden', ok);
          })
          .on('form:submit', function() {
              $('#spiner').css('display','flex');
          });
  }
        
    
</script>
  </script>
@endsection