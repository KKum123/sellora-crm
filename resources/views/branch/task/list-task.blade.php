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
                                <form  data-parsley-validate>
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
                                            <div class="mb-3">
                                                <label class="form-label">Sub {{ucfirst($prefix)}} </label>
                                                <select name="teamId" id="teamId" class="form-control">
                                                    <option value="">All</option>
                                                    @foreach ($teamList as $key=>$val)
                                                        <option value="{{ $val->_id }}" {{ Request::get('teamId') == $val->_id ? 'selected' : '' }}>{{ $val->name }}</option>
                                                    @endforeach
                                                </select>    
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
                        <h4 class="card-title">Total task ({{ $List->total() }})</h4>
                        </div>
                        <div class="card-body"> 
                        

                        <div class="row">
                            <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-styling table-hover table-striped table-primary">
                                <thead>
                                    <tr>
                                        <th width="50">SN.</th>
                                        <th width="230">Name</th>
                                        <th width="230">Task Title</th>
                                        <th width="230">Assigned Date</th>
                                        <th width="200">Task Details</th>
                                        <th width="200">Total Time</th>
                                        <th width="50">Action</th>
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
                                        <td> {{ !empty($val->team) ? $val->team->name : '' }}</td>
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
                                            
                                          <a href="{{ route($prefix.'.task.replyView', $val->_id) }}">View Reply</a>
                                        </td>
                                        <td>{{ $val->taskDetails }}</td>
                                        <td>
                                            <span>Assign Time  :<b> {{ $val->completionTime }} h </b></span> <br>
                                            <span>Spend Time   : <b> {{ $totalTime }} h</b></span> <br>
                                            <span>Balance Time : <b>{{ $val->completionTime - $totalTime }} h</b></span>
                                        </td>
                                        <td>
                                            @if($val->taskStatus != 'Completed')
                                            <a href="{{ route($prefix.'.task.listTaskUpdate', $val->_id) }}"> <i class="ri-edit-line"></i></a>
                                            
                                            @endif
                                            @if(empty($val->taskStatus))

                                            <a href="{{ route($prefix.'.task.listTaskDelete', $val->_id) }}" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                         
                                            @endif
                                        </td>
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

@endsection


