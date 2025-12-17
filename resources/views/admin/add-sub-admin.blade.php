@extends('admin.layouts.master')
@section('content')

@php 
      use MongoDB\BSON\ObjectId;
@endphp
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Create Sub Admin</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form action="{{ route('admin.subadmin.sub-admin') }}" method="post" data-parsley-validate>
                                    @csrf
                                    <input type="hidden" name="id" value="{{ !empty($singleData) ? $singleData->id : '' }}">
                                    <div class="row">
                                    <div class="col-md-4">
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
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Name <span class="red">*</span></label>
                                                <input type="text" name="name" value="{{ !empty($singleData) ? $singleData->name : '' }}" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Email <span class="red">*</span></label>
                                                <input type="email" id="Email" name="email" value="{{ !empty($singleData) ? $singleData->email : '' }}"  required class="form-control" onchange="checkEmail()">
                                                <span id="email_error" style="color: red"></span>
                                                @if ($errors->has('email'))
                                                <span class="help-block font-red-mint">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-12"></div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Employee Code</label>
                                                <input type="text" name="employeeCode"   value="{{ !empty($singleData) ? $singleData->employeeCode : '' }}"  class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Mobile <span class="red">*</span></label>
                                                <input type="text" name="phone" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value="{{ !empty($singleData) ? $singleData->phone : '' }}" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Create Password <span class="red">*</span></label>
                                                <input type="text" name="password" value="{{ !empty($singleData) ? base64_decode($singleData->show_password) : '' }}" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12"></div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <input type="checkbox" name="status" value="1" {{ !empty($singleData) && $singleData->status==1 ? 'checked' : '' }}>
                                                <label class="form-label">Active/Deactive</label>
                                            </div>
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
       function checkEmail(){
        $('#email_error').html('');
        var Email = $('#Email').val();
        @if(!empty($singleData))
            return true;
        @endif
        if(Email != ''){
            $.ajax({
                type: "POST",
                url: "{{ route('checkMail') }}",
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

