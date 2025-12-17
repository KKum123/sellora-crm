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
function getDuration($joinDate) {
    $start = new DateTime($joinDate);  // Joining date
    $end = new DateTime();  // Current date

    $interval = $start->diff($end); 

    $years = $interval->y;
    $months = $interval->m;
    $duration = "$years years $months months";

    return date('M Y', strtotime($joinDate)) . " - Present ($duration)";
}
@endphp
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Profile</h4>
                    </div>
                </div>
            </div>
            <!-- end -->

            <div class="col-lg-12">
                <div class="card">


                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-view">
                                    <div class="profile-img-wrap">
                                        <div class="profile-img"> <a href="#"><img
                                                    src="{{url('/')}}/{{!empty($singleData->profileImage) ? $singleData->profileImage : 'noimage.jpg'}}"
                                                    style="max-height:200px;max-height:150px;
                                                    alt=" User Image"></a> </div>
                                    </div>
                                    <div class="profile-basic">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="profile-info-left">
                                                    <h3 class="user-name m-t-0 mb-0"> {{$singleData->name}}</h3>
                                                    <h6 class="text-muted">{{$singleData->designation1->name}}</h6>
                                                    <small class="text-muted">{{$singleData->department1->name}}</small>
                                                    <div class="staff-id">Employee Code : {{$singleData->employee_code}}
                                                    </div>
                                                    <div class="small doj text-muted">Date of Join :
                                                        {{!empty($singleData->joinDate) ? date('d M Y', strtotime($singleData->joinDate)) : '--'}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <ul class="personal-info">
                                                    <li>
                                                        <div class="title">Phone:</div>
                                                        <div class="text"><a href="#">{{$singleData->mobile}}</a></div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Email:</div>
                                                        <div class="text"><a href="#">{{$singleData->email}}</a></div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Birthday:</div>
                                                        <div class="text">
                                                            {{!empty($singleData->dateOfBirth) ? date('df Y', strtotime($singleData->dateOfBirth)) : '--'}}
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Address:</div>
                                                        <div class="text">{{$singleData->address}}</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Gender:</div>
                                                        <div class="text">{{$singleData->gender}}</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Salary:</div>
                                                        <div class="text">{{$singleData->salary}}</div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pro-edit"><a data-bs-target="#profile_info" data-bs-toggle="modal"
                                            class="edit-icon" href="#"><i class="fa-solid fa-pencil"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end -->

        </div>
        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title">Personal Informations
                            <a href="#" class="edit-icon" data-bs-toggle="modal"
                                data-bs-target="#personal_info_modal"><i class="fa-solid fa-pencil"></i></a>
                        </h3>
                        <ul class="personal-info">
                            <li>
                                <div class="title">Passport No.</div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->passportNo : '--'}}</div>
                            </li>
                            <li>
                                <div class="title">Passport Exp Date.</div>
                                <div class="text">{{!empty($personalInfo) ? date('d M Y', strtotime($personalInfo->passportExpDate)) : '--'}}</div>
                            </li>
                            <li>
                                <div class="title">Tel</div>
                                <div class="text"><a href="#">{{!empty($personalInfo) ? $personalInfo->tel : '--'}}</a></div>
                            </li>
                            <li>
                                <div class="title">Nationality</div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->nationality : '--'}}</div>
                            </li>
                            <li>
                                <div class="title">Religion</div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->religion : '--'}}</div>
                            </li>
                            <li>
                                <div class="title">Marital status</div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->maritalStatus : '--'}}</div>
                            </li>
                            <li>
                                <div class="title">Employment of spouse</div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->employmentOfSpouse : '--'}}</div>
                            </li>
                            @if(!empty($personalInfo) && $personalInfo->maritalStatus=='Married')
                                <li>
                                    <div class="title">No. of children</div>
                                    <div class="text">{{!empty($personalInfo) ? $personalInfo->noOfChildren : '--'}}</div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title">Emergency Contact
                            <a href="#" class="edit-icon" data-bs-toggle="modal"
                                data-bs-target="#emergency_contact_modal"><i class="fa-solid fa-pencil"></i></a>
                        </h3>
                        <h5 class="section-title">Primary</h5>
                        <ul class="personal-info">
                            <li>
                                <div class="title">Name</div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->primaryName : '--'}}</div>
                            </li>
                            <li>
                                <div class="title">Relationship</div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->primaryRelationship : '--'}}</div>
                            </li>
                            <li>
                                <div class="title">Phone </div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->primaryPhone : '--'}}</div>
                            </li>
                        </ul>
                        <hr>
                        <h5 class="section-title">Secondary</h5>
                        <ul class="personal-info">
                            <li>
                                <div class="title">Name</div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->secondaryName : '--'}}</div>
                            </li>
                            <li>
                                <div class="title">Relationship</div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->secondaryRelationship : '--'}}</div>
                            </li>
                            <li>
                                <div class="title">Phone </div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->secondaryPhone : '--'}}</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title">Bank information
                            <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#bank_information"><i
                                    class="fa-solid fa-pencil"></i></a>
                        </h3>
                        <ul class="personal-info">
                            <li>
                                <div class="title">Bank name</div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->bankName : '--'}}</div>
                            </li>
                            <li>
                                <div class="title">Bank account No.</div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->bankAccountNo : '--'}}</div>
                            </li>
                            <li>
                                <div class="title">IFSC Code</div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->IFSCCode : '--'}}</div>
                            </li>
                            <li>
                                <div class="title">PAN No</div>
                                <div class="text">{{!empty($personalInfo) ? $personalInfo->panNo : '--'}}</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title">Family Informations
                            <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#family_info_modal"><i
                                    class="fa-solid fa-pencil"></i></a>
                        </h3>
                        <div class="table-responsive">
                            <table class="table table-nowrap">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Relationship</th>
                                        <th>Date of Birth</th>
                                        <th>Phone</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($familyInformations as $key=>$val)
                                    <div id="family_info_modal_{{$val->_id}}" class="modal custom-modal fade" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Family Informations</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span
                                                            aria-hidden="true">&times;</span> </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{route($prefix . '.team.saveTeamFamily')}}" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$singleData->_id}}">
                                                        <input type="hidden" name="familyid" value="{{$val->_id}}">

                                                        <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Name</label>
                                                                <input type="text" name="name" class="form-control" value="{{$val->name}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Relationship</label>
                                                                <input type="text" name="relationship" value="{{$val->relationship}}"  class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Date of Birth</label>
                                                                <input type="date" name="dateOfBirth" class="form-control" value="{{$val->dateOfBirth}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Phone</label>
                                                                <input type="text" name="phone" value="{{$val->phone}}" maxlength="10" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" class="form-control" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" maxlength="10">
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <div class="submit-section">
                                                            <button class="btn btn-primary submit-btn">Submit</button>
                                                        </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <tr>
                                        <td>{{$val->name}}</td>
                                        <td>{{$val->relationship}}</td>
                                        <td>{{date('M d Y', strtotime($val->dateOfBirth))}}</td>
                                        <td>{{$val->phone}}</td>
                                        <td class="text-end">
                                            <a a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#family_info_modal_{{$val->_id}}"  class="dropdown-item"><i
                                                    class="fa-solid fa-pencil m-r-5"></i>
                                                </a>
                                                 <a href="{{route($prefix.'.team.deleteFamily',$val->id)}}"
                                                class="dropdown-item" onclick="return confirm('Are you sure delete this?')">
                                                <i class="fa-regular fa-trash-can m-r-5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title">Education Informations
                            <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#education_info"><i
                                    class="fa-solid fa-pencil"></i></a>
                        </h3>
                        <div class="experience-box">
                            <ul class="experience-list">
                                @foreach ($educationInformation as $key=>$val)
                                
                               
                                <li>
                                    <div class="experience-user">
                                        <div class="before-circle"></div>
                                    </div>
                                    <div class="experience-content">
                                        <div class="timeline-content">
                                             <a href="#/" class="name">{{$val->collegeName}}</a>
                                            <div>{{$val->streem}}</div>
                                            <span class="time">{{$val->fromDate}} - {{$val->toDate}} <a href="{{route($prefix.'.team.deleteEducation',$val->_id)}}" onclick="return confirm('Are you sure delete this?')"><i class="fa-regular fa-trash-can m-r-5"></i></a></span>
                                        </div>
                                    </div>
                                    
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title">Experience <a href="#" class="edit-icon" data-bs-toggle="modal"
                                data-bs-target="#experience_info"><i class="fa-solid fa-pencil"></i></a></h3>
                        <div class="experience-box">
                            <ul class="experience-list">
                                @foreach ($experience as $key=>$val)
                                    <li>
                                        <div class="experience-user">
                                            <div class="before-circle"></div>
                                        </div>
                                        <div class="experience-content">
                                            <div class="timeline-content"> <a href="#/" class="name">{{$val->companyName}}</a> <span class="time">{{getDuration($val->joinDate)}} 
                                            <a href="{{route($prefix.'.team.deleteExperience',$val->_id)}}" onclick="return confirm('Are you sure delete this?')"><i class="fa-regular fa-trash-can m-r-5"></i></a>
                                            </span> 
                                           
                                        </div>
                                        </div>
                                    </li>
                                @endforeach
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 1 -->
<div id="profile_info" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profile Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route($prefix . '.team.saveTeam')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$singleData->_id}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-img-wrap edit-img">
                                <img class="inline-block profile-pic"
                                    src="{{url('/')}}/{{!empty($singleData->profileImage) ? $singleData->profileImage : 'noimage.jpg'}}"
                                    alt="User Image" style="max-width: 150px;max-height: 200px">
                                <div class="fileupload btn"> <span class="btn-text">edit
                                        <i>250X300</i>
                                    </span>

                                    <input class="file-upload" type="file" name="profileImage" accept="image/*" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{$singleData->name}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Employee Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="employee_code"
                                            value="{{$singleData->employee_code}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Birth Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" name="dateOfBirth" type="date"
                                                value="{{$singleData->dateOfBirth}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Gender</label>
                                        <select class="select form-control" name="gender">
                                            <option value="Male" {{$singleData->gender == 'Male' ? 'selected' : ''}}>Male
                                            </option>
                                            <option value="Female" {{$singleData->gender == 'Female' ? 'selected' : ''}}>
                                                Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Address</label>
                                <input type="text" class="form-control" name="address" value="{{$singleData->address}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Country</label>
                                <select name="countryId" id="" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($country as $key => $val)
                                        <option value="{{$val->_id}}" {{$singleData->countryId == $val->_id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">State</label>
                                <input type="text" class="form-control" name="state" value="{{$singleData->state}}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Pin Code</label>
                                <input type="text" class="form-control" value="{{$singleData->pinCode}}" name="pinCode">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Phone Number</label>
                                <input type="text" class="form-control" value="{{$singleData->mobile}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Department <span class="text-danger">*</span></label>
                                <select class="form-control" name="department" required>
                                    <option value="">Select</option>
                                    @foreach ($department as $key => $val)
                                        <option value="{{$val->_id}}" {{$singleData->department == $val->_id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Designation <span class="text-danger">*</span></label>
                                <select class="form-control" name="designation" required>
                                    <option value="">Select</option>
                                    @foreach ($designation as $key => $val)
                                        <option value="{{$val->_id}}" {{$singleData->designation == $val->_id ? 'selected' : ''}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Reports To <span class="text-danger">*</span></label>
                                <select class="form-control" name="reportsTo" required>
                                    <option value="">--</option>
                                    <option {{$singleData->reportsTo == 'Wilmer Deluna' ? 'selected' : ''}}>Wilmer Deluna
                                    </option>
                                    <option {{$singleData->reportsTo == 'Lesley Grauer' ? 'selected' : ''}}>Lesley Grauer
                                    </option>
                                    <option {{$singleData->reportsTo == 'Jeffery Lalor' ? 'selected' : ''}}>Jeffery Lalor
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Join Date <span class="text-danger">*</span></label>
                                <input type="date" name="joinDate" class="form-control"
                                    value="{{$singleData->joinDate}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Salary<span class="text-danger">*</span></label>
                                <input type="text" name="salary" class="form-control"
                                    onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"
                                    value="{{$singleData->salary}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 2 -->
<div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Personal Informations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">&times;</span> </button>
            </div>
            <form method="post" action="{{route($prefix . '.team.savePersonalInTeam')}}" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id" value="{{$singleData->_id}}">

                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Passport No.</label>
                                  <input type="text" name="passportNo" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->passportNo : ''}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Passport Exp Date.</label>
                                <input type="date" name="passportExpDate" class="form-control"
                                value="{{!empty($personalInfo) ? $personalInfo->passportExpDate : ''}}" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Tel</label>
                                <input type="text" name="tel" class="form-control"
                                    onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" maxlength="10" value="{{!empty($personalInfo) ? $personalInfo->tel : ''}}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Nationality</label>
                                  <input type="text" name="nationality" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->nationality : ''}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">religion</label>
                                  <input type="text" name="religion" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->religion : ''}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Marital status</label>
                                 
                                <select name="maritalStatus" id="maritalStatus" class="form-control">
                                    <option value="">---</option>
                                    <option {{!empty($personalInfo) && $personalInfo->maritalStatus=='Married' ? 'selected' : ''}}>Married</option>
                                    <option {{!empty($personalInfo) && $personalInfo->maritalStatus=='Unmarried' ? 'selected' : ''}}>Unmarried</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Employment of spouse</label>
                                  <input type="text" name="employmentOfSpouse" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->employmentOfSpouse : ''}}"> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">No. of children</label>
                                  <input type="text" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" name="noOfChildren" id="noOfChildren" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->noOfChildren : ''}}">
                            </div>
                        </div>

                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 3 -->
<div id="emergency_contact_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Emergency Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route($prefix . '.team.savePersonalInTeam')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$singleData->_id}}">
                    <div class="row">
                    <div class="col-md-12">Primary</div>
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Name</label>
                            <input type="text" name="primaryName" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->primaryName : ''}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Relationship</label>
                            <input type="text" name="primaryRelationship" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->primaryRelationship : ''}}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Phone</label>
                            <input type="text" name="primaryPhone" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" maxlength="10" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->primaryPhone : ''}}">
                        </div>
                    </div>
                    <div class="col-md-12">Secondary</div>
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Name</label>
                            <input type="text" name="secondaryName" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->secondaryName : ''}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Relationship</label>
                            <input type="text" name="secondaryRelationship" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->secondaryRelationship : ''}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Phone</label>
                            <input type="text" name="secondaryPhone" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" maxlength="10" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->secondaryPhone : ''}}">
                        </div>
                    </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- 4 -->
<div id="bank_information" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bank information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route($prefix . '.team.savePersonalInTeam')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$singleData->_id}}">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Bank name</label>
                            <input type="text" name="bankName" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->bankName : ''}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Bank account No.</label>
                            <input type="text" name="bankAccountNo" class="form-control" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" value="{{!empty($personalInfo) ? $personalInfo->bankAccountNo : ''}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">IFSC Code</label>
                            <input type="text" name="IFSCCode" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->IFSCCode : ''}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">PAN No</label>
                            <input type="text" name="panNo" class="form-control" value="{{!empty($personalInfo) ? $personalInfo->panNo : ''}}">
                        </div>
                    </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- 5 -->
<div id="family_info_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Family Informations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route($prefix . '.team.saveTeamFamily')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$singleData->_id}}">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Relationship</label>
                            <input type="text" name="relationship"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Date of Birth</label>
                            <input type="date" name="dateOfBirth" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Phone</label>
                            <input type="text" name="phone"  maxlength="10" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" class="form-control" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" maxlength="10">
                        </div>
                    </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- 6 -->
<div id="education_info" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Education Informations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route($prefix . '.team.saveTeamEducation')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$singleData->_id}}">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">College Name</label>
                            <input type="text" name="collegeName" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Streem</label>
                            <input type="text" name="streem" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-block mb-3">
                            <label class="col-form-label">From Date</label>
                            <input type="number"  min="1900" max="2099" step="1" value="<?= date('Y') ?>" name="fromDate" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-block mb-3">
                            <label class="col-form-label">To Date</label>
                            <input type="number"  min="1900" max="2099" step="1" value="<?= date('Y') ?>" name="toDate" class="form-control">
                        </div>
                    </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- 7 -->
<div id="experience_info" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Experience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route($prefix.'.team.saveExperienceTeam')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$singleData->_id}}">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="companyName" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-block mb-3">
                            <label class="col-form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="joinDate" class="form-control">
                        </div>
                    </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('javascript')
<script>
    $(document).ready(function () {
        var readURL = functi(input) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(".profile-pic").attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    };

    $(".file-upload").on("change", function () {
        readURL(this);
    });

    $(".upload-button").on("click", function () {
        $(".file-upload").click();
    });
});

</script>
@endsection