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
                            <h4 class="card-title">Sub {{ucfirst($prefix)}} Task List</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form >
                                   <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">From Date </label>
                                            <input type="date" name="fromDate" max="{{ date('Y-m-d') }}" class="form-control" value="{{ Request::get('fromDate') }}">
                                        </div>
                                    </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label">To Date </label>
                                                <input type="date" name="toDate" max="{{ date('Y-d-m') }}" value="{{ Request::get('toDate') }}"  class="form-control">
                                            </div>
                                        </div>
                                       
                                        <div class="col-lg-3">
                                            <div class="mt-2">
                                                <button type="submit" id="submitButton" class="btn btn-primary m-3">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                        <h4 class="card-title">List</h4>
                        </div>
                        <div class="card-body"> 
                        

                        <div class="row">
                            <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-styling table-hover table-striped table-primary">
                                <thead>
                                    <tr>
                                        <th width="50">SN.</th>
                                        @if(session()->has('admin') || session()->has('branch'))
                                            <th width="230">Name</th>
                                        @endif
                                        <th width="230">Task Title</th>
                                        <th width="230">Assigned Date</th>
                                        <th width="200">Task Details</th>
                                        <th width="200">Total Time</th>
                                        @if(session()->has('admin') || session()->has('branch'))
                                            <th width="50">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($List as $key=>$val)
                                @php 
                                    $totalTime = 0;
                                    $replyData = \App\Models\ReplyTaskAdminBaranch::where('taskId', new ObjectId($val->_id))->get();
                                @endphp

                                @foreach ($replyData as $k=>$v)
                                    @php
                                        $totalTime += $v->timeSpend;
                                    @endphp
                                @endforeach
                                    <tr>
                                        <td>{{ $key + $List->firstItem() }}.</td>
                                        @if(session()->has('admin') || session()->has('branch'))
                                            <td> {{ !empty($val->team) ? $val->team->name : '' }}</td>
                                        @endif
                                        <td>{{ $val->taskTitle }}</td>
                                        <td>
                                            {{ date('d F Y', strtotime($val->created_at)) }} 
                                            @if($val->taskStatus == "Completed")
                                                <span class="greenstatus">Completed</span>
                                            @endif

                                            @if($val->taskStatus == "In Progress")
                                                <span class="orangestatus">{{ $val->taskStatus }}</span>
                                            @endif


                                            <br>
                                            
                                           
                                           

                                            @if($val->taskStatus != "Completed")
                                                 <a href="#" style="color: blue; margin: 10px 0px 0px 10px;" data-bs-toggle="modal" data-bs-target="#exampleModalReply{{$val->_id}}"><i class="ri-reply-line"></i> Reply</a>
                                                 ||
                                            @endif
                                           
                                            <a href="{{ route($prefix.'.task.replyView', $val->_id) }}">View Reply</a>

                                              <!-- modal reply -->
                                            <div class="followpopup modal fade" id="exampleModalReply{{$val->_id}}" aria-hidden="true"
                                                aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title text-white" id="exampleModalToggleLabel">Task Title: {{$val->taskTitle}}</h5>
                                                    <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#exampleModal200{{$val->_id}}"
                                                    aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <form id="formSubmit{{$val->_id}}" action="{{ route($prefix.'.task.replyTaskAdminBranch') }}" method="post" action="">
                                                    @csrf
                                                    <input type="hidden" name="taskId" value="{{$val->_id}}">
                                                    <input type="hidden" name="adminId" value="{{ $val->adminId }}">
                                                    <input type="hidden" name="brachId" value="{{ $val->brachId }}">
                                                    <div class="row">
                                                    <div class="col-xl-6">
                                                    <div class="mb-3">
                                                    <label class="form-label">Spent Time <span class="red">*</span></label>
                                                    <input type="text" class="form-control" name="spentTime" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46 && !this.value.includes('.'));" maxlength="4" required>
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
                                        </td>
                                        <td>{{ $val->taskDetails }}</td>
                                        <td>
                                            <span>Assign Time  :<b> {{ $val->completionTime }} h </b></span> <br>
                                            <span>Spend Time   : <b> {{ $totalTime }} h</b></span> <br>
                                            <span>Balance Time : <b>{{ $val->completionTime - $totalTime }} h</b></span>
                                        </td>
                                        @if(session()->has('admin') || session()->has('branch'))
                                            
                                        <td>
                                            @if($val->taskStatus != 'Completed')
                                            <a href="{{ route($prefix.'.task.listTaskUpdate', $val->_id) }}"> <i class="ri-edit-line"></i></a>
                                            
                                            @endif
                                            @if(empty($val->taskStatus))

                                            <a href="{{ route($prefix.'.task.listTaskDelete', $val->_id) }}" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                         
                                            @endif
                                        </td>
                                        @endif
                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                </table>
                                <br>
                                <div class="pagination pagination-sm float-right paging">
                                {!! $List->links() !!}  
                                </div>
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
@endsection


