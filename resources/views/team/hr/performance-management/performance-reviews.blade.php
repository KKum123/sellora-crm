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
      @if(session()->has('team') && session()->get('team')->department=='6790b8df2ef8f2064c61d079' || session()->get('team')->department=='67bd6d68d4de44c0093ea46f')
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Performance Reviews</h4>
            </div>
             
              <div class="card-body">
                <div class="form-validation">
                  <form id="formSubmit" method="post" action="{{route('team.performanceManagementuls.savePerformanceReview')}}">
                    @csrf

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="form-label">Employee Name <span class="red">*</span></label>
                          <div class="dropdown bootstrap-select default-select form-control wide">
                            <select class="default-select form-control wide" name="employeeId" id="emplyeeSelect" onchange="employeeChange()">
                              <option value="">Select Name</option>
                              @foreach ($employee as $key=>$val)
                              <option value="{{$val->_id}}">{{$val->name}}</option>
                              @endforeach
                              
                              
                          </select>
                        </div>
                      </div>
                    </div>
                      <div class="col-md-3">
                            <div class="form-group">
                              <label class="form-label">Employee Code <span class="red">*</span></label>
                              <div class="dropdown bootstrap-select default-select form-control wide">
                                <input type="text" class="form-control" name="employeeIdCode" id="employeeIdCode" value="" readonly>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="form-label">Department <span class="red">*</span></label>
                          <input type="text" name="department" id="department" value="" class="form-control" readonly>
                          <input type="hidden" name="departmentId" id="departmentId" value="" class="form-control" readonly>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="form-label">Manager/Supervisor <span class="red">*</span></label>
                          <input type="text" name="managerName" id="managerName" value="" class="form-control" readonly>
                         
                          <input type="hidden" name="managerId" id="managerId" value="" class="form-control" readonly>
                        
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="form-label">Date of Review <span class="red">*</span></label>
                          <input type="date" class="form-control" required="" name="dateOfReview" id="dateOfReview">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="form-label">Review Period <span class="red">*</span></label>
                          <div class="row">
                              <div class="col-lg-6">
                                    <input type="date" class="form-control" placeholder="From" required="" name="reviewPeriodFrom" value="">
                              </div>
                              <div class="col-lg-6 ps-lg-0">
                                    <input type="date" class="form-control" placeholder="To" required="" name="reviewPeriodTo" value="">
                              </div>
                          </div>                        
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="form-label">Reviewer Name <span class="red">*</span></label>
                          <input type="text" class="form-control" placeholder="" required="" name="reviewerName">
                        </div>
                      </div>

                      <h4 class="mt-lg-4">Performance</h4>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-label">Job Knowledge <span class="red">*</span></label>
                            <div class="dropdown bootstrap-select default-select form-control wide">
                              <select class="default-select form-control wide" name="jobKnowledge" required>
                                <option value="">Select</option>
                                <option >Unsatisfactory</option>
                                <option >Needs Improvement </option>
                                <option >Meets Expectations</option>
                                <option >Excellent</option>                              
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-label">Quality of Work <span class="red">*</span></label>
                            <div class="dropdown bootstrap-select default-select form-control wide">
                              <select class="default-select form-control wide" required name="qualityOfWork">
                                <option value="">Select</option>
                                <option >Unsatisfactory</option>
                                <option >Needs Improvement </option>
                                <option >Meets Expectations</option>
                                <option >Excellent</option>                              
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-label">Productivity <span class="red">*</span></label>
                            <div class="dropdown bootstrap-select default-select form-control wide">
                              <select class="default-select form-control wide" name="productivity" required>
                                <option value="">Select</option>
                                <option >Unsatisfactory</option>
                                <option >Needs Improvement </option>
                                <option >Meets Expectations</option>
                                <option >Excellent</option>                              
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-label">Teamwork/Collaboration <span class="red">*</span></label>
                            <div class="dropdown bootstrap-select default-select form-control wide">
                              <select class="default-select form-control wide" name="teamworkCollaboration" required>
                                <option value="">Select</option>
                                <option >Unsatisfactory</option>
                                <option >Needs Improvement </option>
                                <option >Meets Expectations</option>
                                <option >Excellent</option>                              
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-label">Problem-Solving Skills <span class="red">*</span></label>
                            <div class="dropdown bootstrap-select default-select form-control wide">
                              <select class="default-select form-control wide" name="problemSolvingSkills" required>
                                <option value="">Select</option>
                                <option >Unsatisfactory</option>
                                <option >Needs Improvement </option>
                                <option >Meets Expectations</option>
                                <option >Excellent</option>                              
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-label">Adaptability <span class="red">*</span></label>
                            <div class="dropdown bootstrap-select default-select form-control wide">
                              <select class="default-select form-control wide" name="adaptability" required>
                                <option value="">Select</option>
                                <option>Unsatisfactory</option>
                                <option>Needs Improvement </option>
                                <option>Meets Expectations</option>
                                <option>Excellent</option>                              
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-label">Dependability <span class="red">*</span></label>
                            <div class="dropdown bootstrap-select default-select form-control wide">
                              <select class="default-select form-control wide" name="dependability" id="dependability" required>
                                <option value="">Select</option>
                                <option >Unsatisfactory</option>
                                <option >Needs Improvement </option>
                                <option >Meets Expectations</option>
                                <option >Excellent</option>                              
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12"><br/><br/></div>

                      <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-label">Overall Rating <span class="red">*</span></label>
                            <div class="dropdown bootstrap-select default-select form-control wide">
                              <select class="default-select form-control wide" name="overallRating" required>
                                <option value="">Select</option>
                                <option>Unsatisfactory</option>
                                <option>Needs Improvement </option>
                                <option>Meets Expectations</option>
                                <option>Excellent</option>                              
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label">Manager Feedback For Employee<span class="red">*</span></label>
                            <div class="dropdown bootstrap-select default-select form-control wide">
                                <textarea class="form-control" style="min-height: 100px;" name="managerFeedbackForEmployee" required></textarea>
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
                </di>

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
              <h5>Performance Reviews List</h5>
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
                          <th>Date of Review</th>
                          <th>Review Period</th>
                          <th>Reviewer Name</th>
                          <th>Job Knowledge</th>
                          <th>Quality of Work</th>
                          <th>Productivity</th>
                          <th>Teamwork/Collaboration</th>
                          <th>Problem-Solving Skills</th>
                          <th>Adaptability</th>
                          <th>Dependability</th>
                          <th>Overall Rating</th>
                          <th>Manager Feedback For Employee</th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($List as  $key=>$val)
                        
                        <tr>
                          <td>{{$key + $List->firstItem()}}.</td>
                          <td><a href="{{ route($prefix.'.team.profileView', $val->employee->_id) }}">#{{!empty($val->employee->employee_code) ? $val->employee->employee_code : '---'}}</a> </td>
                          <td valign="top"><strong>{{$val->employee->name}}</strong></td>
                          <td valign="top">{{!empty($val->employee->department1) ? $val->employee->department1->name : '--'}}</td>
                          <td valign="top">{{ !empty($val->manager) ? $val->manager->name : '' }}</td>
                          <td valign="top">{{date('d M Y', strtotime($val->dateOfReview))}}</td>
                          <td valign="top">{{date('d M Y', strtotime($val->reviewPeriodFrom))}} {{date('d f Y', strtotime($val->reviewPeriodTo))}}</td>
                          <td valign="top">{{$val->reviewerName}}</td>
                          <td valign="top">{{$val->jobKnowledge}}</td>
                          <td valign="top">{{$val->qualityOfWork}}</td>
                          <td valign="top">{{$val->productivity}}</td>
                          <td valign="top">{{$val->teamworkCollaboration}}</td>
                          <td valign="top">{{$val->problemSolvingSkills}}</td>
                          <td valign="top">{{$val->adaptability}}</td>
                          <td valign="top">{{$val->dependability}}</td>
                          <td valign="top">{{$val->overallRating}}</td>
                          <td valign="top">{{$val->managerFeedbackForEmployee}}</td>
                         
                        </tr>
                        
                        @endforeach
                      </tbody>
                    </table>     
                    {!! $List->links() !!}                                                     
                  </div>
                  <!-- responsive table end --> 
                </div>
              </div>              
            </div>
          </div>
        </div>
        <!-- end --> 



        
        <div class="col-lg-12 d-none">
          <div class="card">
            <!-- <div class="card-header">
              <h4 class="card-title">View All Lead</h4>
            </div> -->

            
            <div class="card-body"> 
              <h5>Candidate List</h5><hr>
              
              <div class="row" style="margin-bottom: 10px;">
                <div class="col-sm-12 col-md-5">
                  <h5></h5>
                </div>
                <div class="col-sm-12 col-md-7">
                  <div class="row">
                    <div class="col-lg-4 offset-lg-5">
                    <!-- 
                      <select class="custom-select-sm form-select">
                        <option selected="">Move to PRO</option>
                        <option value="10">Mr. Neeraj</option>
                        <option value="25">Mr. Gaurav</option>
                        <option value="50">Mr. Sandeep</option>
                      </select>
                     -->                       
                    </div>
                    
                  </div>
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