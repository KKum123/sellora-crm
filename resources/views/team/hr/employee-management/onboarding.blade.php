@extends('admin.layouts.master')
@section('content')

<div class="content-body" style="min-height: 235px;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Onboarding Employee</h4>
            </div>
            <div class="card-body">
              <!--
                <div class="row">
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">First Name</label>
                      <input type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Last Name</label>
                      <input type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-12"></div>
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Phone</label>
                      <input type="text" class="form-control">
                    </div>
                  </div>                  
                  <div class="col-lg-3">
                    <div class="mb-0">
                      <label class="form-label">Email ID</label>
                      <input type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-12"></div>


                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Date of Birth</label>
                      <input type="date" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Gender</label>
                      <div class="row">
                           <div class="col-6 col-sm-3 pt-lg-2">
                                 <label for="male"><input name="gender" type="radio" id="male"> Male</label>
                           </div>
                           <div class="col-6 col-sm-3 pt-lg-2">
                                 <label for="female"><input name="gender" type="radio" id="female"> Female</label>
                           </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12"></div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Designation</label>
                      <input type="text" class="form-control" placeholder="e.g. Sales Manager, Operation Manager">
                    </div>
                  </div>

                  <div class="col-lg-12"></div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Department</label>
                      <select class="form-select" name="department" required="">
                            <option value="">Select</option>
                            <option value="Sales Manager">Sales Manager</option>
                            <option value="Sales Team">Sales Team</option>
                            <option value="Operation Manager">Operation Manager</option>
                            <option value="Operation Team">Operation Team</option>
                            <option value="IT Technical">IT Technical</option>
                            <option value="HR">HR</option>
                            <option value="Finance">Finance</option>
                            <option value="Legal">Legal</option>
                            <option value="Accounts">Accounts</option>
                            <option value="Designing">Designing</option>
                            <option value="Logistics">Logistics</option>
                      </select>                 
                    </div>
                  </div>

                  <div class="col-lg-12"></div>
                  <div class="col-xl-4">
                    <div class="mt-4 pt-lg-3">
                      <input type="checkbox" id="status" name="status" value="Bike">
                      <label for="status"> Active/Deactive</label>
                    </div>
                  </div>
                  <div class="col-xl-12 text-end">
                    <div class="mt-4">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </div> -->

                <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Name <span class="red">*</span></label>
                                        <input type="text" class="form-control" placeholder="" name="name" required="" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Email ID <span class="red">*</span></label>
                                        <input type="email" id="Email" class="form-control" placeholder="" name="email" required="" value="email" onblur="checkEmail()">
                                    </div>
                                    <span id="email_error" style="color: red"></span>
                                </div>
                                <div class="col-md-12"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Mobile <span class="red">*</span></label>
                                        <input type="text" class="form-control" name="mobile" value="" required="" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" maxlength="10">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Employee Code </label>
                                        <input type="text" class="form-control" required="" name="employee_code" value="">
                                    </div>
                                </div>

                                <div class="col-md-12"></div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <label class="form-label">Department <span class="red">*</span></label>
                                    <select class="form-select">
                                         <option value="">Select</option>
                                         <option value="">Sales</option>
                                         <option value="">Operation</option>
                                         <option value="">IT Tech Support</option>
                                         <option value="">Human Resource</option>
                                         <option value="">Fianance &amp; Accounts</option>
                                         <option value="">Designing</option>
                                         <option value="">Logistics</option>
                                         <option value="">Administration</option>
                                    </select>
                                  </div>
                                </div>
                                
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <label class="form-label">Designation <span class="red">*</span></label>
                                    <select class="form-select">
                                         <option value="">Select</option>
                                         <option value="">Sales Manager</option>
                                         <option value="">Sales Executive</option>
                                         <option value="">Business Development Manager</option>
                                         <option value="">Business Development Executive</option>
                                         <option value="">Relationship Manager</option>
                                         <option value="">Relationship Executive</option>
                                         <option value="">Affiliate Manager</option>
                                         <option value="">Client Partner</option>
                                    </select>                     
                                  </div>
                                </div>
                                

                                <div class="col-md-12"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Password <span class="red">*</span></label>
                                        <input type="text" class="form-control" placeholder="" name="password" required="" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="mt-4 pt-4">
                                            <input type="checkbox" name="status" value="1" id="act" data-parsley-multiple="status">
                                            <label class="form-label" for="act">Active/Deactive</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12"></div>
                                <div class="col-md-6">
                                    <div class="form-group text-end">
                                        <button id="submitButton" type="submit" class="btn btn-primary d-inline-block" style="width: auto; ">Submit</button>
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
@endsection