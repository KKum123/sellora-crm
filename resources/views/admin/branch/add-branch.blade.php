@extends('admin.layouts.master')
@section('content')
@if(session()->has('admin'))
@php $prefix = 'admin'; @endphp
@elseif(session()->has('branch'))
@php $prefix = 'branch'; @endphp
@elseif(session()->has('team'))
@php $prefix = 'team'; @endphp
@endif
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Branch</h4>
                    </div>
                    <div class="card-body">
                        <form id="formSubmit" action="{{ route($prefix.'.branch.addSaveBranch') }}" method="post" data-parsley-validate="">
                            <input type="hidden" name="id" value="{{ !empty($singleData) ? $singleData->id : '' }}">
                            @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">Select Country <span class="red">*</span></label>
                                    <select class="form-select" name="country" required="">
                                        <option value="">Select</option>
                                        @foreach($country as $key => $val)
                                            <option value="{{ $val->name }}" {{ !empty($singleData) && $singleData->country==$val->name? 'selected' :'' }}>{{ $val->name }}</option> 
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Branch Name <span class="red">*</span></label>
                                    <input type="text" class="form-control" placeholder="" name="branch_name" required
                                        value="{{ !empty($singleData->branch_name) ? $singleData->branch_name : old('branch_name') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Branch Code <span class="red">*</span></label>
                                    <input type="text" class="form-control" placeholder="" name="branch_code" required
                                        value="{{ !empty($singleData) ? $singleData->branch_code : old('branch_code') }}" required>
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Manager Name <span class="red">*</span></label>
                                    <input type="text" class="form-control"
                                        placeholder="Ek branch mein kitane ayenge" name="manager_name" value="{{ !empty($singleData) ? $singleData->manager_name : old('manager_name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Email ID<span class="red">*</span></label>
                                    <input type="email" id="Email" class="form-control" placeholder="" name="email" required
                                        value="{{ !empty($singleData) ? $singleData->email : old('email') }}">
                                <span id="email_error"></span>
                                    </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">Mobile Number <span class="red">*</span></label>
                                    <input type="text" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="mobile" id="mobile" value="{{ !empty($singleData) ? $singleData->mobile : old('mobile') }}" required maxlength="10" >
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">Complete Address</label>
                                    <textarea class="form-control" name="complete_address">{{ !empty($singleData) ? $singleData->complete_address : old('complete_address') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">State <span class="red">*</span></label>
                                    <input type="text" class="form-control" name="state" id="state" value="{{ !empty($singleData) ? $singleData->state : old('state') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">City <span class="red">*</span></label>
                                    <input type="text" class="form-control" name="city" value="{{ !empty($singleData) ? $singleData->city : 'city' }}">
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Pincode <span class="red">*</span></label>
                                    <input type="text" class="form-control" name="pincode" value="{{ !empty($singleData) ? $singleData->pincode : '' }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Password <span class="red">*</span></label>
                                    <input type="text" class="form-control" placeholder="" name="password" value="{{ !empty($singleData) ? base64_decode($singleData->show_password): '' }}" required
                                        value="">
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <input type="checkbox" id="act" name="status" value="1" {{ !empty($singleData) && $singleData->status==1 ? 'checked' : '' }}>
                                        <label class="form-label" for="act">Active/Deactive</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-end">
                                    <label class="form-label d-block">&nbsp;</label>
                                    <button id="submitButton" type="submit" id="" class="btn btn-primary d-inline-block"
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
    function checkEmail(){
     $('#email_error').html('');
     var Email = $('#Email').val();
     @if(!empty($singleData))
         return true;
     @endif
     if(Email != ''){
         $.ajax({
             type: "POST",
             url: "{{ route('checkBranchMail') }}",
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
