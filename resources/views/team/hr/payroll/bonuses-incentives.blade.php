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
              <h4 class="card-title">Bonuses And Incentives</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                  <form id="formSubmit" method="post" action="{{ route($prefix.'.Payroll.bonusesAndIncentivesSave') }}">
                  @csrf
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Employee Name <span class="red">*</span></label>
                        <div class="dropdown bootstrap-select default-select form-control wide">
                          <select class="default-select form-control wide" name="employeeId" id="emplyeeSelect" onchange="employeeChange()" required>
                            <option value="">Select Name</option>
                            @foreach ($employee as $key=>$val)
                            <option value="{{ $val->_id }}">{{ $val->name }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-label">Employee Code <span class="red">*</span></label>
                            <div class="dropdown bootstrap-select default-select form-control wide">
                              <input type="text" class="form-control" name="employeeIdCode" id="employeeIdCode" value="" readonly required>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Department <span class="red">*</span></label>
                        <input type="text" class="form-control" name="department" id="department" readonly required>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Designation <span class="red">*</span></label>
                        <input type="text" class="form-control" name="designation" id="designation" readonly required>
                      </div>
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Bonus/Incentive Type <span class="red">*</span></label>
                        <select class="form-select" name="bonusOrIncentiveType" required="">
                            <option value="">Select</option>
                            <option>Performance Bonuses</option>
                            <option>Sales Incentive</option>
                            <option>Lead Conversion Incentives</option>
                            <option>Customer Retention Incentives</option>
                            <option>Referral Bonuses</option>                            
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Bonus/Incentive Amount <span class="red">*</span></label>
                        <input type="text" name="bonusOrIncentiveAmount" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" class="form-control" placeholder="" required="">
                      </div>
                    </div>
                </div>

                    <div class="col-md-2">
                      <label class="form-label d-block">&nbsp;</label>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end -->
        
        <div class="col-lg-12">
          <div class="card">
            <!-- <div class="card-header">
              <h4 class="card-title">View All Lead</h4>
            </div> -->            
            <div class="card-body"> 
              <h5>Bonuses Incentives List</h5>
              <hr>              
              <div class="row">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-styling table-hover table-striped table-primary">
                      <thead>
                        <tr>
                          <th width="50">SN.</th>
                          <th>Employee Code</th>
                          <th width="230">Employee Name</th>
                          <th width="100">Department</th>
                          <th width="100">Designation</th>
                          <th width="200">Bonus/Incentive Type</th>
                          <th>Bonus/Incentive Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($List as $key=>$val)
                        <tr>
                          <td>{{ $key + $List->firstItem() }}.</td>
                          <td><a href="{{ route($prefix.'.team.profileView', $val->employee->_id) }}">#{{ !empty($val->employee->employee_code) ? $val->employee->employee_code : '---' }}</a> </td>
                          <td valign="top"><strong>{{ $val->employee->name }}</strong></td>
                          <td valign="top">{{ !empty($val->employee->department1) ? $val->employee->department1->name : '' }}</td>
                          <td valign="top">{{ !empty($val->employee->designation1) ? $val->employee->designation1->name : '' }}</td>
                          <td valign="top">{{ $val->bonusOrIncentiveType }}</td>
                          <td>{{ !empty($val->bonusOrIncentiveAmount) ? '$'.number_format($val->bonusOrIncentiveAmount, 2) : ''}}</td>
                        </tr>
                        @endforeach
                        
                      </tbody>
                    </table>                                                          
                  </div>
                  <!-- responsive table end --> 
                </div>
              </div>              
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
  function employeeChange() {
    var emplyeeSelect = $('#emplyeeSelect').val();
    var employeeArr = @json($employee);

    // Ensure employeeArr is an array before calling find()
    if (!Array.isArray(employeeArr)) {
        console.error('Employee data is not an array:', employeeArr);
        return;
    }

    var selectedEmployee = employeeArr.find(emp => emp._id === emplyeeSelect);

    if (selectedEmployee) {
        $('#employeeIdCode').val(selectedEmployee.employee_code || '');
        $('#department').val(selectedEmployee.department1?.name || '');
        $('#designation').val(selectedEmployee.designation1?.name || '');
    } else {
        $('#employeeIdCode, #department, #designation').val('');
    }
}
</script>
@endsection