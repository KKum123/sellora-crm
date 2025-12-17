@extends('admin.layouts.master')
@section('content')
@if(session()->has('admin'))
@php $prefix = 'admin'; @endphp
@elseif(session()->has('branch'))
@php $prefix = 'branch'; @endphp
@elseif(session()->has('team')) 
@php $prefix = 'team';@endphp
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
                            <h4 class="card-title">Add (S&O) Team</h4>
                        </div>
                        <div class="card-body">
                        @if(session()->has('team')  && (string) session()->get('team')->department == '6790b8df2ef8f2064c61d079')
                         
                            <form id="formSubmit" action="{{ route($prefix.'.opsPemployeeManagementuls.saveTeam') }}" method="post" data-parsley-validate>
                            
                        @else 
                             <form id="formSubmit" action="{{ route($prefix.'.team.saveTeam') }}" method="post" data-parsley-validate>
                            
                        @endif
                            @csrf
                                <input type="hidden" name="id" value="{{ !empty($singleData) ? $singleData->id : '' }}">
                                <div class="row">
                                    @if(session()->has('branch'))
                                    <input type="hidden" name="branchId" value="{{ session()->get('branch')->_id }}">
                                    @elseif(session()->has('team'))
                                    <input type="hidden" name="branchId" value="{{ session()->get('team')->branchId }}">
                                  
                                    @else
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Branch <span class="red">*</span></label>
                                            <select class="form-control" name="branchId" required>
                                                <option value="">Select</option>
                                                @foreach ($branch as $key=>$val)
                                                    <option value="{{$val->_id}}" {{!empty($singleData) && new ObjectId($singleData->branchId) == $val->_id ? 'selected' :'' }}>{{$val->branch_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Name <span class="red">*</span></label>
                                        <input type="text" class="form-control" placeholder="" name="name"
                                            required="" value="{{ !empty($singleData) ? $singleData->name : old('name') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Email ID <span class="red">*</span></label>
                                        <input type="email" id="Email" class="form-control" placeholder="" name="email"
                                            required  value="{{ !empty($singleData) ? $singleData->email : '' }}" onblur="checkEmail()">
                                    </div>
                                    <span id="email_error" style="color: red"></span>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Mobile <span class="red">*</span></label>
                                        <input type="text" class="form-control" name="mobile" value="{{ !empty($singleData) ? $singleData->mobile : old('mobile') }}" required onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="10">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Employee Code </label>
                                        <input type="text" class="form-control"  name="employee_code" value="{{ !empty($singleData) ? $singleData->employee_code : old('employee_code') }}">
                                    </div>
                                </div>

                              
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Department <span class="red">*</span></label>
                                        
                                        <select class="form-select" name="department" id="departmentId" onchange="getDezignation()" required>
                                            <option value="">Select</option>
                                            @foreach($department as $key=>$val)
                                            
                                            @if(session()->has('admin') && $val->name == 'Branch Sub Admin' || session()->has('admin') && $val->name == 'Sub (Human Resources - HR)')
                                                         @continue
                                                         
                                            @endif
                                            @if(session()->has('branch') && $val->name == 'Sub Admin' || session()->has('branch') && $val->name == 'Sub (Human Resources - HR)')
                                                         @continue
                                                         
                                            @endif
                                            @if(session()->has('team') && $val->name == 'Branch Sub Admin' || session()->has('team') && $val->name == 'Sub Admin' ||  session()->has('team') && session()->get('team')->department !='6790b8df2ef8f2064c61d079' && $val->name == 'Sub (Human Resources - HR)')
                                                         @continue
                                                         
                                            @endif
                                           @if(session()->has('team') && session()->get('team')->department=='6790b8df2ef8f2064c61d079' && $val->name == 'Human Resource')
                                                  @continue
                                           @endif
                                           @if(session()->has('team') && session()->get('team')->department=='67bd6d68d4de44c0093ea46f' && $val->name == 'Human Resource')
                                                  @continue
                                           @endif

                                            @if(session()->has('team') && (string) session()->get('team')->department == (string) $val->_id && (string) session()->get('team')->department != '6790b8df2ef8f2064c61d079')
                                            <option value="{{ $val->_id }}" 
                                                {{ !empty($singleData) && (string) $singleData->department == (string) $val->_id ? 'selected' : '' }}>
                                                {{ $val->name }} 
                                            </option>

                                            @php 
                                                break;
                                            @endphp
                                            @else
                                            
                                            <option value="{{ $val->_id }}" 
                                                {{ !empty($singleData) && (string) $singleData->department == (string) $val->_id ? 'selected' : '' }}>
                                                {{ $val->name }} 
                                            </option>
                                            @endif
                                            @endforeach 
                                        </select>
                                  
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Designation <span class="red">*</span></label>
                                        <div id="designationIdDiv">
                                        <select class="form-select" name="designation" id="designationId" required>
                                            <option value="">Select</option>
                                            @if(!empty($singleData))
                                                @foreach($designation as $key=>$val)
                                               
                                                <option value="{{ $val->_id }}"  {{ (string) $singleData->designation==(string) $val->_id ? 'selected' : '' }}>{{ $val->name }} </option>
                                           
                                               @endforeach 
                                            @endif
                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Password <span class="red">*</span></label>
                                        <input type="text" class="form-control" placeholder="" name="password"
                                            required="" value="{{ !empty($singleData) ? base64_decode($singleData->show_password) : old('show_password') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="mt-4 pt-4">
                                            <input type="checkbox" name="status" value="1" {{ !empty($singleData) && $singleData->status==1 ? 'checked' : '' }} id="act">
                                            <label class="form-label" for="act">Active/Deactive</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12"></div>
                                <div class="col-md-12">
                                    <div class="form-group text-end">
                                        <button id="submitButton" type="submit" class="btn btn-primary d-inline-block"
                                            style="width: auto; ">Submit</button>
                                    </div>
                                </div>
                            </div>
                            </form>
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
<script>
    function getDezignation(){
        var departmentId = $('#departmentId').val();

        $.ajax({
             type: "POST",
             url: "{{ route(name: 'getDesignation') }}",
             data: {
                 'departmentId': departmentId,
                 '_token': "{{ csrf_token() }}"
             },
             success: function(data){
                 $('#designationIdDiv').html(data.html);
             }
         });
    }
    function checkEmail(){
     $('#email_error').html('');
     var Email = $('#Email').val();
     @if(!empty($singleData))
         return true;
     @endif
     if(Email != ''){
         $.ajax({
             type: "POST",
             url: "{{ route('checkTeamMail') }}",
             data: {
                 'email': Email,
                 '_token': "{{ csrf_token() }}"
             },
             success: function(data){
                 if(data.exists){ // Access 'exists' property of the JSON response
                     $('#email_error').html('This email is already registered.');
                     $('#submitButton').attr('disabled', true);
                 } else {
                     $('#submitButton').attr('disabled', false);
                 }
             }
         });
     }
 }
</script>
@endsection
