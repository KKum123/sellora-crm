@extends('admin.layouts.master')
@section('content')
    @if (session()->has('admin'))
        @php $prefix = 'admin'; @endphp
    @elseif(session()->has('branch'))
        @php $prefix = 'branch'; @endphp
    @elseif(session()->has('team'))
        @php $prefix = 'team'; @endphp
    @endif
    @php 
      use MongoDB\BSON\ObjectId;
    @endphp
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Lead Tracker Report</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <div class="needs-validation">
                                    <form>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label">Filter By From Date</label>
                                                <input type="date" name="fromDate"  value="{{Request::get('fromDate')}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label">To Date</label>
                                                <input type="date" class="form-control" name="toDate"  value="{{Request::get('toDate')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Requester's Mobile</label>
                                                <input type="text" name="phone" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" maxlength="10" value="{{Request::get('phone')}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Lead Status</label>
                                                <select name="projectStatus" id="" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="Pending" {{!empty(Request::get('projectStatus')) && Request::get('projectStatus')=='Pending' ? 'selected' :''}}>Pending</option>
                                                    <option value="Pitch In Progress" {{!empty(Request::get('projectStatus')) && Request::get('projectStatus')=='Pitch In Progress' ? 'selected' :''}}>Pitch In Progress</option>
                                                    <option value="Not Reachable" {{!empty(Request::get('projectStatus')) && Request::get('projectStatus')=='Not Reachable' ? 'selected' :''}}>Not Reachable</option>
                                                    <option value="Not Interested" {{!empty(Request::get('projectStatus')) && Request::get('projectStatus')=='Not Interested' ? 'selected' :''}}>Not Interested</option>
                                                    <option value="Cancelled" {{!empty(Request::get('projectStatus')) && Request::get('projectStatus')=='Cancelled' ? 'selected' :''}}>Cancelled</option>
                                                    <option value="Completed" {{!empty(Request::get('projectStatus')) && Request::get('projectStatus')=='Completed' ? 'selected' :''}}>Completed</option>
                                                </select>
                                            </div>
                                        </div>
                                        @if(session()->has('admin') || session()->has('branch'))
                                        @else
                                        <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form-label">Client</label>
                                            <select name="client" id="client" class="form-select">
                                                <option value="">All Client</option>
                                                <option value="My Client" {{ Request::get('client') == 'My Client' ? 'selected' : '' }}>My Client</option>
                                            </select>
                                        </div>
                                        </div>
                                        @endif
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label d-block">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end -->

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Total Lead ({{ $List->total() }})</h4>
                        </div>
                        <div class="card-body">
                            <!-- <h5>Project Listing</h5><hr> -->
                            <div class="row" style="margin-bottom: 10px;">

                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-styling table-hover table-striped table-primary">
                                            <thead>
                                                <tr>
                                                    @if(session()->has('admin'))
                                                    <th>Country</th>
                                                    <th>Branch</th>
                                                    @endif
                                                    <th>Sales Person</th>
                                                    <th>Requester Details</th>
                                                    <th>Date</th>
                                                    <th>Follow Up</th>
                                                    <th>Request ID</th>
                                                    <!-- <th>Provider ID</th> -->
                                                    <th>City</th>
                                                    <th>Service Category</th>
                                                    <th>Requester Location</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($List as $key=>$val)
                                                @php 
                                                  $leadFollowUp = \App\Models\ERP\FollowUpLead::where('leadId', new ObjectId($val->_id))->orderBy('created_at','desc')->get();
                                               @endphp
                                               
                                                <tr>
                                                    @if (session()->has('admin'))
                                                    <td>{{$val->country}}</td>
                                                    <td>{{!empty($val->branches) ? $val->branches->branch_name : ''}}</td>
                                                    @endif
                                                    <td>{{!empty($val->assignedTeam) ? $val->assignedTeam->name : ''}}</td>
                                                    <td valign="top"><strong>{{$val->requester_name}}</strong><br>
                                                      <i class="ri-mail-line"></i> {{$val->email}}<br>
                                                      <i class="ri-smartphone-line"></i> {{$val->phone}}<br>
                                                        @if (count($leadFollowUp)>0)
                                                        @php 
                                                                $leadStatus = \App\Helpers\Helpers::statusColor($leadFollowUp[0]->projectStatus);
                                                            @endphp

                                                                {!! $leadStatus !!}
                                                            @else
                                                            <a href="#" class="orangestatus">Pending</a>
                                                        @endif
                                                     
                                                    </td>
                                                    <td><i class="ri-calendar-line"></i> {{date('d-m-Y', strtotime($val->created_at))}}</td>
                                                    <td>
                                                     <a href="#" style="color: blue" data-bs-toggle="modal" data-bs-target="#exampleModalB{{$val->_id}}"><i class="ri-eye-line"></i> View</a>
                                                    
                                                        
                        
                                                        <!-- Modal -->
                                                        <div class="modal fade followpopup" id="exampleModalB{{$val->_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                          <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content">
                                                              <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Request ID: #{{$val->request_id}}</h1>
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
                                                                      @foreach ($leadFollowUp as $k=>$v)
                                                                      <tr>
                                                                        <td>{{$k+1}}</td>
                                                                        <td>{{date('d-m-Y', strtotime($v->created_at))}}</td>
                                                                        <td>{{!empty($v->FollowUpDate) ? date('d-m-Y', strtotime($v->FollowUpDate)) : ''}}</td>
                                                                        <td>{{$v->remarks}}</td>
                                                                        <td>
                                                                         
                                                                          @php 
                                                                            $leadStatus1 = \App\Helpers\Helpers::statusColor($v->projectStatus);
                                                                          @endphp
                                                                          {!!$leadStatus1!!}
                                                                      </td>
                                                                      </tr>
                                                                      @endforeach
                                                                      
                                                                    </tbody>
                                                                  </table>
                                                                </div>
                                                              </div>
                                                              <!-- modal body end --> 
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <!-- Modal End -->
                                                    </td>
                                                    
                                                   
                                                    <td valign="top">{{$val->request_id}}</td>
                                                    <!-- <td valign="top"></td> -->
                                                    
                                                    <td valign="top">{{$val->city}}</td>
                                                    <td valign="top">{{$val->service_category}}</td>
                                                    <td valign="top">{{$val->requester_location}}</td>
                                                    {{-- <td valign="top"><a href="#"> <i class="ri-edit-line"></i> </a> <a href="#"> <i class="ri-close-line"></i> </a></td> --}}
                                                    
                                                  </tr> 
                                                @endforeach
                                                
                                                  
                                              </tbody>
                                        </table>
                                        <div class="pagination pagination-sm float-right paging"> 
                                            {!! $List->Links()!!}
                                        </div>
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
