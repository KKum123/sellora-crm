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
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="py-1 mb-4"><span class="text-muted fw-light">Dashboard /</span> Change Password</h4>

                    <div class="row">
                        <form data-parsley-validate id="SpecialDietForm" action="{{ route($prefix.'.change.password.save') }}"
                            method="post">
                            
                            @csrf
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Old Password<span
                                                            class="error">*</span></label>
                                                    <input class="form-control" type="password" name="old_password"
                                                        value="{{ old('old_password') }}" required>
                                                    @error('old_password')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6"></div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="" class="form-label"> New Password<span
                                                            class="error">*</span></label>
                                                    <input class="form-control" type="password" name="new_password"
                                                        value="{{ old('new_password') }}" required>
                                                    @if (!empty($errors))
                                                        <p style="color:red">{{ $errors->first('new_password') }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6"></div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="" class="form-label"> Confirm Password<span
                                                            class="error">*</span></label>
                                                    <input class="form-control" type="password" name="confirm_password"
                                                        value="{{ old('confirm_password') }}" required>
                                                    @if (!empty($errors))
                                                        <p style="color:red">{{ $errors->first('confirm_password') }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6"></div>


                                            <div class="col-md-6">
                                                {{-- <div class="mb-3">
                                                    <label for="" class="form-label">Status<span
                                                            class="error">*</span></label>
                                                    <select class="form-select" name="status">
                                                        <option value="1">Active</option>
                                                        <option value="0">Deactive</option>
                                                    </select>
                                                </div>


                                            </div> --}}


                                            <button type="submit" class="btn btn-primary waves-effect waves-light"
                                                style="float: right;">Submit</button>
                                        </div>





                                    </div>
                                </div>
                            </div>
                            <!-- end -->


                    </div>
                    </form>
                </div>
            </div>
        </div>


@endsection
    @section('javascript')

    @endsection