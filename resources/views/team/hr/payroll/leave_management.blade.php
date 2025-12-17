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
              <h4 class="card-title">Leave Management</h4>
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="ri-add-line"></i> Add Leave</button>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <form class="needs-validation">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Employee Name</label>
                        <select class="default-select form-control wide" name="employeeId" id="employeeId" >
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
                        <label class="form-label">From</label>
                        <input type="date" name="fromDate" class="form-control" value="{{ Request::get('fromDate') }}">
                      </div>
                    </div>
                     <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">To</label>
                             <input type="date" name="toDate" class="form-control" value="{{ Request::get('toDate') }}">
                        </div>
                      </div>

                    
                    <div class="col-md-2">
                      <label class="form-label d-block">&nbsp;</label>
                      <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end -->
        
        <div class="col-lg-12" bis_skin_checked="1">
        <div class="card" bis_skin_checked="1">
          <!-- <div class="card-header">
              <h4 class="card-title">View All Lead</h4>
            </div> -->


          <div class="card-body" bis_skin_checked="1">


            <div class="col-xl-12" bis_skin_checked="1">
              <div class="card dz-card" id="accordion-three" bis_skin_checked="1">
                <div class="card-header flex-wrap d-flex justify-content-between" bis_skin_checked="1">
                  <div bis_skin_checked="1">
                    <h4 class="card-title">Leave List</h4>

                  </div>
                
                </div>

                <!-- /tab-content -->
                <div class="tab-content" id="myTabContent-2" bis_skin_checked="1">
                  <div class="tab-pane fade show active" id="withoutSpace" role="tabpanel" aria-labelledby="home-tab-2" bis_skin_checked="1">
                    <div class="card-body pt-0" bis_skin_checked="1">
                      <div class="table-responsive" bis_skin_checked="1">
                        <table class="display table" style="min-width: 845px">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Employee Code</th>
                              <th>From Date</th>
                              <th>To Date</th>
                              <th>Total Day</th>
                              <th>Remarks</th>
                              <th>Status</th>
                              <th>Apply Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($leaveList as $key=>$val)
                                                  
                            <tr>
                              <td>{{ !empty($val->employee) ? $val->employee->name : '' }}</td>
                              <td>#{{ !empty($val->employee) ? $val->employee->employee_code : '---' }}</td>
                              <td>{{ date('d M Y', strtotime($val->fromDate)) }}</td>
                              <td>{{ date('d M Y', strtotime($val->toDate)) }}</td>
                              <td>{{ $val->totalLeave }}</td>
                              <td>{{ $val->remarks }}</td>
                              <td>{{ $val->leaveStatus }}</td>
                              <td>{{ date('d M Y', strtotime($val->applyDate)) }}</td>
                              
                            </tr>

                            @endforeach   
                         </tbody>
                        </table>
                        
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
        <!-- end --> 
        
      </div>
    </div>
  </div>
  
  <!-- Modal -->
<div class="modal fade followpopup" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Leave</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formSubmit" action="{{ route($prefix.'.Payroll.add.leave') }}" method="post">
        @csrf
        <div class="modal-body">
            <div class="row">
            <div class="col-xl-6">
                <div class="mb-3">
                <label class="form-label">Employee</label>
                <select class="form-select" name="employeeId" id="employeeId" required>
                    <option value="">Select</option>
                        @foreach ($employee as $key=>$val)
                            <option value="{{ $val->_id }}">{{ $val->name }}</option>
                        @endforeach
                </select>
                </div>
            </div>
            

            <div class="col-xl-12"></div>
            <div class="col-xl-6">
                <div class="mb-3">
                <label class="form-label">From</label>
                <input type="date" name="fromDate" id="fromDate" class="form-control" required>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="mb-3">
                <label class="form-label">To</label>
                <input type="date" name="toDate" id="toDate" class="form-control" required>
                </div>
                <span style="color: red;" id="toDateError"></span>
            </div>
            
            <div class="col-xl-12"></div>
            <div class="col-xl-12">
                <div class="mb-3">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" name="remarks" required></textarea>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="mb-3">
                <label class="form-label">Leave Status</label>
                <select name="leaveStatus" id="leaveStatus" class="form-control" required>
                        <option>Approved</option>
                    </select>
                </div>
            </div>
            <div class="col-xl-6">
                    <div class="mb-3">
                    <label class="form-label">Total Leave</label>
                        <input type="text" name="totalLeave" id="totalLeave" value="" class="form-control" readonly>
                    </div>
                </div>
            <div class="col-xl-12"></div>
            <div class="col-xl-4">
                <div class="mt-4">
                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            </div>
        </div>
      </form>
      <!-- modal body end --> 
    </div>
  </div>
</div>
<!-- Modal End --> 
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
$(document).ready(function () {
    $('#fromDate, #toDate').change(function () {
        let fromDateVal = $('#fromDate').val();
        let toDateVal = $('#toDate').val();

        // Ensure both dates are selected
        if (!fromDateVal || !toDateVal) {
            return;
        }

        // Convert to Date objects (YYYY-MM-DD is correctly parsed)
        let fromDate = new Date(fromDateVal + 'T00:00:00'); 
        let toDate = new Date(toDateVal + 'T00:00:00'); 

        console.log("From Date:", fromDate.toString());
        console.log("To Date:", toDate.toString());

        if (toDate < fromDate) {
            $('#toDateError').html('<i class="fa fa-exclamation-circle"></i> To Date cannot be earlier than From Date').css('color', 'red');
            $('#totalLeave').val(''); // Clear total leave days if invalid
            $('#toDate').val('');
        } else {
            let timeDifference = toDate - fromDate;
            let totalDays = timeDifference / (1000 * 60 * 60 * 24) + 1; // Including the start date
            $('#totalLeave').val(totalDays);
            $('#toDateError').html(''); // Clear error when dates are valid
        }
    });

    $('#toDate').change(function () {
        $('#toDateError').html('');
    });
});


</script>
@endsection