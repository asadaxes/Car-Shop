@extends("general_base")
@section("title") CarShop - Verify Yourself @endsection
@section("style")
<style>
.mtb_6030{
  margin-top: 60px;
  margin-bottom: 30px;
}
</style>
@endsection
@section("content")
<div class="container mtb_6030">
<div class="card card-body mb-4">
    <div class="row">
        <div class="col-md-12 text-dark text-left text-center mb-2">
        <h1 class="text-danger"><i class="fas fa-user-shield fa-2x"></i></h1>
        <span class="text-dark">This is a secure area of the application. Please confirm your password before continuing.</span>
        </div>
        <div class="col-md-4 mx-auto">
        <form action="{{ route('password.confirm') }}" method="POST">
        @csrf
        <label for="password" class="mb-0">Enter your password</label>
        <input type="password" name="password" class="form-control mb-2" id="password" placeholder="******" required>
        <div class="text-center">
            <button type="submit" class="btn btn-success">Confirm</button>
        </div>
        </form>
        </div>
    </div>
</div>
</div>
@endsection