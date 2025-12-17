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
@if(session()->has('team') && session()->get('team')->department=='6790b8df2ef8f2064c61d079' || session()->get('team')->department=='67bd6d68d4de44c0093ea46f')
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Goal Setting and Tracking</h4>
          </div>
          <form id="formSubmit" method="post" action="{{route('team.performanceManagementuls.saveGoalSetting')}}">
            @csrf
            <div class="card-body">
              <div class="form-validation">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label">Employee Name <span class="red">*</span></label>
                      <div class="dropdown bootstrap-select default-select form-control wide">
                        <select class="default-select form-control wide" onchange="employeeChange()" name="employeeId"
                          id="emplyeeSelect" required>
                          <option value="">Select Name</option>
                          @foreach ($employee as $key => $val)
                <option value="{{$val->_id}}">{{$val->name}}</option>
              @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label">Employee Code <span class="red">*</span></label>
                      <input type="text" name="employeeIdCode" class="form-control" id="employeeIdCode" value=""
                        readonly>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label">Department <span class="red">*</span></label>
                      <input type="text" name="department" class="form-control" id="department" value="" readonly>
                      <input type="hidden" name="departmentId" class="form-control" id="departmentId" value="">

                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label">Manager/Supervisor <span class="red">*</span></label>
                      <input type="text" name="managerName" id="managerName" value="" class="form-control" readonly>
                      <input type="hidden" name="managerId" id="managerId" value="">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label">Date Assigned <span class="red">*</span></label>
                      <input type="date" class="form-control" id="dateAssigned" name="dateAssigned" value="" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label">Goal Review Date <span class="red">*</span></label>
                      <input type="date" class="form-control" name="goalReviewDate" id="goalReviewDate">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label">Goal Title <span class="red">*</span></label>
                      <input type="text" class="form-control" placeholder="" id="goalTitle" name="goalTitle" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label">Goal Type <span class="red">*</span></label>
                      <select class="form-select" name="goalType" id="goalType" required="">
                        <option value="">Select</option>
                        <option>Performance Improvement</option>
                        <option>Professional Development</option>
                        <option>Project-Specific Goal</option>
                        <option>Team Contribution</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label">Revenue Target <span class="red">*</span></label>
                      <div class="dropdown bootstrap-select default-select form-control wide">
                        <input type="text" class="form-control" name="revenueTarget" id="revenueTarget" placeholder=""
                          required="">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label">Milestone Status <span class="red">*</span></label>
                      <div class="dropdown bootstrap-select default-select form-control wide">
                        <select class="default-select form-control wide" name="milestoneStatus" id="milestoneStatus"
                          required>
                          <option value="">Select</option>
                          <option value="Fully Achieved">Fully Achieved</option>
                          <option value="Partially Achieved">Partially Achieved</option>
                          <option value="Not Achieved">Not Achieved</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label">Goal Priority <span class="red">*</span></label>
                      <div class="dropdown bootstrap-select default-select form-control wide">
                        <select class="default-select form-control wide" name="goalPriority" required>
                          <option value="">Select</option>
                          <option value="High">High</option>
                          <option value="Medium">Medium </option>
                          <option value="Low">Low</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label">Frequency of Updates <span class="red">*</span></label>
                      <div class="dropdown bootstrap-select default-select form-control wide">
                        <select class="default-select form-control wide" name="frequencyOfUpdates" required>
                          <option value="">Select</option>
                          <option value="Weekly">Weekly</option>
                          <option value="Bi-Weekly">Bi-Weekly</option>
                          <option value="Monthly">Monthly</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-label">Completion Date <span class="red">*</span></label>
                      <div class="dropdown bootstrap-select default-select form-control wide">
                        <input type="date" class="form-control" required="" name="completionDate" value="">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12"></div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Manager Feedback <span class="red">*</span></label>
                      <div class="dropdown bootstrap-select default-select form-control wide">
                        <textarea class="form-control" style="min-height: 100px;" name="managerFeedback"
                          required></textarea>
                      </div>
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
  @endif
  <!-- end -->

  <div class="col-lg-12">
    <div class="card">
      <!-- <div class="card-header">
              <h4 class="card-title">View All Lead</h4>
            </div> -->

      <div class="card-body">
        <h5>Goal Setting and Tracking List</h5>
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
                    <th>Manager/Supervisor</th>
                    <th>Date Assigned</th>
                    <th>Goal Review Date</th>
                    <th>Goal Title</th>
                    <th>Goal Type</th>
                    <th>Revenue Target</th>
                    <th>Milestone Status</th>
                    <th>Goal Priority</th>
                    <th>Frequency of Updates</th>
                    <th>Completion Date</th>
                    <th>Manager Feedback</th>

                    <!-- <th width="50">Action</th>
                          <th width="50">Status</th> -->
                  </tr>
                </thead>
                <tbody>
                  @foreach ($List as $key => $val)

            <tr>
            <td>{{$key + $List->firstItem()}}</td>
            <td><a href="{{ route($prefix.'.team.profileView', $val->employee->_id) }}">#{{!empty($val->employee->employee_code) ? $val->employee->employee_code : '---'}}</a> </td>
            <td valign="top"><strong>{{$val->employee->name}}</strong></td>
            <td valign="top">{{!empty($val->employee->department1) ? $val->employee->department1->name : ''}}
            </td>
            <td valign="top">{{ !empty($val->manager) ? $val->manager->name : ''}}</td>
            <td valign="top">{{date('d M Y', strtotime($val->dateAssigned))}}</td>
            <td valign="top">{{date('d M Y', strtotime($val->goalReviewDate))}}</td>
            <td valign="top">{{$val->goalTitle}}</td>
            <td valign="top">{{$val->goalType}}</td>
            <td valign="top">{{$val->revenueTarget}}</td>
            <td valign="top">{{$val->milestoneStatus}}</td>
            <td valign="top">{{$val->goalPriority}}</td>
            <td valign="top">{{$val->frequencyOfUpdates}}</td>
            <td valign="top">{{$val->completionDate}}</td>
            <td valign="top">{{$val->managerFeedback}}</td>
            </tr>
          @endforeach
                </tbody>
              </table>
              {!!$List->links()!!}
            </div>
            <!-- responsive table end -->
          </div>
        </div>
      </div>



    </div>
  </div>
  <!-- end -->

</div>

@endsection
@section('javascript')
<script>
  $(function () {
    $('#formSubmit').parsley().on('field:validated', function () {
      var ok = $('.parsley-error').length === 0;
      $('.bs-callout-info').toggleClass('hidden', !ok);
      $('.bs-callout-warning').toggleClass('hidden', ok);
    })
      .on('form:submit', function () {
        $('#spiner').css('display', 'flex');
      });
  });

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
        $('#department').val(selectedEmployee.department1 ? selectedEmployee.department1.name || '' : '');
        $('#departmentId').val(selectedEmployee.department || '');

       
        if (selectedEmployee.sales_manage) {
            $('#managerId').val(selectedEmployee.sales_manage._id || '');
            $('#managerName').val(selectedEmployee.sales_manage.name || '');
        } else if (selectedEmployee.operation_manage) {
            $('#managerId').val(selectedEmployee.operation_manage._id || '');
            $('#managerName').val(selectedEmployee.operation_manage.name || '');
        } else {
            $('#managerId').val('');
            $('#managerName').val('');
        }
    } else {
        $('#employeeIdCode, #department, #departmentId, #managerId, #managerName').val('');
    }
}

</script>
@endsection