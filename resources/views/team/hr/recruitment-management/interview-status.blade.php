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
              <h4 class="card-title">Interview Status</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <form>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Candidate Name</label>
                        <div class="dropdown bootstrap-select default-select form-control wide">
                          <input type="text" name="candidateName" class="form-control" value="{{Request::get('candidateName')}}">
                      </div>
                    </div>
                  </div>
                     <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Job Profile</label>
                        <input type="text" name="jobProfile" class="form-control" value="{{Request::get('jobProfile')}}">
                      </div>
                    </div>
                     <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Interview Status</label>
                        <div class="dropdown bootstrap-select default-select form-control wide">
                          <select class="default-select form-control wide" name="interviewStatus">
                          <option value="">Select</option>
                          <option>Selected</option>
                          <option>Rejected</option>
                          <option>Onhold</option>
                        </select>
                      </div>
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
        
        <div class="col-lg-12">
          <div class="card">

            
            <div class="card-body"> 
              <h5>Candidate List</h5><hr>
              
              <div class="row" style="margin-bottom: 10px;">
                <div class="col-sm-12 col-md-5">
                  <h5></h5>
                </div>
                <div class="col-sm-12 col-md-7">
                  <div class="row">
                    <div class="col-lg-4 offset-lg-5">
                                       
                    </div>
                    
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-styling table-hover table-striped table-primary">
                        <thead>
                          <tr>
                            <th width="10">S.No</th>
                            <th style="width: 100px;">Interview Status</th>
                            <th>Interview Date</th>
                            <th>Candidate</th>
                            <th>Phone</th>
                            <th>Job Profile</th>
                            <th>Total Experience</th>
                            <th>Offered Salary</th>
                            <th>Address</th>
                            <th>Edit</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($List as $key=>$val)
                          
                          <tr>
                            <td scope="row">{{$key + $List->firstItem()}}</td>

                            <td class="actiontd">
                                  <form id="formSubmit_{{ $val->_id }}" onchange="formOnchange('{{ $val->_id }}')"  action="{{ route($prefix.'.recruitmentManagement.changeInterviewStatus') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $val->id }}">
                                  <select name="interviewStatus" class="form-control" required  
                                    @if(!empty($val->interviewStatus) && $val->interviewStatus=='Selected' || $val->interviewStatus=='Rejected')
                                    disabled
                                    @endif
                                  >
                                       <option value="">----</option>
                                        <option value="Selected" {{ !empty($val->interviewStatus) && $val->interviewStatus == 'Selected' ? 'selected' : '' }}>Selected</option>
                                       <option value="Rejected" {{ !empty($val->interviewStatus) && $val->interviewStatus == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                       <option value="On Hold" {{ !empty($val->interviewStatus) && $val->interviewStatus == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                  </select>
                                  </form>
                            </td>

                            <td valign="top">{{date('d f Y', strtotime($val->interviewDate))}}</td>
                            <td valign="top">{{$val->candidateName}}</td>
                            <!-- <i class="ri-mail-line"></i> ankur@gmail.com<br> -->
                            <td valign="top"> {{$val->mobile}}<br></td>
                            <td>{{$val->jobProfile}} </td>
                            <td>{{$val->totalExperience}} </td>
                            <td>₹ {{$val->offeredSalary}}</td>
                            <td>{{$val->otherDescription}} </td>
                            <td>
                              @if(empty($val->interviewStatus) || !empty($val->interviewStatus) && $val->interviewStatus=='On Hold')
                               <a href="{{ route($prefix.'.recruitmentManagement.getInterviewStatus',$val->_id) }}"> <i class="ri-edit-line"></i></a>
                              @endif
                            </td>
                          </tr>
                          
                          @endforeach
                          
                        </tbody>
                      </table>
                      {!! $List->links()!!}
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
  function formOnchange(id){;
    let form = $('#formSubmit_' + id);
    form.parsley().validate(); 
    if (form.parsley().isValid()) {
          $('#spiner').css('display', 'flex'); // Show spinner on valid form
          form.submit(); // Submit form automatically when valid
      }
  }
</script>

@endsection