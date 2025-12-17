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
                            <h4 class="card-title">Add Lead</h4>
                            <!-- <button type="button" class="btn btn-primary d-inline-block" onclick="document.getElementById('id01').style.display='block'" style="width: auto"> <i class="fa fa-file-excel"></i> Excel Upload</button> -->
                        </div>
                        <div class="card-body">
                            <form class="formSubmit" action="{{ route($prefix.'.lead.saveLead') }}" data-parsley-validate="" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ !empty($singleData) ? $singleData->id : '' }}">
                            <div class="row">
                                @if(session()->has('admin'))
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Country <span class="red">*</span></label>
                                        <select class="form-select" onchange="changeCountry()" name="country" id="country" required>
                                            <option value="">Select</option>
                                            @foreach($country as $key=>$val)
                                            <option value="{{ $val->name }}" {{ !empty($singleData) && $singleData->country ? 'selected' : '' }}>{{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Branch <span class="red">*</span></label>
                                      <div id="branchDiv">
                                       
                                        <select class="form-select" name="branch" id="branch" onchange="branchChange()" required>
                                            <option value="">Select</option>
                                            @if(!empty($singleData))
                                            @foreach($branch as $key=>$val)
                                            <option value="{{ $val->id }}" {{ !empty($singleData) && $singleData->branch == $val->id ? 'selected' : ''  }}>{{ $val->branch_name }}</option>
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
                                        <input type="text" class="form-control" placeholder="Ask about this field ?"
                                          name="request_id"  value="{{ !empty($singleData) ? $singleData->request_id : '' }}">
                                    </div>
                                </div> -->

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Requester Name <span class="red">*</span></label>
                                        <input type="text" class="form-control" name="requester_name" required=""
                                            placeholder="Client " value="{{ !empty($singleData) ? $singleData->requester_name : '' }}" required>
                                    </div>
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
                                        <input type="text" class="form-control" name="phone" required=""
                                            placeholder="" value="{{ !empty($singleData) ? $singleData->phone : '' }}" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Email ID <span class="red">*</span></label>
                                        <input type="email" class="form-control" name="email" required=""
                                            placeholder="" value="{{ !empty($singleData) ? $singleData->email : old('email') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">City <span class="red">*</span></label>
                                        <input type="text" class="form-control" name="city" value="{{ !empty($singleData) ? $singleData->city : '' }}" required placeholder="" required="">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Service Category <span class="red">*</span></label>
                                        <input type="text" class="form-control" name="service_category" value="{{ !empty($singleData) ? $singleData->service_category : '' }}" required placeholder="Ask about this field ?"
                                            required="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Requester Location <span class="red">*</span></label>
                                        <input type="text" name="requester_location" class="form-control" placeholder="" value="{{ !empty($singleData) ? $singleData->requester_location : '' }}"
                                            required="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Requester Sell in Country <span
                                                class="red">*</span></label>
                                       
                                        <select class="form-select" name="requester_sell_in_country" required>
                                            <option value="">Select</option>
                                            @foreach ($countryList as $key=>$val)
                                                <option value="{{ $val['country'] }}" {{ !empty($singleData) && $singleData->requester_sell_in_country == $val['country'] ? 'selected' : '' }}>{{ $val['country'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Assign to Sales</label>
                                            <div id="assignToSalesDive">
                                                <select class="form-select" name="assign_to_sales" id="assign_to_sales">
                                                    <option value="">Select</option>
                                                    @foreach ($sales as $key => $val)
                                                            <option value="{{ $val->_id }}"
                                                                @if(session()->has('admin') || session()->has('branch'))
                                                                    {{ !empty($singleData) && $singleData->unassignTeamId == $val->_id ? 'selected' : '' }}
                                                                @elseif(session()->has('team'))
                                                                    @php  
                                                                        $team = session()->get('team'); 
                                                                    @endphp
                                                                    
                                                                    @if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d')
                                                                        {{ !empty($singleData) && $singleData->unassignTeamId == $val->_id ? 'selected' : '' }}
                                                                    @else
                                                                        {{ !empty($singleData) && $singleData->assign_to_sales == $val->_id ? 'selected' : '' }}
                                                                    @endif
                                                                @endif
                                                            >
                                                                {{ $val->name }}
                                                            </option>
                                                        @endforeach

                                                </select>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Comments</label>
                                        <textarea class="form-control" name="comments">{{ !empty($singleData) ? $singleData->comments : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Note From Requester</label>
                                        <input type="text" class="form-control" placeholder="" name="note_from_requester"
                                            value="{{ !empty($singleData) ? $singleData->note_from_requester : '' }}" >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Job Title</label>
                                        <input type="text" class="form-control" placeholder="" name="job_title"
                                            value="{{ !empty($singleData) ? $singleData->job_title : '' }}" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3 mt-5">
                                        <!-- <input type="hidden" name="status" value="1"> -->
                                        <input type="checkbox" name="status" value="1" {{ !empty($singleData) && $singleData->status=='1' ? 'checked' :''  }}>
                                        <label class="form-label">Active/Deactive</label>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary d-inline-block"
                                            style="width: auto; float: right;">Submit</button>
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
    function changeCountry(){
        var country = $('#country').val();
        $.ajax({
            url : "{{route('getBranch')}}",
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "country" : country
            },
            success: function(response) {
               $('#branchDiv').html(response.html)
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }
</script>
<script>
    function branchChange(){
        var branchId = $('#branch').val();
       
            $.ajax({
                type: "POST",
                url: "{{ route('getSalesTeamBranch') }}",
                data: { 
                    "branchId": branchId,
                    "_token" : "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(res) {
                    $('#assignToSalesDive').html(res.html);
                    @if(session()->has('admin') || session()->has('branch'))
                        $('#assign_to_sales').attr('required', false);
                    @endif
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
    }
</script>
@endsection
