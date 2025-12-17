<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
<!--Title-->
<title>Team</title>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content=" ">
<meta name="description" content=" ">

<!-- MOBILE SPECIFIC -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- FAVICONS ICON -->
<link rel="shortcut icon" type="{{ url('/admin') }}/image/x-icon" href="favicon.ico">
<link href="{{ url('/admin') }}/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
<link class="main-css" href="{{ url('/admin') }}/css/admin.css" rel="stylesheet">
</head>
<body style="background-image:url('admin/images/bg.png'); background-position:center;">
    <div class="authincation fix-wrapper">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a ><img src="{{url('/admin')}}/images/logo.png" alt=""></a>
									</div>
                                    <h4 class="text-center mb-4"></h4>
                                    @if(\Session::get('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <div class="alert-body">
                                            {{ \Session::get('success') }}
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif
                                    {{ \Session::forget('success') }}
                                    @if(\Session::get('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <div class="alert-body">
                                            {{ \Session::get('error') }}
                                        </div>
                                      
                                    </div>
                                    @endif
                                    <form data-parsley-validate action="{{route('team.auth.branch.submit')}}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="mb-1 form-label">Username</label>
                                            <input type="email" class="form-control" name="email" required placeholder="Enter username">
                                            @if ($errors->has('email'))
                                                <span class="help-block font-red-mint">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                        </div>
                                        
                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="dz-password">Password</label>
                                            <input type="password" id="dz-password" name="password" class="form-control" value="">
                                            <span class="show-pass eye">
                                                <i class="fa fa-eye-slash"></i>
                                                <i class="fa fa-eye"></i>
                                            </span>
                                            @if ($errors->has('password'))
                                            <span class="help-block font-red-mint">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                        </div>
                                    </form>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--**********************************
	Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{ url('/admin') }}/vendor/global/global.min.js"></script>
<script src="{{ url('/admin') }}/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
{{-- <script src="{{ url('/admin') }}/js/deznav-init.js"></script> --}}
<script src="{{ url('/admin') }}/js/custom.min.js"></script>
<script src="{{ url('/admin') }}/js/demo.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://parsleyjs.org/dist/parsley.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

@if(session('success'))

 <script>
    

     var type = 'success';
     switch(type){
             case 'success':
                 toastr.success("{{ session('success') }}");
                 break;
             }
 </script>
@endif
@if(session('error'))
 <script>
   

     var type = 'error';
     switch(type){
             case 'error':
                 toastr.error("{{ session('error') }}");
                 break;
             }
 </script>
@endif
</body> 
</html>