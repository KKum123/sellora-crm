@extends('admin.layouts.master')
@section('content')
<div class="content-body">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Exit Interview</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                  <form id="formSubmit" class="needs-validation" action="{{route('team.opsPemployeeManagementuls.saveExitInterview')}}" method="post">
                  @csrf
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Employee Name <span class="red">*</span></label>
                        <div class="dropdown bootstrap-select default-select form-control wide">
                          
                        <select class="default-select form-control wide" name="employeeId" id="employeeId" onchange="employeeChange()" required>
                            <option value="">Select Name</option>
                            @foreach($employee as $key=>$val)
                              <option value="{{$val->_id}}">{{$val->name}}</option>
                            @endforeach
                        </select>

                      </div>
                    </div>
                  </div>
                    <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-label">Email ID <span class="red">*</span></label>
                            <div class="dropdown bootstrap-select default-select form-control wide">
                             <input type="text" class="form-control" name="emialId" id="emialId" value="" readonly>
                              
                          </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Department <span class="red">*</span></label>
                        <input type="text" class="form-control"  id="departmentIdE" value="" readonly>
                        <input type="hidden" class="form-control" name="departmentId" id="departmentId" value="" >
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Job Tittle <span class="red">*</span></label>
                        <input type="text" class="form-control" name="JobTittle" id="JobTittle" value="" readonly>
                        <input type="hidden" class="form-control" name="designationId" id="designationId" value="">
                      
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Date of Joining <span class="red">*</span></label>
                        <input type="text" class="form-control"  id="DateOfJoining" value="" required readonly>
                        <input type="hidden" class="form-control" name="DateOfJoining" id="DateOfJoining" value="">
                      
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Last Working Day <span class="red">*</span></label>
                        <input type="date" class="form-control" name="LastWorkingDay" id="LastWorkingDay" required="">                        
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label">Would you consider rejoining our company in the future <span class="red">*</span></label>
                        <select class="form-select" name="considerRejoiningOurCompany" id="considerRejoiningOurCompany" required="">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                      </div>
                    </div>
                    
                    <div class="col-md-12"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-label">Reason of Leaving <span class="red">*</span></label>
                          <div class="dropdown bootstrap-select default-select form-control wide">
                              <textarea class="form-control" style="min-height: 100px;" name="ReasonOfLeaving" id="ReasonOfLeaving" required></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-label">Feedback for Company <span class="red">*</span></label>
                          <div class="dropdown bootstrap-select default-select form-control wide">
                              <textarea class="form-control" style="min-height: 100px;" id="FeedbackForCompany" name="FeedbackForCompany" required></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-label">Reporting manager Feedback <span class="red">*</span></label>
                          <div class="dropdown bootstrap-select default-select form-control wide">
                              <textarea class="form-control" style="min-height: 100px;" name="ReportingManagerFeedback" id="ReportingManagerFeedback" required></textarea>
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
        <!-- end -->
        
        <div class="col-lg-12">
          <div class="card d-none">
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
                          <th>Employee ID</th>
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
                        <tr>
                          <td>1.</td>
                          <td><a href="profile.html">#789546</a> </td>
                          <td valign="top"><strong>Sandeep Shah</strong></td>
                          <td valign="top">Operations Manager</td>
                          <td valign="top">Manoj</td>
                          <td valign="top">10 Oct 24</td>
                          <td valign="top">10 Nov 24</td>
                          <td valign="top"></td>
                          <td valign="top">Team Contribution</td>
                          <td valign="top"></td>
                          <td valign="top"></td>
                          <td valign="top"></td>
                          <td valign="top">Fully Achieved</td>
                          <td valign="top">High</td>
                          <td valign="top">Weekly</td>
                          <!-- <td valign="top">
                            <a href="onboarding-employee.html"> <i class="ri-edit-line"></i></a> 
                            <a href="https://selloracrm.akslearning.in/admin/team/delete-team/12" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                          </td>
                          <td><a  style="color: green">Active</a></td> -->
                        </tr>
                        
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
  function employeeChange(){
    var employeeId  = $('#employeeId').val();
    var employeeArr = @json($employee);
    var selectedEmployee = employeeArr.find(emp => emp._id == employeeId);
   
      if (selectedEmployee) {

        $('#emialId').val(selectedEmployee.email || '');
        $('#departmentIdE').val(selectedEmployee.department1.name || '');
        $('#departmentId').val(selectedEmployee.department || '');
        $('#designationId').val(selectedEmployee.designation1._id || '');
        $('#JobTittle').val(selectedEmployee.designation1.name || '');
        $('#DateOfJoining').val(selectedEmployee.joinDate || '');

      } else {
        $('#emialId').val('');
        $('#departmentIdE').val('');
        $('#departmentId').val('');
        $('#JobTittle').val('');
        $('#DateOfJoining').val('');
      }
  }
</script>
@endsection