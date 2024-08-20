@extends("general_base")
@section("title") CarShop - Create an Account @endsection
@section("style")

@endsection
@section("content")
<!--================================= inner-intro -->
 <section class="inner-intro bg-1 bg-overlay-black-70">
  <div class="container">
     <div class="row text-center intro-title">
         <div class="col-md-6 text-md-start d-inline-block">
             <h1 class="text-white">Register</h1>
           </div>
          <div class="col-md-6 text-md-end float-end">
         <ul class="page-breadcrumb">
           <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i></li>
           <li><span>Register</span></li>
         </ul>
      </div>
     </div>
  </div>
</section>
<!--================================= inner-intro -->
<!--================================= register-form -->
<section class="register-form page-section-ptb">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
         <div class="section-title">
           <span>Welcome</span>
           <h2>Sign up and join with us</h2>
           <div class="separator"></div>
         </div>
      </div>
    </div>
    <div class="row justify-content-center">
       <div class="col-lg-6 col-md-12">
      <form action="{{ route('register_handler') }}" method="POST">
      @csrf
        <div class="gray-form">
            <div class="mb-3">
              <label for="full_name" class="form-label">Full Name</label>
              <input type="text" name="full_name" class="form-control" id="full_name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" required>
            </div>           
            <div class="row">
            <div class="mb-3 col-md-6">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3 col-md-6">
              <label for="password_confirmation" class="form-label">Confirm Password</label>
              <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
            </div>
            </div>
            <div class="mb-3">
              {!! NoCaptcha::renderJs() !!}
              {!! NoCaptcha::display() !!}
            </div>
            <div class="mb-3">
              <div class="remember-checkbox">
                <input type="checkbox" name="agreement" id="agreement">
                <label for="agreement">Accept our <a href=""> Privacy Policy</a> and <a href=""> Terms & Conditions</a></label>
              </div>
            </div>
            <button type="submit" class="button red">Register an account</button>
            <p class="link">Already have an account? please <a href="{{ route('signin') }}"> login here </a></p>
        </div>
      </form>
        </div>
       </div>
    </div>
</section>
<!--================================= register-form -->
@endsection
@section("script")

@endsection