@extends('admin.layouts.master')
@section('content')
<div class="content-body">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Candidate Info</h4>
            </div>
            <form id="formSubmit" action="{{route('team.recruitmentManagement.saveCandidateInfo')}}" method="post">
              @csrf
              <input type="hidden" name="id" value="{{ !empty($singleData) ? $singleData->_id : '' }}">
            <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Candidate Name  <span class="red">*</span></label>
                      <input type="text" class="form-control" name="candidateName" value="{{ !empty($singleData) ? $singleData->candidateName : '' }}" required>
                    </div>
                  </div>
                  <div class="col-lg-12"></div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Job Profile <span class="red">*</span></label>
                      <input type="text" class="form-control" name="jobProfile" value="{{ !empty($singleData) ? $singleData->jobProfile : '' }}" required>
                    </div>
                  </div>
                  <div class="col-lg-12"></div>
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Mobile <span class="red">*</span></label>
                      <input type="text" maxlength="10" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" class="form-control" name="mobile" value="{{ !empty($singleData) ? $singleData->mobile : '' }}" required>
                    </div>
                  </div>            
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Total Experience <span class="red">*</span></label>
                      <input type="text" class="form-control" name="totalExperience"  value="{{ !empty($singleData) ? $singleData->totalExperience : '' }}" required>
                    </div>
                  </div>
                  <div class="col-lg-12"></div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Address <span class="red">*</span></label>
                      <textarea class="form-control" name="address" required>{{ !empty($singleData) ? $singleData->address : '' }}</textarea>
                    </div>
                  </div>
                  <div class="col-lg-12"></div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Interview Date</label>
                      <input type="date" class="form-control" value="{{ !empty($singleData) ? $singleData->interviewDate : '' }}" name="interviewDate">                     
                    </div>
                  </div>
                  <div class="col-lg-12"></div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Offered Salary</label>
                      <input type="text" class="form-control" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" value="{{ !empty($singleData) ? $singleData->offeredSalary : '' }}" name="offeredSalary">                     
                    </div>
                  </div>
                  <div class="col-lg-12"></div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Other Description</label>
                      <textarea class="form-control" name="otherDescription" >{{ !empty($singleData) ? $singleData->otherDescription : '' }}</textarea>

                    </div>
                  </div>
                  <div class="col-lg-12"></div>
                  <div class="col-xl-6 text-end">
                    <div class="mt-4">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </div>
              

            </div>
            </form>
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
@endsection