@extends('admin.layouts.master')
@section('content')
@if(session()->has('admin'))
@php $prefix = 'admin'; @endphp
@elseif(session()->has('branch'))
@php $prefix = 'branch'; @endphp
@elseif(session()->has('team')) 
@php $prefix = 'team'; @endphp
@endif

<div class="content-body" style="min-height: 235px;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Add Client</h4>
              <!-- <button type="button" class="btn btn-primary d-inline-block" onclick="document.getElementById('id01').style.display='block'" style="width: auto"> <i class="fa fa-file-excel"></i> Excel Upload</button> -->
            </div>
            <div class="card-body">
               
                <form class="formSubmit" action="{{ route($prefix.'.task-pulse.cSaveClient') }}" method="post" data-parsley-validate="">
                    @csrf 
                    <input type="hidden" name="id" value="{{!empty($singleData) ? $singleData->_id : ''}}">

                    <div class="row">
                    @if(session()->has('admin'))
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="form-label">Country <span class="red">*</span></label>
                        <select class="form-select" name="countryName" onchange="selectCountry()" id="country" required>
                            <option value="">Select</option>
                            
                            @foreach ($country as $key=>$val)
                            <option value="{{$val->name}}" {{!empty($singleData) && $singleData->countryName==$val->name ? 'selected' : ''}}>{{$val->name}}</option>
                            
                            @endforeach
                         
                        </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="form-label">Branch <span class="red">*</span></label>
                        <div id="baranchIdDiv">
                        <select class="form-select" name="branchId" id="baranchId" onchange="branchChange()" required>
                            <option value="">Select</option>
                            @if(!empty($singleData))
                                @foreach ($branch as $key=>$val)
                                <option value="{{$val->_id}}" {{!empty($singleData) && $singleData->branchId==$val->_id ? 'selected' : ''}}>{{$val->branch_name}}</option>
                                @endforeach
                            @endif
                        </select>
                        </div>
                        </div>
                    </div>
                    @endif
                    <!-- <div class="col-md-4">
                        <div class="form-group">
                        <label class="form-label">Request ID</label>
                        <input type="text" class="form-control" placeholder="Ask about this field ?" name="requestId" value="{{!empty($singleData) ? $singleData->requestId : ''}}">
                        </div>
                    </div> -->
                  
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="form-label">Requester Name <span class="red">*</span></label>
                        <input type="text" class="form-control" name="requestName" value="{{!empty($singleData) ? $singleData->requestName : ''}}" required placeholder="Client" >                  </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="form-label"> Code. <span class="red">*</span></label>
                            <select name="countryCode" id="countryCode" class="form-control" required>
                                <option value="">-Select-</option>
                                @foreach ($countryList as $key=>$val)
                                    <option value="{{ $val['code'] }}" {{ !empty($singleData) && $singleData->countryCode == $val['code'] ? 'selected' : '' }}>{{ $val['code'] }} ({{ $val['iso'] }}) </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        <label class="form-label">Phone No. <span class="red">*</span></label>
                        <input type="text" maxlength="10" class="form-control"   onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="phoneNo" required placeholder="" value="{{!empty($singleData) ? $singleData->phoneNo : ''}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="form-label">Email ID <span class="red">*</span></label>
                        <input type="text" class="form-control" name="emailId" value="{{!empty($singleData) ? $singleData->emailId : ''}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="form-label">City <span class="red">*</span></label>
                        <input type="text" class="form-control" placeholder="" required name="city" value="{{!empty($singleData) ? $singleData->city : ''}}" required>
                        </div>
                    </div>
                   
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="form-label">Service Category <span class="red">*</span></label>
                        <input type="text" class="form-control" placeholder="Ask about this field ?" required name="serviceCategory" value="{{!empty($singleData) ? $singleData->serviceCategory : ''}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="form-label">Requester Location <span class="red">*</span></label>
                        <input type="text" class="form-control" placeholder="" name="requestLocation" value="{{!empty($singleData) ? $singleData->requestLocation : ''}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="form-label">Requester Sell in Country <span class="red">*</span></label>
                        <select class="form-select" name="requestSellCountry" required>
                                <option value="">Select</option>
                                @foreach ($countryList as $key=>$val)
                                    <option value="{{ $val['country'] }}" {{ !empty($singleData) && $singleData->requestSellCountry == $val['country'] ? 'selected' : '' }}>{{ $val['country'] }}</option>
                                @endforeach
                                                     
                        </select>
                        </div>
                    </div>
                  @if(session()->has('admin') || session()->has(key: 'branch')|| session()->has('team') && session()->get('team')->department=='67bd3ca8d4de44c0093ea46c' || session()->has('team') && session()->get('team')->department=='67bd3cd7d4de44c0093ea46d')
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="form-label">Assign to Operation Manager <span class="red">*</span></label>
                        <select class="form-select" name="assignAdminByOperationManager" id="assignAdminByOperationManager" required>
                                <option value="">Select</option>
                                @foreach ($team as $key=>$val)
                                   <option value="{{$val->_id}}" {{!empty($singleData) && $singleData->assignAdminByOperationManager == new ObjectId($val->_id) ? 'selected' : ''}}>{{$val->name}} ({{$val->employee_code}})</option>     
                                @endforeach       
                        </select>
                        </div>
                    </div>
                    @endif
                

                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="form-label">Comment </label>
                        <textarea class="form-control" name="comment">{{!empty($singleData) ? $singleData->comment : '' }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="form-label">Note From Requester</label>
                        <input type="text" class="form-control" placeholder="" name="noteFromRequest" value="{{!empty($singleData) ? $singleData->noteFromRequest : ''}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="form-label">Job Title</label>
                        <input type="text" class="form-control" placeholder="" name="jobTitle" value="{{!empty($singleData) ? $singleData->jobTitle : ''}}" required>
                        </div>
                    </div>
                    <div class="col-md-12"><hr></div>
                    <div class="col-md-6">
                        <div class="mb-3 mt-0">
                            <input type="hidden" name="status" value="1">
                        <!-- <input type="checkbox" name="status" {{!empty($singleData) && $singleData->status==1 ? 'checked'  : ''}} value="1">
                        <label class="form-label">Active/Deactive</label> -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <button type="submit" class="btn btn-primary d-inline-block" style="width: auto; float: right;">Submit</button>
                        </div>
                    </div>
                    </div>
                </form>
              <!-- row end --> 
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
      $('.formSubmit').each(function() {
          $(this).parsley().on('field:validated', function() {
              var ok = $('.parsley-error').length === 0;
              $('.bs-callout-info').toggleClass('hidden', !ok);
              $('.bs-callout-warning').toggleClass('hidden', ok);
          }).on('form:submit', function(e) {
              $('#spiner').css('display', 'flex');
          });
      });
    
      $('.formSubmit').on('submit', function(e) {
          e.preventDefault(); 
          var form = $(this);
    
          if (form.parsley().validate()) {
              $('#spiner').css('display', 'flex'); 
              form.unbind('submit').submit(); 
          }
      });
    });
    
</script>
<script>
    function selectCountry(){
        var country = $('#country').val();
        
        $.ajax({
            type : 'post',
            url  : "{{route('getBranch1')}}",
            data : {
                "_token" : "{{csrf_token()}}",
                "country":  country
            },
            success:function(res){
                $('#baranchIdDiv').html(res.html);
            }
        })
    }
</script>
<script>
    function branchChange(){
        var branchId = $('#branch').val();

            $.ajax({
                type: "POST",
                url: "{{ route('branch-using-operation-manager') }}", 
                data: { 
                    "branchId": branchId,
                    "_token" : "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(res) {
                    $('#assignAdminByOperationManager').html(res.html);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
    }
</script>
@endsection


