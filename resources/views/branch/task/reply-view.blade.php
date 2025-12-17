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
                @if(session()->has('admin') || session()->has('branch'))
                    <a href="{{ route($prefix.'.task.listTask') }}" class="btn btn-primary m-3"> Back </a>
                @else
                    <a href="{{ route($prefix.'.task.viewTaskAdminBranch') }}" class="btn btn-primary m-3"> Back </a>
                @endif
                
                <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Name : {{ !empty($singleData->team) ? $singleData->team->name : '' }}</h4>
                            <br>
                            <h5>Task Heading : {{ $singleData->taskTitle }}</h5>    
                        </div>
                        <div class="card-body"> 
                        <div class="row">
                            <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-styling table-hover table-striped table-primary">
                                <thead>
                                    <tr>
                                        <th width="10">SN.</th>
                                        <th width="10">Reply Date</th>
                                        <th width="10">Spend Time</th>
                                        <th width="100">Reply Task</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($List as $key=>$val)
                                    <tr>
                                        <td>{{ $key + $List->firstItem() }}.</td>
                                        <td>{{  date('d F Y', strtotime($val->created_at)) }}</td>
                                        <td>{{ $val->timeSpend }} h</td>
                                        <td>{{ $val->taskReply }}</td>
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


