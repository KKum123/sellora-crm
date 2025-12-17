@extends('admin.layouts.master')
@section('content')

<div class="content-body" style="min-height: 235px;">
    <div class="container-fluid">
         <div class="card">
            <div class="card-header">
              <h4 class="card-title">Create HR Sub Admin</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
              <form class="needs-validation">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Name</label>
                      <select class="form-select">
                           <option value="">Select</option>
                           <option value="">Mohan</option>
                           <option value="">Dipanshu</option>
                      </select>
                    </div>
                  </div>                  
                  <div class="col-lg-12"></div>
                  <div class="col-lg-4">
                         <div class="form-check form-switch">
                          <label class="form-check-label" for="flexSwitchCheckChecked2">
                            Employee Management</label>
                          <input class="form-check-input green-toggle" type="checkbox" id="flexSwitchCheckChecked2" checked="">
                        </div>
                        <div class="form-check form-switch">
                          <label class="form-check-label" for="flexSwitchCheckChecked3">
                           Performance Management</label>
                          <input class="form-check-input green-toggle" type="checkbox" id="flexSwitchCheckChecked3" checked="">
                        </div>
                        <div class="form-check form-switch">
                          <label class="form-check-label" for="flexSwitchCheckChecked4">
                           Payroll</label>
                          <input class="form-check-input green-toggle" type="checkbox" id="flexSwitchCheckChecked4" checked="">
                        </div>
                        <div class="form-check form-switch">
                          <label class="form-check-label" for="flexSwitchCheckChecked5">
                           Training &amp; Development</label>
                          <input class="form-check-input green-toggle" type="checkbox" id="flexSwitchCheckChecked5" checked="">
                        </div>
                        <div class="form-check form-switch">
                          <label class="form-check-label" for="flexSwitchCheckChecked6">
                           Recruitment Management</label>
                          <input class="form-check-input green-toggle" type="checkbox" id="flexSwitchCheckChecked6" checked="">
                        </div>
                      
                  </div>                  
                  <div class="col-lg-12"></div>
                  
                  <div class="col-lg-4 text-end">
                    <div class="mt-2">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </div>
                </form></div>
              
            </div>
          </div>
    </div>
  </div>

  @endsection
@section('javascript')
@endsection