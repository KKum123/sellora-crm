@extends('admin.layouts.master')
@section('content')
<div class="content-body" style="min-height: 235px;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div class="icon-box icon-box-lg bg-primary-light rounded-circle"> <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M32.8961 26.5849C34.1612 26.5849 35.223 27.629 35.0296 28.8783C33.8947 36.2283 27.6026 41.6855 20.0138 41.6855C11.6178 41.6855 4.8125 34.8803 4.8125 26.4862C4.8125 19.5704 10.0664 13.1283 15.9816 11.6717C17.2526 11.3579 18.5553 12.252 18.5553 13.5605C18.5553 22.4263 18.8533 24.7197 20.5368 25.9671C22.2204 27.2145 24.2 26.5849 32.8961 26.5849Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M41.1733 19.2019C41.2739 13.5059 34.2772 4.32428 25.7509 4.48217C25.0877 4.49402 24.5568 5.04665 24.5272 5.70783C24.3121 10.3914 24.6022 16.4605 24.764 19.2118C24.8134 20.0684 25.4864 20.7414 26.341 20.7907C29.1693 20.9526 35.4594 21.1736 40.0759 20.4749C40.7035 20.3802 41.1634 19.8355 41.1733 19.2019Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg> </div>
                <div class="total-projects ms-3">
                  <h3 class="text-primary count">50</h3>
                  <span>Employee Retention Rate</span> </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div class="icon-box icon-box-lg bg-success-light rounded-circle"> <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M22.9715 29.3168C15.7197 29.3168 9.52686 30.4132 9.52686 34.8043C9.52686 39.1953 15.6804 40.331 22.9715 40.331C30.2233 40.331 36.4144 39.2328 36.4144 34.8435C36.4144 30.4543 30.2626 29.3168 22.9715 29.3168Z" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M22.9714 23.0537C27.7304 23.0537 31.5875 19.1948 31.5875 14.4359C31.5875 9.67694 27.7304 5.81979 22.9714 5.81979C18.2125 5.81979 14.3536 9.67694 14.3536 14.4359C14.3375 19.1787 18.1696 23.0377 22.9107 23.0537H22.9714Z" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg> </div>
                <div class="total-projects ms-3">
                  <h3 class="text-success count">200</h3>
                  <span>Active Employee</span> </div>
                </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div class="icon-box icon-box-lg bg-danger-light rounded-circle"> <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M22.9717 41.0539C22.9717 41.0539 37.3567 36.6983 37.3567 24.6908C37.3567 12.6814 37.878 11.7439 36.723 10.5889C35.5699 9.43391 24.858 5.69891 22.9717 5.69891C21.0855 5.69891 10.3736 9.43391 9.21863 10.5889C8.0655 11.7439 8.58675 12.6814 8.58675 24.6908C8.58675 36.6983 22.9717 41.0539 22.9717 41.0539Z" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path d="M26.4945 26.4642L19.4482 19.4179" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path d="M19.4487 26.4642L26.495 19.4179" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg> </div>
                <div class="total-projects ms-3">
                  <h3 class="text-danger count">2</h3>
                  <span>Resignation Employee</span> </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div class="icon-box icon-box-lg bg-purple-light rounded-circle"> <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M34.0396 20.974C36.6552 20.6065 38.6689 18.364 38.6746 15.6471C38.6746 12.9696 36.7227 10.7496 34.1633 10.3296" stroke="#BB6BD9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path d="M37.4912 27.262C40.0243 27.6407 41.7925 28.5276 41.7925 30.3557C41.7925 31.6139 40.96 32.4314 39.6137 32.9451" stroke="#BB6BD9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7879 28.0373C16.7616 28.0373 11.6147 28.9504 11.6147 32.5973C11.6147 36.2423 16.7297 37.1817 22.7879 37.1817C28.8141 37.1817 33.9591 36.2779 33.9591 32.6292C33.9591 28.9804 28.846 28.0373 22.7879 28.0373Z" stroke="#BB6BD9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7876 22.8325C26.742 22.8325 29.9483 19.6281 29.9483 15.6719C29.9483 11.7175 26.742 8.51123 22.7876 8.51123C18.8333 8.51123 15.627 11.7175 15.627 15.6719C15.612 19.6131 18.7939 22.8194 22.7351 22.8325H22.7876Z" stroke="#BB6BD9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path d="M11.5344 20.974C8.91691 20.6065 6.90504 18.364 6.89941 15.6471C6.89941 12.9696 8.85129 10.7496 11.4107 10.3296" stroke="#BB6BD9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path d="M8.0825 27.262C5.54937 27.6407 3.78125 28.5276 3.78125 30.3557C3.78125 31.6139 4.61375 32.4314 5.96 32.9451" stroke="#BB6BD9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg> </div>
                <div class="total-projects ms-3">
                  <h3 class="text-purple count">200</h3>
                  <span>Total Employee</span> </div>
              </div>
            </div>
          </div>
        </div>  
    
    
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><i class="ri-cake-2-line" style="vertical-align: bottom;"></i> Upcoming Birthday</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-styling table-hover table-striped table-primary">
                      <thead>
                        <tr>
                          <th>Employee</th>
                          <th style="text-align: right;">Birthday Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><h2 class="table-avatar"> <a class="avatar avatar-xs" href="profile.html"> <img src="images/avatar-09.jpg" alt="User Image"></a> <a href="profile.html">Ravi Kushwaha</a> </h2></td>
                          <td align="right">
                            <!-- <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#attendance_info"><i class="fa-solid fa-check text-success"></i></a> -->
                            <strong>19<sup>th</sup> December 2024</strong>
                          </td>
                        </tr>
                        
                        <tr>
                          <td><h2 class="table-avatar"> <a class="avatar avatar-xs" href="profile.html"><img src="images/avatar-10.jpg" alt="User Image"></a> <a href="profile.html">John Smith</a> </h2></td>
                          <td align="right">
                            <!-- <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#attendance_info"><i class="fa-solid fa-check text-success"></i></a> -->
                            <strong>20<sup>th</sup> December 2024</strong>
                          </td>
                        </tr>
                        <tr>
                          <td><h2 class="table-avatar"> <a class="avatar avatar-xs" href="profile.html"><img src="images/avatar-05.jpg" alt="User Image"></a> <a href="profile.html">Mike Litorus</a> </h2></td>
                          <td align="right">
                            <!-- <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#attendance_info"><i class="fa-solid fa-check text-success"></i></a> -->
                            <strong>26<sup>th</sup> December 2024</strong>
                          </td>
                        </tr>
                        <tr>
                          <td><h2 class="table-avatar"> <a class="avatar avatar-xs" href="profile.html"><img src="images/avatar-11.jpg" alt="User Image"></a> <a href="profile.html">Wilmer Deluna</a> </h2></td>
                          <td align="right">
                            <!-- <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#attendance_info"><i class="fa-solid fa-check text-success"></i></a> -->
                            <strong>31<sup>th</sup> December 2024</strong>
                          </td>
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
      </div>
      
      <!--**********************************
                Content body end
            ***********************************--> 
      <!--**********************************
                Footer start
            ***********************************-->
      <div class="footer">
        <div class="copyright">
          <p>Copyright © 2024 Sellora | All Rights Reserved.</p>
        </div>
      </div>
      <!--**********************************
                Footer end
            ***********************************--> 
      
      <!--**********************************
               Support ticket button start
            ***********************************--> 
      
      <!--**********************************
               Support ticket button end
            ***********************************--> 
      
    </div>
    <!--**********************************
            Main wrapper end
        ***********************************--> 
    
    <!--**********************************
            Scripts
        ***********************************--> 
    <!-- Required vendors --> 
    <script src="vendor/global/global.min.js"></script> 
    <script src="vendor/chart-js/chart.bundle.min.js"></script> 
    <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script> 
    <script src="vendor/apexchart/apexchart.js"></script> 
    
    <!-- Dashboard 1 --> 
    <script src="js/dashboard/dashboard-1.js"></script> 
    <script src="vendor/draggable/draggable.js"></script> 
    <script src="vendor/swiper/js/swiper-bundle.min.js"></script> 
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script> 
    <script src="vendor/datatables/js/dataTables.buttons.min.js"></script> 
    <script src="vendor/datatables/js/buttons.html5.min.js"></script> 
    <script src="vendor/datatables/js/jszip.min.js"></script> 
    <script src="js/plugins-init/datatables.init.js"></script> 
    
    <!-- Apex Chart --> 
    
    <script src="vendor/bootstrap-datetimepicker/js/moment.js"></script> 
    <script src="vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script> 
    
    <!-- Vectormap --> 
    <script src="vendor/jqvmap/js/jquery.vmap.min.js"></script> 
    <script src="vendor/jqvmap/js/jquery.vmap.world.js"></script> 
    <script src="vendor/jqvmap/js/jquery.vmap.usa.js"></script> 
    <script src="js/custom.min.js"></script> 
    <script src="js/deznav-init.js"></script> 
    <script src="js/demo.js"></script>
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
      <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel2">Add Invoice</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-xl-12">
                <label class="form-label">Invoice Name</label>
                <input type="email" class="form-control" placeholder="">
                <label class="form-label mt-3">Upload Invoice </label>
                <input class="form-control" type="file">
              </div>
            </div>
          </div>
          <div class="modal-footer"> 
            <!--  <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal custom-modal fade" id="attendance_info" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Attendance Info</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="card punch-status">
                  <div class="card-body">
                    <h5 class="card-title">Timesheet <small class="text-muted">11 Mar 2019</small></h5>
                    <div class="punch-det">
                      <h6>Punch In at</h6>
                      <p>Wed, 11th Mar 2019 10.00 AM</p>
                    </div>
                    <div class="punch-info">
                      <div class="punch-hours"> <span>3.45 hrs</span> </div>
                    </div>
                    <div class="punch-det">
                      <h6>Punch Out at</h6>
                      <p>Wed, 20th Feb 2019 9.00 PM</p>
                    </div>
                    <div class="statistics">
                      <div class="row">
                        <div class="col-md-6 col-6 text-center">
                          <div class="stats-box">
                            <p>Break</p>
                            <h6>1.21 hrs</h6>
                          </div>
                        </div>
                        <div class="col-md-6 col-6 text-center">
                          <div class="stats-box">
                            <p>Overtime</p>
                            <h6>3 hrs</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card recent-activity">
                  <div class="card-body">
                    <h5 class="card-title">Activity</h5>
                    <ul class="res-activity-list">
                      <li>
                        <p class="mb-0">Punch In at</p>
                        <p class="res-activity-time"> <i class="fa-regular fa-clock"></i> 10.00 AM. </p>
                      </li>
                      <li>
                        <p class="mb-0">Punch Out at</p>
                        <p class="res-activity-time"> <i class="fa-regular fa-clock"></i> 11.00 AM. </p>
                      </li>
                      <li>
                        <p class="mb-0">Punch In at</p>
                        <p class="res-activity-time"> <i class="fa-regular fa-clock"></i> 11.15 AM. </p>
                      </li>
                      <li>
                        <p class="mb-0">Punch Out at</p>
                        <p class="res-activity-time"> <i class="fa-regular fa-clock"></i> 1.30 PM. </p>
                      </li>
                      <li>
                        <p class="mb-0">Punch In at</p>
                        <p class="res-activity-time"> <i class="fa-regular fa-clock"></i> 2.00 PM. </p>
                      </li>
                      <li>
                        <p class="mb-0">Punch Out at</p>
                        <p class="res-activity-time"> <i class="fa-regular fa-clock"></i> 7.30 PM. </p>
                      </li>
                    </ul>
                  </div>
                </div>
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