<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="">
<title>CRM | Sellora</title>
<!-- plugins css -->
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet preload" href="{{url('/main')}}/assets/css/plugins.css" as="style">
<link rel="stylesheet preload" href="{{url('/main')}}/assets/css/style.css" as="style">
<!-- <link rel="stylesheet" href="{{url('/main')}}/assets/css/bootstrap.min.css"> -->
 <style>
  .parsley-required{
    color: red;
  }
  .error{
    color: red;
  }
  .parsley-type{
    color: red;
  }
  .parsley-minlength{
    color: red;
  }
  .parsley-equalto{
    color: red;
  }
 </style>
</head>

<body class="index-five">

<!-- rts header area start -->
<div class="rts-header-one-area-one career-header">
  <div class="rts-header-nav-area-one header--sticky careerheader-sticky">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="nav-and-btn-wrapper">
            <div class="nav-area-bottom-left-header-four career-head"> <a href="/" class="logo-area"> <img src="{{url('/main')}}/assets/images/logo-01.png"
                                        alt="logo-main" class="logo"> </a> 
              <!-- <div class="nav-area seller_nav">
                <nav>
                  <ul>
                    <li class="parent"> <a href="sell-online.html" class="current3">Sell Online</a> </li>
                    <li class="parent"><a href="fees-n-commission.html">Fees & Commission</a></li>
                    <li class="parent"><a href="grow.html">Grow</a></li>
                    <li class="parent"><a href="learn.html">Learn</a></li>
                  </ul>
                </nav>
              </div> --> 
            </div>
            <!-- <div class="right-btn-area header-five"> 
              <a href="login.html" class="start-selling">Login </a> 
              <a href="help.html" class="login_seller">Help </a> </div> -->
             
          </div>
        </div>
        <div class="col-lg-12">
          <div class="logo-search-category-wrapper after-md-device-header header-mid-five-call"> <a
                                href="/" class="logo-area"> <img src="{{url('/main')}}/assets/images/logo-01.png"
                                    alt="logo-main" class="logo"> </a>
            <div class="main-wrapper-action-2 d-flex">
             <!--  <div class="accont-wishlist-cart-area-header">
                <div class="after_login_seller"><a href="login.html" class="start-selling">Login</a> </div>
                <div class="after_login_seller"><a href="help.html">Help</a></div>
              </div> -->
              <div class="actions-area"> 
                
                <!--  <div class="menu-btn" id="menu-btn"> <svg width="20" height="16" viewBox="0 0 20 16"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect y="14" width="20" height="2" fill="#1F1F25"></rect>
                                            <rect y="7" width="20" height="2" fill="#1F1F25"></rect>
                                            <rect width="20" height="2" fill="#1F1F25"></rect>
                                        </svg> </div>   --> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- rts header area end --> 

<!-- rts header area start --> 
<!-- header style two --> 
<!-- <div id="side-bar" class="side-bar header-two">
  <button class="close-icon-menu"><i class="far fa-times"></i></button>
  <div class="mobile-menu-nav-area tab-nav-btn mt--20">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                    tabindex="0">
        <div class="mobile-menu-main">
          <nav class="nav-main mainmenu-nav mt--30">
            <ul class="mainmenu metismenu" id="mobile-menu-active">
              <li class="parent"> <a href="sell-online.html">Sell Online</a> </li>
              <li class="parent"><a href="fees-n-commission.html">Fees & Commission</a></li>
              <li class="parent"><a href="grow.html">Grow</a></li>
              <li class="parent"><a href="learn.html">Learn</a></li>
            </ul>
          </nav>
        </div>
      </div>
       
    </div>
  </div>
</div> -->

<div class="crm_login_section_1">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="text-center">
          <h1>Welcome to Sellora CRM</h1>
<!-- <p>Select Your Department and Log In</p> -->
 <h2>Access your personalized dashboard. Stay connected, stay productive!</h2>
          
        </div>
      </div>
     
      
    </div>


    <div class="row">
<div class="col-lg-12">
  
<div class="login-container">
  <div class="row">
    <div class="col-lg-8"> 
        <div class="login-form">
            <h2>Reset Password </h2>
            <div id="formLoader" style="display:none;">
                <p>Loading...</p>
            </div>
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
                <form id="resetForm" data-parsley-validate  method="post">
                @csrf
            <input type="hidden" name="id" value="{{ $token }}">
            <input type="hidden" name="teamType" value="{{ $req->teamType }}">
            <input type="email" class="input-field" placeholder="E-Mail Address" name="email" value="{{ $req->email }}" readonly required>
            <input type="password" class="input-field" 
                  id="password" 
                  name="password" 
                  placeholder="New Password" 
                  data-parsley-minlength="6" 
                  data-parsley-trigger="keyup" 
                  required>

            <input type="password" class="input-field" 
                  name="password_confirmation" 
                  placeholder="Confirm Password" 
                  data-parsley-equalto="#password" 
                  data-parsley-equalto-message="Passwords do not match" 
                  data-parsley-trigger="keyup" 
                  required>
           
            <p id="messageRes"></p>
            <button type="submit" class="login-button">Submit</button>
        </div>
      </div>
      <div class="col-lg-4"> 
        <div class="illustration">
            <!-- <img src="{{url('/main')}}/assets/images/login.jpg" alt="Login Illustration"> -->
        </div>
      </div>
    </div>
    </div>

</div>


    </div>
    
  </div>
</div>

 

 

 


 




<!-- rts footer one area end -->

<!-- <div class="rts-footer-area pt--50 bg_blue-footer">
  <div class="container-fluid">
    <div class="footer-main-content-wrapper">
      <div class="row">
        <div class="col-lg-3">
          <div class="single-footer-wized"> 
          
            <div class="footer-logo"><img src="{{url('/main')}}/assets/images/logo-01.png"></div>
            <div class="connect_footer">
              <p>Connect with millions of global B2B & B2C buyers effortlessly and unlock endless opportunities </p>
            </div>
            <div class="start_mmmm2"> <a href="sellora-start-selling-page-button.html">Start Selling</a> </div>
          </div>
        </div>
        <div class="col-lg-3 offset-lg-1">
          <div class="single-footer-wized">
            <h3 class="footer-title2">Solutions</h3>
            <div class="seller_footer-nav">
              <ul>
                <li><a href="#">B2B B2C ecommerce</a></li>
                <li><a href="#">Wholesale ecommerce</a></li>
                <li><a href="#">Success stories</a></li>
                <li><a href="#">Services</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="single-footer-wized">
            <h3 class="footer-title2">Sell on Sellora</h3>
            <div class="seller_footer-nav">
              <ul>
                <li><a href="sell-online.html">Sell Online</a></li>
                <li><a href="fees-n-commission.html">Fees & Commission</a></li>
                <li><a href="grow.html">Grow</a></li>
                <li><a href="learn.html">Learn</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-2" style="float:right;">
          <div class="single-footer-wized">
            <h3 class="footer-title2">Contact Us</h3>
            <div class="seller_footer-nav">
              <ul>
                <li><a href="mailto:sell@sellora.com">sell@sellora.com</a></li>
              </ul>
            </div>
            <div class="social-one-wrapper2 mt--30">
              <ul>
                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-whatsapp"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="seller_social-and-payment-area-wrapper d-lg-flex justify-content-lg-between">
    <div class="col-lg-4"> <a href="#" class="playstore-app-area2"> <span>Download App</span> <img src="{{url('/main')}}/assets/images/payment/02.png" alt=""> <img src="{{url('/main')}}/assets/images/payment/03.png" alt=""> </a> </div>
    <div class="col-lg-4">
      <div class="payment-access2"> Copyright 2024 <span>© Sellora</span> | All rights reserved. </div>
    </div>
    <div class="col-lg-4">
      <div class="term_n_condition">
        <ul>
          <li><a href="#">Term & Services</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
    </div>
    </ul>
  </div>
</div> -->
<!-- rts footer one area end --> 

<script defer src="{{url('/main')}}/assets/js/plugins.js"></script> 
<script defer src="{{url('/main')}}/assets/js/main.js"></script> 
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script> 
<!-- <script src="{{url('/main')}}/assets/js/bootstrap.min.js"></script> --> 
<script src="{{url('/main')}}/assets/js/jquery.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script type="text/javascript" src="https://parsleyjs.org/dist/parsley.js"></script>
<script src="https://cdn.jsdelivr.net/npm/parsleyjs"></script>

<!-- Toastr CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
 
  $(document).ready(function() {
    $('#resetForm').on('submit', function(e) {
        e.preventDefault();
        $('#formLoader').show();
        $('#messageRes').empty();
           $.ajax({
                url: " {{ url('reset-forgot-password') }}", 
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#formLoader').hide();
                    toastr.success('Reset Password Successfully!');
                    setTimeout(function() {
                        window.location.href = "{{ url('/login') }}?authType={{ $req->teamType }}"
                    }, 2000);
                },
                error: function(xhr) {
                    $('#formLoader').hide(); // Hide loader
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error('An unexpected error occurred.');
                    }
                }
            });
        
    });
});
</script>
</body>
</html>