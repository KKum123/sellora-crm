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
            <h4 class="card-title">Employee Salary</h4>
          </div>
          <div class="card-body">
            <div class="form-validation">
              <form >
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="form-label">Employee Name</label>
                      <input type="text" class="form-control" name="name" value="{{ Request::get('name') }}">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="form-label">Select Roll</label>
                      <select class="default-select form-control wide" name="department">
                        <option value="">ALL</option>
                          @foreach ($department as $key=>$val)
                            <option value="{{ $val->_id }}" {{ Request::get('department')==$val->_id ? 'selected' : '' }}>{{ $val->name }}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <!-- <div class="col-md-2">
                    <div class="form-group">
                      <label class="form-label">leave Status</label>
                      <select class="default-select form-control wide">
                        <option>Select</option>
                        <option>Pending</option>
                        <option>Approved</option>
                        <option>Rejected</option>
                      </select>
                    </div>
                  </div> -->


                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="form-label">From</label>
                      <input type="date" name="from_date" value="{{ Request::get('from_date') }}" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="form-label">To</label>
                      <input type="date" name="to_date" value="{{ Request::get('to_date') }}" class="form-control">
                    </div>
                  </div>



                  <div class="col-md-2">
                    <label class="form-label d-block">&nbsp;</label>
                    <button type="submit" class="btn btn-primary">Filter</button>
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


            <div class="col-xl-12">
              <div class="card dz-card" id="accordion-three">
                <div class="card-header flex-wrap d-flex justify-content-between">
                  <div>
                    <h4 class="card-title">Profile Datatable</h4>

                  </div>
                  <!--   <ul class="nav nav-tabs dzm-tabs" id="myTab-2" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active " id="home-tab-2" data-bs-toggle="tab" data-bs-target="#withoutSpace" type="button" role="tab" aria-selected="true">Preview</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link " id="profile-tab-2" data-bs-toggle="tab" data-bs-target="#withoutSpace-html" type="button" role="tab"  aria-selected="false">HTML</button>
                    </li>
                  </ul> -->
                </div>

                <!-- /tab-content -->
                <div class="tab-content" id="myTabContent-2">
                  <div class="tab-pane fade show active" id="withoutSpace" role="tabpanel" aria-labelledby="home-tab-2">
                    <div class="card-body pt-0">
                      <div class="table-responsive">
                        <table class="display table" style="min-width: 845px">
                          <thead>
                            <tr>
                              <th></th>
                              <th>Name</th>
                              <th>Employee Code</th>
                              <th>Email</th>
                              <th>Join Date</th>
                              <th>Role</th>
                              <th>Salary</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($List as $key=>$val)
                            <tr>
                              <td>
                                <img src="{{ !empty($val->profileImage) ? url('/').'/'.$val->profileImage : url('/noimage.jpg') }}" class="rounded-circle" width="35" alt="User Image">
                              </td>
                              <td>{{ $val->name }}</td>
                              <td><a href="{{ route($prefix.'.team.profileView', $val->_id) }}"><strong>#{{ $val->employee_code }}</strong></a></td>
                              <td><a
                                  href="mailto:{{ $val->email }}"><strong>{{ $val->email }}</strong></a>
                              </td>
                              <td>{{ !empty($val->joinDate) ? date('d M Y', strtotime($val->joinDate)) : '--' }}</td>
                              <td><strong>{{ $val->department1->name }}</strong></td>
                              <td>{{ !empty($val->salary) ? '$'.number_format($val->salary,2) : '--' }}</td>
                             
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        {!! $List->links() !!}
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