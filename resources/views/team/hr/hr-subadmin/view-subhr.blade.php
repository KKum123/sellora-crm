@extends('admin.layouts.master')
@section('content')
<div class="content-body" style="min-height: 235px;">
    <div class="container-fluid">
         <div class="card">
            <div class="card-header">
              <h4 class="card-title">View HR Sub Admin</h4>
            </div>
            <div class="card-body"> 
              <!-- <h5>Project Listing</h5>
                                       <hr> -->
              
              <div class="row" style="margin-bottom: 10px;"> 
                <!-- <div class="col-sm-12 col-md-8">
                  <h5>Datatable</h5>
                </div> --> 
                <!-- <div class="col-sm-12 col-md-3 col-9">
                  <div>
                    <select class="custom-select custom-select-sm form-control  form-select">
                      <option selected="">Move to CEO</option>
                      <option value="10">Mr. Pankaj</option>
                      <option value="25">Mr. Gaurav</option>
                      <option value="50">Mr. Sandeep</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12 col-md-1 col-3">
                  <button type="submit" class="btn btn-primary" style="float:right;">Assign</button>
                </div> --> 
              </div>
              <div class="row">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-styling table-hover table-striped table-primary">
                      <thead>
                        <tr>
                          <th width="50">SN.</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Mobile</th>
                          <th>Employee Code</th>
                          <th>Role</th>
                          <th width="50">Action</th>
                          <th width="50">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1.</td>
                          <td>Ankur</td>
                          <td>ankur@gmail.com</td>
                          <td>98798985954</td>
                          <td>an2014</td>
                          <td>Employee Management,<br> 
                            Performance Management,<br> 
                          Payroll,<br> Training &amp; Development,<br>  Recruitment Management </td>
                          <td><a href="#"> <i class="ri-edit-line"></i> </a> <a href="#"> <i class="ri-close-line"></i> </a></td>
                          <td><a href="#" style="color: green">Active</a></td>
                        </tr>
                        <tr>
                          <td>2.</td>
                          <td>Ankur</td>
                          <td>ankur@gmail.com</td>
                          <td>98798985954</td>
                          <td>an2014</td>
                          <td>Employee Management,<br> 
                            Performance Management,<br> 
                          Payroll,<br> Training &amp; Development,<br>  Recruitment Management </td>
                          <td><a href="#"> <i class="ri-edit-line"></i> </a> <a href="#"> <i class="ri-close-line"></i> </a></td>
                          <td><a href="#" style="color: green">Active</a></td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="pagination pagination-sm float-right paging"> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
  </div>
@endsection
@section('javascript')
@endsection