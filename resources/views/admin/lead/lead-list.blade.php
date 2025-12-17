@extends('admin.layouts.master')
@section('content')
@if(session()->has('admin'))
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
                            <h4 class="card-title">Unassigned Leads</h4>
                            @if(session()->has('branch'))
                            <span style="color:green;"><i class="fa fa-download"></i> <a href="{{ url('/') }}/Lead.xlsx" style="color:green;">Download Format</a></span>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <div class="needs-validation">
                                    <form>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label">Filter By From Date</label>
                                                <input type="date" name="from_date" max="{{ date('Y-m-d') }}" value="{{ Request::get('from_date') }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label">To Date</label>
                                                <input type="date" class="form-control" name="to_date" max="{{ date('Y-m-d') }}" value="{{ Request::get('to_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Requester's Mobile</label>
                                                <input type="text" name="mobile" class="form-control" value="{{ Request::get('mobile') }}" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="10">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label d-block">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        @if(session()->has('branch') || session()->has('team') && session()->get('team')->department=='67bd3cd7d4de44c0093ea46d')
                                        
                                        <div class="col-md-2">
                                        <label class="form-label d-block">&nbsp;</label>
                                            <button class="btn btn-primary" type="button" onclick="uploadBulkFile()"> Upload Bulk Lead</button>
                                        </div>
                                        @endif
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
                            <h4 class="card-title">Total List ({{ $List->total() }})</h4>
                        </div>
                        <div class="card-body">


                            <div class="row" style="margin-bottom: 10px;">

                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-styling table-hover table-striped table-primary">
                                            <thead>
                                                <tr>
                                                    <th>Requester Details</th>
                                                    <th>Date</th>
                                                    <th>Move To Sales</th>
                                                    <th>Request ID</th>
                                                    <!-- <th>Provider ID</th> -->
                                                    <th>City</th>
                                                    <th>Service Category</th>
                                                    <th>Requester Location</th>
                                                    <th width="50">Action</th>
                                                    <!-- <th>Assign to Sales Person</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($List as $key=>$val)
                                                @php 
                                                    $sale = \App\Models\ERP\Team::when($val, function($query) use($val){
                                                            $query->where('branchId', new ObjectId($val->branch));
                                                            
                                                        })
                                                        ->where('status','1')
                                                        ->where('department', new ObjectId('6790b8962ef8f2064c61d076'))//sales
                                                        ->orderBy('name','asc')->get();
                                                @endphp
                                                
                                                <tr>
                                                    <td valign="top"><strong>{{ $val->requester_name }}</strong><br>
                                                        <i class="ri-mail-line"></i> {{ $val->email }}<br>
                                                        <i class="ri-smartphone-line"></i>{{ $val->phone }}<br>
                                                        <a  class="orangestatus">Pending</a>
                                                    </td>
                                                    <td><i class="ri-calendar-line"></i>{{ date('d-m-Y', strtotime($val->created_at)) }}</td>
                                                    <td>
                                                        <form method="post" action="{{route($prefix.'.lead.assignLead')}}">
                                                            @csrf
                                                        <input type="hidden" name="leadId" value="{{$val->_id}}">
                                                        <select name="assign_to_sales" style="width: 100px!important;"
                                                            class="" tabindex="null" onchange="return submit()">
                                                            <option value="">Select</option>
                                                           @foreach($sale as $k=>$v)
                                                            <option value="{{ $v->_id }}">{{ $v->name }}</option>
                                                           @endforeach
                                                        </select>
                                                        </form>
                                                    </td>

                                                    <td valign="top">{{ $val->request_id }}</td>
                                                    <!-- <td valign="top"></td> -->
                                                    <td valign="top">{{ $val->city }}</td>
                                                    <td valign="top">{{ $val->service_category }}</td>
                                                    <td valign="top">{{ $val->requester_location }}</td>
                                                    <td valign="top"><a href="{{ route($prefix.'.lead.updateLead', $val->id) }}"> <i class="ri-edit-line"></i> </a>
                                                        <a href="{{ route($prefix.'.lead.deleteLead', $val->id) }}" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
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
@endsection
@section('javascript')
<!-- CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function uploadBulkFile() {
            Swal.fire({
                title: 'Upload Excel File',
            html: `
                <form id="uploadForm" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="fileToUpload" accept=".xls,.xlsx" class="swal2-input">
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Upload',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
            const fileInput = document.getElementById('fileToUpload');
            if (!fileInput.files.length) {
                Swal.showValidationMessage('Please select a file');
                return false;
            }
            return fileInput.files[0]; // Optional: you can return this if you want to use the file later
        }
        }).then((result) => {
            if (result.isConfirmed) {
                const file = document.getElementById('fileToUpload').files[0];
                const formData = new FormData();
                formData.append('fileToUpload', file);
                formData.append('_token', "{{ csrf_token() }}");

                // Show uploading modal with progress bar
                Swal.fire({
                    title: 'Uploading...',
                    html: `
                        <div id="progress-container" style="width: 100%; background-color: #eee; border-radius: 8px;">
                            <div id="progress-bar" style="width: 0%; height: 20px; background-color: #fc6e32; border-radius: 8px;"></div>
                        </div>
                        <div id="progress-percent" style="margin-top: 10px;">0%</div>
                    `,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        const xhr = new XMLHttpRequest();
                        xhr.open("POST", "{{ route($prefix.'.upload.bulkUploadLead') }}", true);

                        xhr.upload.onprogress = function (e) {
                            if (e.lengthComputable) {
                                const percent = Math.round((e.loaded / e.total) * 100);
                                document.getElementById('progress-bar').style.width = percent + '%';
                                document.getElementById('progress-percent').innerText = percent + '%';
                            }
                        };

                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                Swal.fire('Success', 'File uploaded successfully!', 'success');
                                location.reload();

                            } else {
                                Swal.fire('Error', 'Upload failed. Please try again.', 'error');
                            }
                        };

                        xhr.onerror = function () {
                            Swal.fire('Error', 'An error occurred during upload.', 'error');
                        };

                        xhr.send(formData);
                    }
                });
            }
        });
    }
</script>

@endsection
