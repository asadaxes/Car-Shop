@extends("general_base")
@section("title") CarShop - Verify Your Email @endsection
@section("style")

@endsection
@section("content")
<!--================================= inner-intro -->
<section class="inner-intro bg-1 bg-overlay-black-70">
    <div class="container">
        <div class="row text-center intro-title">
            <div class="col-12 text-center">
                <h1 class="text-white">Verify Your Email</h1>
            </div>
        </div>
    </div>
</section>
<!--================================= inner-intro -->
<!--================================= verify mail container -->
<form action="{{ route('verification.send') }}" method="POST">
@csrf
<div class="container">
<div class="card card-body py-5">
<div class="row">
<div class="col-12 text-center mb-3">
@if (session('status') == 'verification-link-sent')
<div class="alert alert-info fade show" role="alert">A new verification link has been sent to the email address you provided during registration.</div>
@endif
@if($errors->any() || session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    @if(session('error'))
        {{ session('error') }}
    @else
    <ul class="my-0 mx-2">
    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
    @endif
</div>
@endif
<div class="text-dark">Thanks for signing up 🎉 <br>Before getting started, could you verify your email address by clicking on the link we just emailed to you?<br>If you didn't receive the email, we will gladly send you another.</div>
</div>
<div class="col-12 text-center">
    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-envelope-circle-check"></i> Resend Verification Email</button>
</div>
</div>
</div>
</div>
</form>
<!--================================= verify mail container -->
@endsection
@section("script")

@endsection