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
              <h4 class="card-title">Attendance Filter</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <form class="needs-validation">
                  <div class="row">
                    <div class="col-md-12">
                      <input type="submit" class="btn {{ Request::get('filterBtn') == 'Last Month' ? 'btn-info' : 'btn-primary' }}" value="Last Month" name="filterBtn">
                      <input type="submit" class="btn {{ Request::get('filterBtn') == 'Current Month' || empty(Request::get('filterBtn')) ? 'btn-info' : 'btn-primary' }}" value="Current Month" name="filterBtn">
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
                    <h4 class="card-title">Attendance List</h4>

                  </div>
                
                </div>

                <!-- /tab-content -->
                <div class="tab-content" id="myTabContent-2" bis_skin_checked="1">
                  <div class="tab-pane fade show active" id="withoutSpace" role="tabpanel" aria-labelledby="home-tab-2" bis_skin_checked="1">
                    <div class="card-body pt-0" bis_skin_checked="1">
                      <div class="table-responsive" bis_skin_checked="1">
                      <table class="table table-bordered table-styling table-hover table-striped table-primary">
                     
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Coming Time</th>
                              <th>Going Time</th>
                              <th>Message</th>
                              <th>System IP</th>
                              
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($attendance as $key=>$val)
                                                  
                            <tr>
                            <td>{{ date('d M Y',strtotime($val->created_at)) }}</td>
                          
                              <td>{{ date('h:i A',strtotime($val->goodMoringDateTime)) }}</td>
                              <td>{{ !empty($val->goodNightDateTime) ? date('h:i A', strtotime($val->goodNightDateTime)) : '---'}}</td>
                              <td>{{ $val->goodNightMessage }}</td>
                              <td>{{ $val->userIpGoodMorning }}</td>
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
  
<!-- Modal End --> 
@endsection
@section('javascript')

@endsection