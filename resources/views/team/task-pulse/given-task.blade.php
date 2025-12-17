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
              <h4 class="card-title">Given  Task</h4>
            </div>
            <form >
                <div class="card-body">
                <div class="form-validation">
                    <div class="needs-validation">
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
                          <th>Sr.No</th>
                          <th>Requester Details</th>                          
                          <th>Assigned By</th>
                          <th>Task Heading</th>
                          <th>Task Details</th>
                          <th>Assigned To</th>
                          <th>Completion Date</th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($AssignTask as $key=>$val)
                        <tr>
                          <td>{{ $key + $AssignTask->firstItem() }}</td>
                          <td>
                                @if(!empty($val->client))
                                   <strong> {{ $val->client->requestName }}</strong>
                                    
                                    <div class="d-flex">
                                    <i class="ri-mail-line"></i> {{$val->client->emailId}}
                                    </div>
                                   
                                     <div class="d-flex">
                                     <i class="ri-smartphone-line"></i> {{ $val->client->phoneNo }}
                                     </div>
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
                               <span class="d-flex">{{ date('d M Y', strtotime($val->updated_at)) }}</span>
                            @endif
                          </td>
                          <td>                            
                          {{$val->taskDescription}} <br>
                          <a href="#" style="color: blue; margin: 10px 0px 0px 10px;" data-bs-toggle="modal" data-bs-target="#exampleModal2001{{$val->_id}}"><i class="ri-eye-line"></i> View</a>
                           
                           </td>
                          <td>                            
                           {{ !empty($val->addTaskToTeam) ? $val->addTaskToTeam->name : '' }}<br>
                           
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
                        <div class="d-flex"> <b> {{date('d-m-Y', strtotime($val->compationDate))}}</b> </div>
                        
                        <span class="d-flex">Completion Time : &nbsp;&nbsp;<b>{{$val->complationTime}}</b>&nbsp;  Hour</span>
                        <span class="d-flex">Balance Time : &nbsp;&nbsp;<b>{{$val->complationTime - $spendTime}}</b>&nbsp; Hour</span>
                         
                        </td>
                                                
                         
                        
                          
                          
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    <div class="pagination pagination-sm float-right paging">
                        {!! $AssignTask->appends(request()->query())->links() !!} </div>
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