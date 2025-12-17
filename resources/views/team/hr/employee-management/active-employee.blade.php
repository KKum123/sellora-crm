
@extends('admin.layouts.master')
@section('content')

<div class="content-body" style="min-height: 235px;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Active Employee</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <form class="needs-validation">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Employee Name</label>
                        <div class="form-control"><div class="form-control"><select class="default-select form-control wide">
                            <option value="">Select Name</option>
                            <option value="">Arjun</option>
                            <option value="">Komal</option>
                        </select><button type="button" tabindex="-1" class="btn dropdown-toggle bs-placeholder btn-light" data-bs-toggle="dropdown" role="combobox" aria-owns="bs-select-1" aria-haspopup="listbox" aria-expanded="false" title="Select Name"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">Select Name</div></div> </div></button><div class="dropdown-menu "><div class="inner show" role="listbox" id="bs-select-1" tabindex="-1"><ul class="dropdown-menu inner show" role="presentation"></ul></div></div></div>
                      </div>
                    </div>
                  </div>
                     <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Email ID</label>
                        <div class="form-control"><div class="form-control"><select class="default-select form-control wide">
                            <option>Select</option>
                            <option>arjun@gmail.com</option>
                            <option>komal@gmail.com</option>
                        </select><button type="button" tabindex="-1" class="btn dropdown-toggle btn-light" data-bs-toggle="dropdown" role="combobox" aria-owns="bs-select-2" aria-haspopup="listbox" aria-expanded="false" title="Select"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">Select</div></div> </div></button><div class="dropdown-menu "><div class="inner show" role="listbox" id="bs-select-2" tabindex="-1"><ul class="dropdown-menu inner show" role="presentation"></ul></div></div></div>
                      </div>
                    </div>
                    </div>
                     <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label">Phone</label>
                        <div class="form-control"><div class="form-control"><select class="default-select form-control wide">
                          <option>Select</option>
                          <option>9875989898</option>
                          <option>9872157890</option>
                        </select><button type="button" tabindex="-1" class="btn dropdown-toggle btn-light" data-bs-toggle="dropdown" role="combobox" aria-owns="bs-select-3" aria-haspopup="listbox" aria-expanded="false" title="Select"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">Select</div></div> </div></button><div class="dropdown-menu "><div class="inner show" role="listbox" id="bs-select-3" tabindex="-1"><ul class="dropdown-menu inner show" role="presentation"></ul></div></div></div>
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
              <h5>Employee List</h5><hr>
              
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
              <div class="row">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <!--
                    <table class="table table-bordered table-styling table-hover table-striped table-primary">
                      <thead>
                        <tr>
                          <th width="10">S.No</th>
                          <th>Employee ID</th>
                          <th>Employee Details</th>
                          <th></th>
                          <th></th>
                          <th>Joining Date</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td scope="row">1</td>
                          <td><a href="profile.html">#123544</a></td>
                          <td valign="top">
                            Ankur<br>
                            <i class="ri-mail-line"></i> ankur@gmail.com<br>
                            <i class="ri-smartphone-line"></i> +919898989898<br>
                          </td>
                          <td> 9873989889 </td>
                          <td>info@gmail.come </td>
                          <td valign="top"><a href="#"> <i class="ri-edit-line"></i> </a> <a href="#"> <i class="ri-close-line"></i> </a></td>
                          <td><a href="#" style="color: green">Active</a></td>
                        </tr>                          
                      </tbody>
                    </table> -->

                    <table class="table table-bordered table-styling table-hover table-striped table-primary">
                      <thead>
                        <tr>
                          <th width="50">SN.</th>
                          <th>Employee ID</th>
                          <th width="230">Details</th>
                          <th width="100">Employee Code</th>
                          <th width="200">Designation</th>
                          <th width="200">Department</th>
                          <th>Password</th>
                          <th>Joining Date</th>
                          <th width="50">Action</th>
                          <th width="50">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1.</td>
                          <td><a href="profile.html">#789546</a> </td>
                          <td valign="top"><strong>Sandeep Shah</strong><br>
                            <i class="ri-mail-line"></i> sandeep@ecomsolutions.in<br>
                            <i class="ri-smartphone-line"></i> 9211886687<br></td>
                          <td valign="top">1002</td>
                          <td valign="top">Operations Manager</td>
                          <td valign="top">Operation Manager</td>
                          <td valign="top">Sandeep@123</td>
                          <td><strong>24 Jan 24</strong></td>
                          <td valign="top">
                            <a href="onboarding-employee.html"> <i class="ri-edit-line"></i></a> 
                            <a href="https://selloracrm.akslearning.in/admin/team/delete-team/12" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                          </td>
                          <td><a style="color: green">Active</a></td>
                        </tr>
                        <tr>
                          <td>2.</td>
                          <td><a href="profile.html">#789546</a> </td>
                          <td valign="top"><strong>Brandy</strong><br>
                            <i class="ri-mail-line"></i> support@digitom.us<br>
                            <i class="ri-smartphone-line"></i> 8700894154<br></td>
                          <td valign="top">1005</td>
                          <td valign="top">Client Partner</td>
                          <td valign="top">Operation Manager</td>
                          <td valign="top">Brandy@123</td>
                          <td><strong>24 Jan 24</strong></td>
                          <td valign="top">
                            <a href="onboarding-employee.html"> <i class="ri-edit-line"></i></a> 
                            <a href="https://selloracrm.akslearning.in/admin/team/delete-team/12" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                          </td>
                          <td><a style="color: green">Active</a></td>
                        </tr>
                        <tr>
                          <td>3.</td>
                          <td><a href="profile.html">#789546</a> </td>
                          <td valign="top"><strong>Kasim</strong><br>
                            <i class="ri-mail-line"></i> support@ecomsolutions.in<br>
                            <i class="ri-smartphone-line"></i> 9211886687<br></td>
                          <td valign="top">1001</td>
                          <td valign="top">Manager Sales</td>
                          <td valign="top">Sales Manager</td>
                          <td valign="top">Kasim@123</td>
                          <td><strong>24 Jan 24</strong></td>
                          <td valign="top">
                            <a href="onboarding-employee.html"> <i class="ri-edit-line"></i></a> 
                            <a href="https://selloracrm.akslearning.in/admin/team/delete-team/12" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                          </td>
                          <td><a style="color: green">Active</a></td>
                        </tr>
                        <tr>
                          <td>4.</td>
                          <td><a href="profile.html">#789546</a> </td>
                          <td valign="top"><strong>Nisha Kumari</strong><br>
                            <i class="ri-mail-line"></i> Niashakumar87@gmail.com<br>
                            <i class="ri-smartphone-line"></i> 8920371579<br></td>
                          <td valign="top">1003</td>
                          <td valign="top">UI Designer</td>
                          <td valign="top">Designing</td>
                          <td valign="top">Nisha@123</td>
                          <td><strong>24 Jan 24</strong></td>
                          <td valign="top">
                            <a href="onboarding-employee.html"> <i class="ri-edit-line"></i></a> 
                            <a href="https://selloracrm.akslearning.in/admin/team/delete-team/12" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                          </td>
                          <td><a style="color: green">Active</a></td>
                        </tr>
                        <tr>
                          <td>5.</td>
                          <td><a href="profile.html">#789546</a> </td>
                          <td valign="top"><strong>OPS</strong><br>
                            <i class="ri-mail-line"></i> ops@gmail.com<br>
                            <i class="ri-smartphone-line"></i> 9090909090<br></td>
                          <td valign="top">ONJFHJ87687</td>
                          <td valign="top">NA</td>
                          <td valign="top">Operation Team</td>
                          <td valign="top">123456</td>
                          <td><strong>24 Jan 24</strong></td>
                          <td valign="top">
                            <a href=""> <i class="ri-edit-line"></i></a> 
                            <a href="https://selloracrm.akslearning.in/admin/team/delete-team/12" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                          </td>
                          <td><a style="color: green">Active</a></td>
                        </tr>
                        <tr>
                          <td>6.</td>
                          <td><a href="profile.html">#789546</a> </td>
                          <td valign="top"><strong>Sales</strong><br>
                            <i class="ri-mail-line"></i> salesteam@gmail.com<br>
                            <i class="ri-smartphone-line"></i> 9090909090<br></td>
                          <td valign="top">JGJ875875</td>
                          <td valign="top">NA</td>
                          <td valign="top">Sales Team</td>
                          <td valign="top">123456</td>
                          <td><strong>24 Jan 24</strong></td>
                          <td valign="top">
                            <a href="onboarding-employee.html"> <i class="ri-edit-line"></i></a> 
                            <a href="https://selloracrm.akslearning.in/admin/team/delete-team/12" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                          </td>
                          <td><a style="color: green">Active</a></td>
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
  </div>

  @endsection
@section('javascript')
@endsection