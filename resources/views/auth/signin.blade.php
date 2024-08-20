@extends("general_base")
@section("title") CarShop - Sign in @endsection
@section("content")
<!--================================= inner-intro -->
 <section class="inner-intro bg-1 bg-overlay-black-70">
  <div class="container">
     <div class="row text-center intro-title">
         <div class="col-md-6 text-md-start d-inline-block">
             <h1 class="text-white">Sign in</h1>
           </div>
          <div class="col-md-6 text-md-end float-end">
         <ul class="page-breadcrumb">
           <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i></li>
           <li><span>Sign in</span></li>
         </ul>
      </div>
     </div>
  </div>
</section>
<!--================================= inner-intro -->
<!--================================= login-form -->
<section class="login-form page-section-ptb">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
         <div class="section-title">
           <h2>Sign in To Your Account</h2>
           <div class="separator"></div>
         </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-12">
      <form action="{{ route('signin_handler') }}" method="POST">
      @csrf
        <div class="gray-form clearfix">
          <div class="mb-3">
            <label for="email" class="form-label">Enter Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
          </div>
          <div class="mb-3">
            <label for="Password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="Password" required>
          </div>
          <div class="mb-3">
            <div class="remember-checkbox mb-4">
              <input type="checkbox" name="remember_me" id="remember_me">
              <label for="remember_me">Remember me</label>
              <a href="{{ route('password.request') }}" class="float-end">Forgot Password?</a>
            </div>
          </div>
          <div class="mb-3">
            {!! NoCaptcha::renderJs() !!}
            {!! NoCaptcha::display() !!}
          </div>
          <div class="d-grid">
            <button type="submit" class="button red btn-block">Sign in</button>
          </div>
        </div>
      </form>
        <div class="login-social text-center">
          <h5>or</h5>
          <ul>
            <li><a class="btn bg-white text-muted fw-bold border py-2" href="{{ route('google_auth') }}"><img src="{{ asset('images/google_logo.png') }}" class="img-fluid me-2" width="20"> Sign in with Google</a></li>
          </ul>
        </div>
        <div class="d-grid mt-4">
          <span>Don't have an account? <a href="{{ route('register') }}">Create one</a></span>
        </div>
      </div>
    </div>
  </div>
</section>
<!--================================= login-form -->
@endsection