@extends('admin.layouts.master')
@section('content')
@if(session()->has('admin'))
@php $prefix = 'admin'; @endphp
@elseif(session()->has('branch'))
@php $prefix = 'branch'; @endphp
@elseif(session()->has('team')) 
@php $prefix = 'team'; @endphp
@endif
<div class="content-body">
    <div class="container-fluid">
         <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Client Report</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <form class="needs-validation">
                  <div class="row">
                    @if(session()->has('admin'))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Filter By Branch</label>
                            <select name="branch_id" id="" class="form-control">
                                <option value="">Select</option>
                                @foreach ($branch as $key=>$val)
                                    <option value="{{$val->_id}}" {{ Request::get('branch_id') == $val->_id ? 'selected' : ''}}>{{$val->branch_name}} ({{$val->branch_code}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
               </form> </div> </div> </div> </div>
        <!-- end -->
        
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">List</h4>
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
                          @if(session()->has('admin'))  
                          <th>Country</th>
                          
                          <th>Branch</th> 
                          @endif
                          <th>Requester Details</th>                  
                          <th>OpsPulse Person</th>
                          <th>SalesPulse Person</th>
                          <th>Date</th>
                          <th>Follow Up</th>
                          <th>Task</th>
                          <th>Assigned To</th>
                          <th>Request ID</th>
                          <th>Provider ID</th>
                          <th>City</th>
                          <th>Service Category</th>
                          <th>Requester Location</th>
                          <!-- <th>Assign to Sales Person</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          @if(session()->has('admin'))
                          <td>India</td>
                          <td>Delhi Branch</td>
                          @endif
                          <td valign="top"><strong>Manoj</strong><br>
                            <i class="ri-mail-line"></i> ankur@gmail.com<br>
                            <i class="ri-smartphone-line"></i> +919898989898<br>  
                            <a href="#" data-bs-toggle="modal" data-bs-target="#statusModal"><span class="orangestatus">Pending</span></a>
                          </td>
                          <td valign="top"><strong>Ankur</strong>                           
                          </td>
                          <td valign="top"><strong>Gulmohar</strong>
                          </td>
                          <td><i class="ri-calendar-line"></i> 24-10-24</td>                          
                          <td>                            
                            <a href="#" style="color: blue" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="ri-eye-line"></i> View</a>
                          </td>
                          <td>
                            <!-- <a href="#" style="color: blue; margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#exampleModal00"><i class="ri-add-line"></i> Add Task</a> -->
                            <a href="#" style="color: blue" data-bs-toggle="modal" data-bs-target="#exampleModal200"><i class="ri-eye-line"></i> View</a>
                          </td>
                          <td valign="top">
                             <strong>Harpreet</strong>
                          </td>
                          <td valign="top"></td>
                          <td valign="top"></td>                          
                          <td valign="top"></td>
                          <td valign="top"></td>
                          <td valign="top"></td>
                                                   
                        </tr>
                       
                          
                      </tbody>
                    </table>



                    <!-- <table class="table table-bordered table-styling table-hover table-striped table-primary">
                      <thead>
                        <tr>
                          <th>Sales Person</th>
                          <th>Date</th>
                          <th width="50">Status</th>
                          <th>Follow up</th>
                          <th>Request ID</th>
                          <th>Requester Details</th>
                          <th>City</th>
                          <th>Service Category</th>
                          <th>Requester Location</th>
                          <th width="60">Forward To Operation</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td valign="top"><strong>Manoj</strong><br>
                            <i class="ri-mail-line"></i> mnoj@gmail.com<br>
                            <i class="ri-smartphone-line"></i> +919898989898<br>
                          </td>
                          <td><i class="ri-calendar-line"></i> 24-10-24</td>
                          <td><a href="#" class="greenstatus">Pitch In Progress</a></td>
                          <td>
                            <a href="#" style="color: blue" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="ri-eye-line"></i> View</a>
                          </td>
                          <td valign="top"></td>
                          <td valign="top"><strong>Ankur</strong><br>
                            <i class="ri-mail-line"></i> ankur@gmail.com<br>
                            <i class="ri-smartphone-line"></i> +919898989898<br>
                          </td>
                          <td valign="top"></td>
                          <td valign="top"></td>
                          <td valign="top"></td>
                          
                          <td valign="top">
                                <select style="background: #fff!important;">
                                     <option value="">Select</option>
                                     <option value="">Harpreet</option>
                                     <option value="">Irshad</option>
                                </select>
                          </td>
                        </tr>
                        <tr>
                          <td valign="top"><strong>Manoj</strong><br>
                            <i class="ri-mail-line"></i> mnoj@gmail.com<br>
                            <i class="ri-smartphone-line"></i> +919898989898<br>
                          </td>
                          <td><i class="ri-calendar-line"></i> 24-10-24</td>
                          <td><a href="#" class="redstatus">Not Interested</a></td>
                          <td>
                            <a href="#" style="color: blue; margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="ri-add-line"></i> Add</a>
                            <a href="#" style="color: blue" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="ri-eye-line"></i> View</a>
                          </td>
                          <td valign="top"></td>
                          
                          
                          <td valign="top"><strong>Ankur</strong><br>
                            <i class="ri-mail-line"></i> ankur@gmail.com<br>
                            <i class="ri-smartphone-line"></i> +919898989898<br></td>
                          <td valign="top"></td>
                          <td valign="top"></td>
                          <td valign="top"></td>
                          
                          <td valign="top">
                                <select style="background: #fff!important;">
                                     <option value="">Select</option>
                                     <option value="">Harpreet</option>
                                     <option value="">Irshad</option>
                                </select>
                          </td>

                        </tr>
                          
                      </tbody>
                    </table> -->

                    <div class="pagination pagination-sm float-right paging"> </div>
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
  
  <!-- Modal -->
<div class="modal fade followpopup" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Lead Name: Bud Kovacek MD</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table style="width: 100%;" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>S.N.</th>
                <th>Activity Date</th>
                <th>Next Follow Up Date</th>
                <th>Remarks</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="appendBodyData">
              <tr>
                <td>1</td>
                <td>2024-09-16</td>
                <td>2024-09-16</td>
                <td>testing</td>
                <td><span class="orangestatus">Pending</span></td>
              </tr>
              <tr>
                <td>2</td>
                <td>2024-09-16</td>
                <td>2024-09-16</td>
                <td>testing</td>
                <td><span class="bluestatus">Pitch In Progress</span></td>
              </tr>
              <tr>
                <td>3</td>
                <td>2024-09-16</td>
                <td>2024-09-16</td>
                <td>testing</td>
                <td><span class="yellowstatus">Not Reachable</span></td>
              </tr>
              <tr>
                <td>4</td>
                <td>2024-09-16</td>
                <td>2024-09-16</td>
                <td>testing</td>
                <td><span class="redstatus">Not Interested</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- modal body end --> 
    </div>
  </div>
</div>
<!-- Modal End -->


<div class="modal fade followpopup" id="exampleModal200" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Request ID: #fd5478e9</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table style="width: 100%;" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th width="20">S.N.</th>
                <th width="100">Assigned By</th>
                <th>Task Heading</th>
                <th>Task Details</th>
                <th width="100">Completion Date</th>
                <th width="100">Completion Time</th>
                <th width="120">Action</th>
              </tr>
            </thead>
            <tbody id="appendBodyData">
              <tr>
                <td>1</td>
                <td><strong>My Self</strong></td>
                <td>Add Bank Details</td>
                <td>lorem lipsum dummy text here</td>
                <td>16-09-2024</td>
                <td>1 Hour 2 min</td>          
                <td>
                     <span class="bluestatus">In Progress</span><br>

                     

                     <a href="#" style="color: blue; margin: 10px 0px 0px 10px;" data-bs-toggle="modal" data-bs-target="#exampleModal2001"><i class="ri-eye-line"></i> View</a>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td><strong>My Self</strong></td>
                <td>Add Bank Details</td>
                <td>lorem lipsum dummy text here</td>
                <td>16-09-2024</td> 
                <td>1 Hour 2 min</td>          
                <td><span class="orangestatus">Pending</span><br>


                     <a href="#" style="color: blue; margin: 0px 0px 0px 10px;" data-bs-toggle="modal" data-bs-target="#exampleModal2001"><i class="ri-eye-line"></i> View</a>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td><strong>My Self</strong></td>
                <td>Add Bank Details</td>
                <td>lorem lipsum dummy text here</td>
                <td>16-09-2024</td> 
                <td>1 Hour 2 min</td>          
                <td><span class="greenstatus">Completed</span><br>

                     <a href="#" style="color: blue; margin: 0px 0px 0px 10px;" data-bs-toggle="modal" data-bs-target="#exampleModal2001"><i class="ri-eye-line"></i> View</a>
                </td>
              </tr>
              <tr>
                <td>4</td>
                <td><strong>My Self</strong></td>
                <td>Add Bank Details</td>
                <td>lorem lipsum dummy text here</td>
                <td>16-09-2024</td>
                <td>1 Hour 2 min</td>          
                <td><span class="bluestatus">In Progress</span><br>

                     <a href="#" style="color: blue; margin: 0px 0px 0px 10px;" data-bs-toggle="modal" data-bs-target="#exampleModal2001"><i class="ri-eye-line"></i> View</a>

                  

                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- modal body end --> 
    </div>
  </div>
</div>
<!-- Modal End -->


<div class="followpopup modal fade" id="exampleModal2001" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalToggleLabel">Task Heading: Add Bank Details</h5>
        <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal200" aria-label="Close"></button> -->
        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal200" class="btn-close" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table style="width: 100%;" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>S.N.</th>
                <th>Spent Time</th>
                <th>Remarks</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="appendBodyData">
              <tr>
                <td>1</td>
                <td>1 Hour 2 min</td>
                <td>Assign work updated</td>
                <td><span class="greenstatus">Completed</span></td>
              </tr>
              <tr>
                <td>2</td>
                <td>1 Hour 2 min</td>
                <td>Assign work updated</td>
                <td><span class="bluestatus">In Progress</span></td>
              </tr>
              <tr>
                <td>3</td>
                <td>1 Hour 2 min</td>
                <td>Assign work updated</td>
                <td><span class="greenstatus">Completed</span></td>
              </tr>
              <tr>
                <td>4</td>
                <td>1 Hour 2 min</td>
                <td>Assign work updated</td>
                <td><span class="bluestatus">In Progress</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
    </div>
  </div>
</div>

@endsection
@section('javascript')
@endsection