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
              <h4 class="card-title">New Hires</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <form id="formSubmit" action="{{ route($prefix.'.trainingDevelopment.saveNewHires') }}" method="post">
                  @csrf

                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Employee Name <span class="red">*</span></label>
                        <div class="dropdown bootstrap-select default-select form-control wide">
                          <select class="default-select form-control wide" name="teamId" id="teamId"  required>
                            <option value="">Select Name</option>
                            @foreach ($teamList as $key=>$val)
                            <option value="{{ $val->_id }}">{{ $val->name }}</option>
                            @endforeach
                          </select>
                          
                      </div>
                    </div>
                  </div>
                     <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Email ID</label>
                        <div class="dropdown bootstrap-select default-select form-control wide">
                          <input type="text" id="emailId"  class="form-control" disabled>
                      </div>
                    </div>
                    </div>
                     <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Designation</label>
                        <div class="dropdown bootstrap-select default-select form-control wide">
                         <input type="text" id="designation" class="form-control" disabled>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Department</label>
                        <div class="dropdown bootstrap-select default-select form-control wide">
                         <input type="text" id="department" class="form-control" disabled>
                      </div>
                    </div>
                  </div>
                    
                    <div class="col-md-12">
                      <label class="form-label d-block">&nbsp;</label>
                      <button type="submit" class="btn btn-primary" style="float:right">Submit</button>
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
           
            
            <div class="card-body"> 
              <h5>Candidate List</h5><hr>
              
              <div class="table-responsive">
                   <table class="table table-bordered table-styling table-hover table-striped table-primary">
                      <thead>
                        <tr>
                          <th width="50">SN.</th>
                          <th>Employee Code</th>
                          <th width="230">Details</th>
                          <th width="100">Employee Code</th>
                          <th width="200">Designation</th>
                          <th width="200">Department</th>
                          <th>Joining Date</th>
                          <th width="50">Action</th>
                          <th width="50">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($List as $key=>$val)
                        <tr>
                          <td>{{ $List->firstItem() }}.</td>
                          <td><a href="{{ route($prefix.'.team.profileView', $val->team->_id) }}">#{{ !empty($val->team->employee_code) ? $val->team->employee_code : '---' }}</a> </td>
                          <td valign="top"><strong>{{ $val->team->name }}</strong><br>
                            <i class="ri-mail-line"></i> {{ $val->team->email }}<br>
                            <i class="ri-smartphone-line"></i> {{ $val->team->mobile }}<br></td>
                          <td valign="top">{{ $val->team->employee_code }}</td>
                          <td valign="top">{{ $val->team->designation1->name }}</td>
                          <td valign="top">{{ $val->team->department1->name }}</td>
                          <td><strong>{{ !empty($val->team->joinDate) ? date('d M Y', strtotime($val->team->joinDate)) : '' }}</strong></td>
                          <td valign="top">
                            <a href="{{ route($prefix.'.team.profileView', $val->team->_id) }}"> <i class="ri-edit-line"></i></a> 
                            <a href="{{ route($prefix.'.trainingDevelopment.deleteNewHires',$val->_id) }}" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                          </td>
                          <td>
                            @if(!empty($val->team->status=='1'))
                               <a  style="color: green">Active</a>
                            @else 
                            <a  style="color: red">Deactive</a>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                      {!! $List->links() !!}
                    </table>
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
</script>
<script> 
 $(document).ready(function () {
      $('#teamId').change(function () {
        let selectedId = $(this).val();
          $.ajax({
            type : "post",
            url : "{{ route($prefix.'.fetchTeam') }}",
            data : {
              'teamId' :selectedId,
              '_token' : "{{ csrf_token() }}"
            },
            success: function(res) {
              if(res && Object.keys(res).length > 0){
                $('#department').val(res.departmentName);
                $('#designation').val(res.designationName);
                $('#emailId').val(res.email); 
              }else{
                $('#department, #designation, #emailId').val('');
              }
            }
          });
      });
  });
</script>
@endsection