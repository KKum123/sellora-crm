@extends('admin.layouts.master')
@section('content')
@if(session()->has('admin'))
    @php $prefix = 'admin'; @endphp
@elseif(session()->has('branch'))
    @php $prefix = 'branch'; @endphp
@elseif(session()->has('team')) 
    @php $prefix = 'team'; @endphp
@endif
<style>
    textarea.form-control {
        height: 280px !important;
        min-height: 0 !important;
    }

</style>
<div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Task For Sub {{ucfirst($prefix)}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form id="formSubmit" action="{{ route($prefix.'.task.saveTaskSubmit') }}" method="post" data-parsley-validate method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ !empty($singleData) ? $singleData->id : '' }}">
                                    <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Sub {{ucfirst($prefix)}} <span class="red">*</span></label>
                                            <select class="form-control" name="teamId" required>
                                                <option value="">Select</option>
                                                @foreach ($teamList as $key => $val)
                                                    <option value="{{ $val->_id }}">{{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('teamId'))
                                        <span class="help-block font-red-mint">
                                            <strong>{{ $errors->first('teamId') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-12"></div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Task Title <span class="red">*</span></label>
                                                <input type="text" name="taskTitle" value="{{ !empty($singleData) ? $singleData->taskTitle : '' }}" required class="form-control">
                                            </div>
                                            @if ($errors->has('taskTitle'))
                                                <span class="help-block font-red-mint">
                                                    <strong>{{ $errors->first('taskTitle') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Task Details <span class="red">*</span></label>
                                                <textarea class="form-control task-details" name="taskDetails" required>{{ !empty($singleData) ? $singleData->taskDetails : '' }}</textarea>
                                                
                                                @if ($errors->has('taskDetails'))
                                                <span class="help-block font-red-mint">
                                                    <strong>{{ $errors->first('taskDetails') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-12"></div>
                                        

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Completion Time (In hour) <span class="red">*</span></label>
                                                <input type="text" name="completionTime" maxlength="5" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"   value="{{ !empty($singleData) ? $singleData->completionTime : '' }}" required class="form-control">
                                            </div>
                                            @if ($errors->has('completionTime'))
                                                <span class="help-block font-red-mint">
                                                    <strong>{{ $errors->first('completionTime') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 text-end"></div>
                                        <div class="col-lg-4 text-end">
                                            <div class="mt-2">
                                                <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                                            </div>
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


@endsection
@section('javascript')
<script>
     $(function() {
         $('#formSubmit').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
         })
         .on('form:submit', function() {
             $('#spiner').css('display','flex');
         });
      });
</script>
@endsection


