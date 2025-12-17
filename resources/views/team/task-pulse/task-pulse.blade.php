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
            <h4 class="card-title">My Client</h4>
          </div>
          <div class="card-body">
            <div class="form-validation">
              <div class="needs-validation">

                <form class="formSubmit" data-parsley-validate>
                  <div class="row">
                  <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Filter By From Date</label>
                            <input type="date" name="fromDate" value="{{ Request::get('fromDate') }}" max="{{ date('Y-m-d') }}" class="form-control">
                        </div>
                        </div>
                        <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">To Date</label>
                            <input type="date" name="toDate" value="{{ Request::get('toDate') }}" max="{{ date('Y-m-d') }}" class="form-control">
                        </div>
                        </div>
                        <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Client's Mobile</label>
                            <input type="text" name="mobileNo" value="{{ Request::get('mobileNo') }}" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" maxlength="10" class="form-control">
                        </div>
                        </div>
                        <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Task Status</label>
                            <select name="taskStatus" id="taskStatus" class="form-select">
                                <option value="">ALL</option>
                                <option value="Not Started" {{ Request::get('taskStatus') == 'Not Started' ? 'selected' : '' }}>Not Started</option>
                                <option value="In Progress" {{ Request::get('taskStatus') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ Request::get('taskStatus') == 'Completed' ? 'selected' : '' }}>Completed</option>
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
            <h4 class="card-title">Total Task ({{ $AssignTask->total() }})</h4>
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
                        <th>Assigned By</th>
                        <th>Task Heading</th>
                        <th>Task Details</th>
                        <th>Assigned To</th>
                        <th>Completion Date</th>

                      </tr>
                    </thead>
                    <tbody>
                     
                    @foreach($AssignTask as $key=>$val)
                    
                        <tr>
                          <td>
                                @if(!empty($val->client))
                                   <strong> {{ $val->client->requestName }}</strong>
                                    <br>
                                    <i class="ri-mail-line"></i> {{$val->client->emailId}}
                                     <br> <i class="ri-smartphone-line"></i> {{ $val->client->phoneNo }}
                                @endif
                          </td>
                          <td>
                          {{!empty($val->addTaskByTeam) ? $val->addTaskByTeam->name : ''}} 
                          </td>
                          <td>
                          {{$val->taskHeading}} <br>
                          @php 
                            $leadStatus1 = \App\Helpers\Helpers::statusColor($val->taskStatus);
                          @endphp
                            {!! $leadStatus1 !!} 
                            @if(!empty($val->taskStatus) && $val->taskStatus != 'Not Started')
                               <span>{{ date('d M Y', strtotime($val->updated_at)) }}</span>
                            @endif
                          </td>
                          <td>                            
                          {{$val->taskDescription}} <br>
                          @if(!empty($val->taskStatus) && $val->taskStatus != 'Completed')
                          <a href="#" style="color: blue; margin: 10px 0px 0px 10px;" data-bs-toggle="modal" data-bs-target="#exampleModalReply{{$val->_id}}"><i
                              class="ri-reply-line"></i> Reply</a>
                          @endif

                          <a href="#" style="color: blue; margin: 10px 0px 0px 10px;" data-bs-toggle="modal" data-bs-target="#exampleModal2001{{$val->_id}}"><i class="ri-eye-line"></i> View</a>
                           
                           </td>
                          <td>                            
                           {{ !empty($val->addTaskToTeam) ? $val->addTaskToTeam->name : '' }}<br>

                           <!-- modal reply -->
                        <div class="followpopup modal fade" id="exampleModalReply{{$val->_id}}" aria-hidden="true"
                            aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                              <div class="modal-dialog modal-dialog-centered modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title text-white" id="exampleModalToggleLabel">Task Heading: {{$val->taskHeading}}</h5>
                                <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#exampleModal200{{$val->_id}}"
                                aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form id="formSubmit{{$val->_id}}" method="post" action="{{route($prefix.'.opsPuls.taskReply')}}" data-parsley-validate enctype="multipart/form-data">
                                  @csrf
                                  <input type="hidden" name="clientId" value="{{$val->clientId}}">
                                  <input type="hidden" name="operatinId" value="{{$val->oprationId}}">
                                  <input type="hidden" name="assignByTeamId" value="{{!empty($val->assignByTeamId) ? $val->assignByTeamId : ''}}">
                                  <input type="hidden" name="assignByBranchId" value="{{!empty($val->assignByBranchId) ? $val->assignByBranchId : ''}}">
                                  <input type="hidden" name="assignByAdminId" value="{{!empty($val->assignByAdminId) ? $val->assignByAdminId : ''}}">
                                  
                                  <input type="hidden" name="taskId" value="{{$val->_id}}">
                                  
                                <div class="row">
                                <div class="col-xl-6">
                                <div class="mb-3">
                                <label class="form-label">Spent Time <span class="red">*</span></label>
                                <input type="text" class="form-control" name="spentTime" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46 && !this.value.includes('.'));" maxlength="4" required>
                                </div>
                                </div>
                                <div class="col-xl-6">
                                  <div class="mb-3">
                                  <label class="form-label">Upload Image</label>
                                   <input type="file" class="form-control" name="uploadImage" accept="image/*">
                                  </div>
                                </div>
                                <div class="col-xl-12"></div>
                                <div class="col-xl-12">
                                <div class="mb-3">
                                <label class="form-label">Remarks</label>
                                <textarea class="form-control" name="remarks"></textarea>
                                </div>
                                </div>
                                <div class="col-xl-12"></div>

                                <div class="col-xl-6">
                                  <div class="mb-3">
                                    <label class="form-label">Status <span class="red">*</span></label>
                                    <select class="form-control" name="status" required>
                                      <option value="">Select</option>
                                      <option value="In Progress">In Progress</option>
                                      <option value="Completed">Completed</option>
                                    </select>
                                 <div>
                                </div>
                               
                                <div class="col-xl-12"></div>
                                <div class="col-xl-4">
                                <div class="mt-4">
                                <button type="submit" onclick="formValidate(`{{$val->_id}}`)" class="btn btn-primary">Submit</button>
                                </div>
                                </div>
                                </div>
                                    </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                      </div>
                         <!-- modal end -->

                             <!-- Task Modal -->
                            <div class="followpopup modal fade" id="exampleModal2001{{$val->_id}}" aria-hidden="true"
                            aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title text-white" id="exampleModalToggleLabel">Task Heading: {{$val->taskHeading}}</h5>
                          
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
                            <th>Image</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            </tr>
                            </thead>
                            <tbody id="appendBodyData">
                            @php 
                                $replyData = \App\Models\ERP\AssignTaskReplay::where('taskId', new ObjectId($val->_id))->latest()->get();
                                $spendTime = 0;
                            @endphp
                            @foreach ($replyData as $rt=>$reply)
                            @php
                                $spendTime += $reply->spentTime; 
                            @endphp
                                <tr>
                                    <td>{{$rt+1}}</td>
                                    <td>{{$reply->spentTime}} Hour</td>
                                    <td>
                                        @if($reply->uploadImage)
                                            <a href="{{ url('/') }}/{{ $reply->uploadImage }}" target="_blank">View Image</a>
                                        @endif
                                    </td>
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
                        
                        

                        </td>
                          <td>
                          {{date('d-m-Y', strtotime($val->compationDate))}}
                        <br>
                        <span><b>Completion Time :</b> {{$val->complationTime}} Hour</span>
                        <span><b>Balance Time :</b> {{$val->complationTime - $spendTime}} Hour</span>
                         
                        </td>
                                                
                         
                        
                          
                          
                        </tr>
                        @endforeach
                      </tbody>
                  </table>
                  <div class="pagination pagination-sm float-right paging">
                    {!!$AssignTask->links()!!}
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

  function formValidate(id) {
    $('#formSubmit' + id).parsley().on('field:validated', function () {
      var ok = $('.parsley-error').length === 0;
      $('.bs-callout-info').toggleClass('hidden', !ok);
      $('.bs-callout-warning').toggleClass('hidden', ok);
    })
      .on('form:submit', function () {
        $('#spiner').css('display', 'flex');
      });
  }


</script>
</script>
@endsection