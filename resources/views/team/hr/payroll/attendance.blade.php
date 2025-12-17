@extends('admin.layouts.master')
@section('content')

@if(session()->has('admin'))
  @php $prefix = 'admin'; @endphp
    @elseif(session()->has('branch'))
  @php $prefix = 'branch'; @endphp
    @elseif(session()->has('team')) 
  @php $prefix = 'team';@endphp
@endif

<div class="content-body">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Attendance</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <form class="needs-validation">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Employee Name</label>
                        <select class="default-select form-control wide" id="employeeId" >
                            <option value="">Select Name</option>
                            @foreach ($employee as $key=>$val)
                              <option value="{{ $val->_id }}">{{ $val->name }}</option>
                            @endforeach
                        </select>
                        <span style="color: red;" id="employeeError"></span>
                      </div>
                    </div>
                     <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Select Month</label>
                        <select class="default-select form-control wide"  id="month">
                            <option value="">Select</option>
                            @foreach ($months as $key=>$val)
                            <option value="{{ $key+1 }}" {{ (int) date('m') == $key+1 ? 'selected' :'' }}>{{ $val }}</option>
                            @endforeach 
                            
                        </select>
                        <span style="color: red;" id="monthError"></span>
                      </div>
                    </div>
                     <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Select Year</label>
                        <select class="default-select form-control wide" id="year" >
                          <option value="">Select</option>
                          @for ($i=2019; $i<=date('Y'); $i++)
                            <option value="{{ $i }}" {{ date('Y')==$i ? 'selected' : '' }}>{{ $i }}</option>
                          @endfor
                              </select>
                              <span style="color: red;" id="yearError"></span>
                        </div>
                      </div>

                    
                    <div class="col-md-2">
                      <label class="form-label d-block">&nbsp;</label>
                      <button type="button" class="btn btn-primary" onclick="onloadCalander()">Search</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end -->
        
       <div id="appendCalander">
        
       </div>
        <!-- end --> 
        
      </div>
    </div>
  </div>
  
@endsection
@section('javascript')
<script>
  function onloadCalander() {
    let employeeId = $('#employeeId').val().trim();
        let month = $('#month').val().trim();
        let year = $('#year').val().trim();
        let isValid = true;

        // Reset previous errors
        $('.error-message').html(''); 

        if (employeeId === '') {
            $('#employeeError').html('<i class="fa fa-exclamation-circle"></i> Please select an employee').css('color', 'red');
            $('#employeeId').focus();
            return false;
        }

        if (month === '') {
            $('#monthError').html('<i class="fa fa-exclamation-circle"></i> Please select a month').css('color', 'red');
            if (isValid) $('#month').focus();
            return false;
        }

        if (year === '') {
            $('#yearError').html('<i class="fa fa-exclamation-circle"></i> Please select a year').css('color', 'red');
            if (isValid) $('#year').focus();
            return false;
        }

     
        
    $('#spiner').css('display','flex');
    $.ajax({
      method: "GET",
      url: "{{ route($prefix.'.Payroll.getCalander') }}",
      data: {
        'employeeId': employeeId,
        'month': month,
        'year': year
      }, 
      success: function(res) {
        $('#appendCalander').html(res.html);
        $('#spiner').css('display','none');
      },
      error: function(xhr, status, error) {
        console.error("Error fetching calendar:", error);
      }
    });
  }

  $(document).ready(function() {
    $('#employeeId').change(function () {
        $('#employeeError').html('');
    });
    $('#month').change(function () {
        $('#monthError').html('');
    });
    $('#year').change(function () {
        $('#yearError').html('');
    });
  });
  
</script>

@endsection